<?php
/**
 * Google Analytics
 *
 * @category class
 * @package Google Analytics
 * @author Saravana
 * Created at: 02-Feb-2019
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Google_analytic extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->module('admin_header');
		$this->load->model('Google_analytic_model');
		$this->load->library("Excel");
	}

	// Index

	function index()
	{
		$google_analytics_data = $this->Google_analytic_model->get_google_analytics($this->admin_header->website_id());
		if (!empty($google_analytics_data)):
			$data['id'] = $google_analytics_data[0]->id;
			$data['analytic_code'] = $google_analytics_data[0]->analytic_code;
			$data['key_json_file'] = $google_analytics_data[0]->key_json_file;
			$data['status'] = $google_analytics_data[0]->status;
		else:
			$data['id'] = "";
			$data['analytic_code'] = "";
			$data['key_json_file'] = "";
			$data['status'] = "";
		endif;
		$data['heading'] = 'Google Analytics';
		$data['title'] = "Google Analytics | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('google_analytic_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert Update

	function insert_update()
	{
		$file = $this->input->post('file-upload');
		if (isset($file) && !empty($file)):
			$data = array(
				'upload_data' => array(
					'file_name' => $file
				) ,
				'website_id' => $this->admin_header->website_id()
			);
			$this->Google_analytic_model->insert_update($data);
			redirect('google_analytic');
		else:
			$config['upload_path'] = 'assets/google-analytic/files';
			$config['allowed_types'] = 'text/json';
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('file-upload')):
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('google_analytic');
			else:
				$data = array(
					'upload_data' => $this->upload->data() ,
					'website_id' => $this->admin_header->website_id()
				);
				$this->Google_analytic_model->insert_update($data);
				redirect('google_analytic');
			endif;
		endif;
	}

	// Google Analytics Reports

	function reports()
	{
        $google_analytics_data = array();
        $website_id = $this->admin_header->website_id();
        $key_file = $this->Google_analytic_model->get_key_file($website_id);
        if(!empty($key_file)) :
            $originalDate = $key_file[0]->created_at;
            $start = date("Y-m-d", strtotime($originalDate));
            //$start = 'yesterday';
            $end = 'today';

            $analytics = $this->initializeAnalytics($key_file[0]->key_json_file);
            if (!empty($analytics)):
            
                $profile_id = $this->getFirstProfileId($analytics);
                $getResults = $this->getResults($analytics, $profile_id, $start, $end);
                $printResults = $this->printResults($getResults);
                $get_user_type = $this->user_type($analytics, $profile_id, $start, $end);
                $traffic_sources = $this->traffic_sources($analytics, $profile_id, $start, $end);
                $get_device = $this->get_device($analytics, $profile_id, $start, $end);
                $geo_network = $this->geo_network($analytics, $profile_id, $start, $end);
				$page_tracking = $this->page_tracking($analytics, $profile_id, $start, $end);
				
				$user_details = $this->user_details($analytics, $profile_id, $start, $end);
				$get_sessions = $this->get_sessions($analytics, $profile_id, $start, $end);
				$get_goal_conversion = $this->get_goal_conversion($analytics, $profile_id, $start, $end);
				$get_operating_system = $this->get_operating_system($analytics, $profile_id, $start, $end);
				$get_browser = $this->get_browser($analytics, $profile_id, $start, $end);
				$get_source = $this->get_source($analytics, $profile_id, $start, $end);
                $get_graph_reports = $this->get_graph_reports($analytics, $profile_id, $start, $end);
                
                $get_tracking_reports = $this->tracking_reports($analytics, $profile_id, $start, $end);

				$get_page_not_found = $this->page_not_found($analytics, $profile_id, $start, $end);
    
                $google_analytics_data = array(
                    'profile_id' => $profile_id,
                    'user_type' => $get_user_type,
                    'traffic_source' => $traffic_sources,
                    'device' => $get_device,
                    'geo_network' => $geo_network,
                    'page_tracking' => $page_tracking,
                    'total_users' => $printResults,
                    'results' => $getResults,
					'start_date' => $start,
					'user_details' => $user_details,
					'sessions' => $get_sessions,
					'goal_conversion' => $get_goal_conversion,
					'operating_system' => $get_operating_system,
					'browser' => $get_browser,
					'source' => $get_source,
                    'get_graph_reports' => $get_graph_reports,
                    'tracking_reports' => $get_tracking_reports,
					'page_not_found' => $get_page_not_found
                );
				return $google_analytics_data;
            endif;
        endif;        
	}

	// Initialize Analytics

	function initializeAnalytics($key_json_file)
	{		
		require_once APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'google-analytics' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

		$key_file_path = 'assets/google-analytic/files';	

        // Creates and returns the Analytics Reporting service object.
        // Use the developers console and download your service account
        // credentials in JSON format. Place them in this directory or
        // change the key file location if necessary.

        $KEY_FILE_LOCATION = $key_file_path. DIRECTORY_SEPARATOR .$key_json_file;

        // Create and configure a new client object.

        $client = new Google_Client();
        $client->setApplicationName("Hello Analytics Reporting");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new Google_Service_Analytics($client);
        return $analytics;		
	}

	// Get Profile Id

	function getFirstProfileId($analytics)
	{
		// Get the user's first view (profile) ID.
		// Get the list of accounts for the authorized user.

		$accounts = $analytics->management_accounts->listManagementAccounts();
		if (count($accounts->getItems()) > 0)
		{
			$items = $accounts->getItems();
			$firstAccountId = $items[0]->getId();

			// Get the list of properties for the authorized user.

			$properties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId);
			if (count($properties->getItems()) > 0)
			{
				$items = $properties->getItems();
				$firstPropertyId = $items[0]->getId();

				// Get the list of views (profiles) for the authorized user.

				$profiles = $analytics->management_profiles->listManagementProfiles($firstAccountId, $firstPropertyId);
				if (count($profiles->getItems()) > 0)
				{
					$items = $profiles->getItems();

					// Return the first view (profile) ID.

					return $items[0]->getId();
				}
				else
				{
					throw new Exception('No views (profiles) found for this user.');
				}
			}
			else
			{
				throw new Exception('No properties found for this user.');
			}
		}
		else
		{
			throw new Exception('No accounts found for this user.');
		}
	}

	/**
	 * Get user Type
	 */
	function user_type($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:users', array(
			'dimensions' => 'ga:pagePath, ga:userType',
			'metrics' => 'ga:pageviews'
		));
		return $res->getRows();
	}

	/**
	 * Get User Details
	 */
	function user_details($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:newUsers');
		return $res->getRows();		
	}

	/**
	 * Get Sessions
	 */
	function get_sessions($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:sessions, ga:bounceRate');
		return $res->getRows();
	}

	/**
	 * Get Goal Conversion
	 */
	function get_goal_conversion($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:goalConversionRateAll');
		return $res->getRows();		
	}

	/**
	 * Get Operating System
	 */
	function get_operating_system($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:users', array(
			'dimensions' => 'ga:operatingSystem'));
		return $res->getRows();	
	}

	/**
	 * Get Browser
	 */
	function get_browser($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:users', array(
			'dimensions' => 'ga:browser'));
		return $res->getRows();			
	}

	/**
	 * Get Source
	 */
	function get_source($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:users', array(
			'dimensions' => 'ga:source'));
		return $res->getRows();			
	}

	/**
	 * Get Reports for Graph
	 */
	function get_graph_reports($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:sessions, ga:users, ga:pageviews', array(
			'dimensions' => 'ga:country, ga:date',
			'sort' => 'ga:date',
			'max-results' => 10
		  ));
		return $res->getRows();
	}

	/**
	 * Get Traffic Sources
	 */
	function traffic_sources($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:users', array(
			'dimensions' => 'ga:pagePath, ga:referralPath, ga:source, ga:sourceMedium, ga:keyword'
		));
		return $res->getRows();
	}

	/**
	 * Get Device
	 */
	function get_device($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:users', array(
			'dimensions' => 'ga:pagePath, ga:browser, ga:operatingSystem, ga:deviceCategory, ga:dataSource, ga:keyword'
		));
		return $res->getRows();
	}

	/**
	 * Get Geo Network
	 */
	function geo_network($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:users', array(
			'dimensions' => 'ga:pagePath, ga:country, ga:region, ga:city, ga:networkDomain, ga:networkLocation'
		));
		return $res->getRows();
	}

	/**
	 * Page Tracking
	 */
	function page_tracking($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:users', array(
			'dimensions' => 'ga:pagePath, ga:hostname, ga:pageTitle, ga:landingPagePath, ga:exitPagePath, ga:pageDepth'
		));
		return $res->getRows();
	}

	function getResults($analytics, $profileId, $start, $end)
	{
		// Calls the Core Reporting API and queries for the number of sessions
		// for the last seven days.

		return $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:users');
	}

	function printResults($results)
	{
		// Parses the response from the Core Reporting API and prints
		// the profile name and total sessions.

		if (count($results->getRows()) > 0)
		{

			// Get the profile name.

			$profileName = $results->getProfileInfo()->getProfileName();

			// Get the entry for the first entry in the first row.

			$rows = $results->getRows();
			$sessions = $rows[0][0];

            // Print the results.
            
            return $sessions;
		}
		else
		{
			return "No results found.";
		}
	}

    /**
     * Get Page not found - tried but not successfull (This is dummy)
     */
	function page_not_found($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:uniquePageviews', array(
			'dimensions' => 'ga:pagePath, ga:fullReferrer, ga:pageTitle',
			'filters' => 'ga:previousPagePath==entrancs&ga:pageTitle==404',
		));
		return $res->getRows();
    }
    
    /**
     * Tracking Reports
     */	
	function tracking_reports($analytics, $profileId, $start, $end)
	{
		$res = $analytics->data_ga->get('ga:' . $profileId, $start, $end, 'ga:users', array(
			'dimensions' => 'ga:date, ga:country, ga:city, ga:browser, ga:pagePath'
		));
		return $res->getRows();
	}

	/**
	 * Tracking Reports for CRON JOB
	 */
	function daily_tracking_reports()
	{
		$website_id = $this->admin_header->website_id();
        $key_file = $this->Google_analytic_model->get_key_file($website_id);
		if(!empty($key_file)) :
			$analytics = $this->initializeAnalytics($key_file[0]->key_json_file);
            if (!empty($analytics)):            
				$profile_id = $this->getFirstProfileId($analytics);
				$daily_tracking_reports = $this->tracking_reports($analytics, $profile_id, 'yesterday', 'today');

				$current_date = date('Y-m-d');
				$date = date('m-d-Y', (strtotime('-1 day', strtotime($current_date))));

				if (!empty($daily_tracking_reports)) :
				
					// Create new PHPExcel object
					$objPHPExcel = new PHPExcel();
				
					$default_border = array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					);
				
					$acc_default_border = array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => 'c7c7c7'),
					);
					$outlet_style_header = array(
						'font' => array(
							'color' => array('rgb' => '000000'),
							'size' => 10,
							'name' => 'Arial',
							'bold' => true,
						),
					);
					$top_header_style = array(
						'borders' => array(
							'bottom' => $default_border,
							'left' => $default_border,
							'top' => $default_border,
							'right' => $default_border,
						),
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'ffff03'),
						),
						'font' => array(
							'color' => array('rgb' => '000000'),
							'size' => 15,
							'name' => 'Arial',
							'bold' => true,
						),
						'alignment' => array(
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						),
					);
					$style_header = array(
						'borders' => array(
							'bottom' => $default_border,
							'left' => $default_border,
							'top' => $default_border,
							'right' => $default_border,
						),
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'ffff03'),
						),
						'font' => array(
							'color' => array('rgb' => '000000'),
							'size' => 12,
							'name' => 'Arial',
							'bold' => true,
						),
						'alignment' => array(
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						),
					);
					$account_value_style_header = array(
						'borders' => array(
							'bottom' => $default_border,
							'left' => $default_border,
							'top' => $default_border,
							'right' => $default_border,
						),
						'font' => array(
							'color' => array('rgb' => '000000'),
							'size' => 12,
							'name' => 'Arial',
						),
						'alignment' => array(
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						),
					);
					$text_align_style = array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						),
						'borders' => array(
							'bottom' => $default_border,
							'left' => $default_border,
							'top' => $default_border,
							'right' => $default_border,
						),
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'ffff03'),
						),
						'font' => array(
							'color' => array('rgb' => '000000'),
							'size' => 12,
							'name' => 'Arial',
							'bold' => true,
						),
					);
				
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
					$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Tracking Report - ' . $date);
				
					$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
					$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
					$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
					$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
					$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
					
				
					$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Date');
					$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Country');
					$objPHPExcel->getActiveSheet()->setCellValue('C2', 'City');
					$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Source');
					$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Url');
					
				
					$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
					$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
					$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
					$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
					$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
					$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
					$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
					$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
					$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
					
					$row = 3;
					
					foreach ($daily_tracking_reports as $value)
					{					
						$track_date = substr($value[0], 4, 2) . "/" . substr($value[0], 6, 2) . "/" . substr($value[0], 0, 4);
						
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $track_date);
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $value[1]);
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $value[2]);
						$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $value[3]);
						$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $value[4]);
						$row++;
					}

					$filename = $date . '-Tracking.xls';
				
					header('Content-Type: application/vnd.ms-excel');
					header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
					header('Cache-Control: max-age=0');
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					$objWriter->save("reports/$filename");

				endif;

			endif;
		endif;		
	}
}
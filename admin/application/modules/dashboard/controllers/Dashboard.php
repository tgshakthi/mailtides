<?php
/**
 * Admin Dashboard
 *
 * @category class
 * @package  Admin Dashboard
 * @author   Saravana
 * Created at:  12-Mar-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model');
		$this->load->module('admin_header');
		$this->load->module('google_analytic');
	}

	function index()
	{
		$data['page_not_found_urls'] = $this->get_page_not_found();
		$data['google_analytics_data'] = $this->google_analytic->reports();
		  
		if (!empty($data['google_analytics_data'])) :
			$data['from_date'] = $data['google_analytics_data']['start_date'];
			$data['user_types'] = $data['google_analytics_data']['user_type'];
			$data['total_users'] = $data['google_analytics_data']['total_users'];
			$data['geo_network'] = $data['google_analytics_data']['geo_network'];
			$data['sessions'] = $data['google_analytics_data']['sessions'];
			$data['goal_conversion'] = $data['google_analytics_data']['goal_conversion'];
			$data['user_details'] = $data['google_analytics_data']['user_details'];
			if (!empty($data['google_analytics_data']['operating_system'])):
				foreach($data['google_analytics_data']['operating_system'] as $os):
					$os_label[] = $os[0];
					$os_count[] = $os[1];
				endforeach;
				$data['os'] = $os_label;
				$data['oscount'] = $os_count;
			endif;
			if (!empty($data['google_analytics_data']['browser'])):
				foreach($data['google_analytics_data']['browser'] as $browser):
					$browser_name[] = $browser[0];
					$browser_users[] = $browser[1];
				endforeach;
				$data['browser_names'] = $browser_name;
				$data['browser_users'] = $browser_users;
			endif;
			if (!empty($data['google_analytics_data']['source'])):
				foreach($data['google_analytics_data']['source'] as $source):
					$source_path[] = $source[0];
					$source_count[] = $source[1];
				endforeach;
				$data['source_paths'] = $source_path;
				$data['source_count'] = $source_count;
            endif;
            
            $data['graph'] = $this->graph_reports($data['google_analytics_data']['get_graph_reports']);
		else:
			$data['from_date'] = "";
			$data['user_types'] = "";
			$data['operating_system'] = "";
			$data['total_users'] = "";
			$data['geo_network'] = "";
			$data['os'] = "";
			$data['oscount'] = "";
			$data['sessions'] = "";
			$data['goal_conversion'] = "";
			$data['user_details'] = "";
			$data['browser_names'] = "";
			$data['browser_users'] = "";
			$data['source_paths'] = "";
            $data['source_count'] = "";
            $data['graph'] = "";
		endif;

		$data['title'] = "Dashboard | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('dashboard_header');
		$this->admin_header->index();
		$this->load->view('dashboard');
		$this->load->view('template/footer_content');
		$this->load->view('template/footer');
	}

	function graph_reports($reports)
	{
		$data = array();
		foreach($reports as $row)
		{
			$date = substr($row[1], 4, 2) . "/" . substr($row[1], 6, 2) . "/" . substr($row[1], 0, 4);
			$data[] = array(
				'country' => $row[0],
				'date' => $date,
				'sessions' => $row[2],
				'users' => $row[3],
				'pageviews' => $row[4]
			);
		}
		return $data;
	}

	/**
	 * Get Page Not Found 
	 */

	 function get_page_not_found()
	 {
		 $website_id = $this->admin_header->website_id();
		 $page_not_found_urls = $this->Dashboard_model->get_page_not_found($website_id);

		 if (!empty($page_not_found_urls)) :
			return $page_not_found_urls;
		 else :
			return $page_not_found_urls = "";
		 endif;
	 }
}
<?php
/**
 * Tracking
 * 
 * @category class
 * @package Tracking
 * @author Saravana
 * Created at : 12-Feb-2019
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Tracking extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')):
            redirect('login');
        endif;
        
        $this->load->model('Tracking_model');
        $this->load->module('admin_header');
        $this->load->module('google_analytic');
        $this->load->library('email');
        $this->load->library("Excel");
    }
    
    function index()
    {
        $data['table']   = $this->get_table();
        $data['heading'] = 'Tracking';
        $data['title']   = 'Tracking | Administrator';
        $this->load->view('template/meta_head', $data);
        $this->load->view('tracking_header');
        $this->admin_header->index();
        $this->load->view('view');
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    function get_table()
    {
        $tracking_reports = $this->google_analytic->reports();
        
        if (!empty($tracking_reports)):
            if (!empty($tracking_reports['tracking_reports'])):
                $i = 1;
                foreach ($tracking_reports['tracking_reports'] as $tracking_report):
                    $date = substr($tracking_report[0], 4, 2) . "/" . substr($tracking_report[0], 6, 2) . "/" . substr($tracking_report[0], 0, 4);
                    if ($tracking_report[4] == '/'):
                        $url = 'Home Page';
                    else:
                        $url = $tracking_report[4];
                    endif;
                    
                    $this->table->add_row($i, $date, $tracking_report[1], $tracking_report[2], $tracking_report[3], $url);
                    
                    $i++;
                endforeach;
            endif;
        endif;
        
        // Table open
        $template = array(
            'table_open' => '<table
            id="datatable-checkbox"
            class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
            width="100%" cellspacing="0">'
        );
        
        $this->table->set_template($template);
        // Table heading row
        $this->table->set_heading(array(
            'S.No',
            'Date',
            'Country',
            'City',
            'Source',
            'Url'
        ));
        
        return $this->table->generate();
    }
    
    /**
     * Mail Config
     */
    function mail_config()
    {
        $data['website_id']   = $this->admin_header->website_id();
        $tracking_mail_config = $this->Tracking_model->get_tracking_mail_config($data['website_id']);
        
        if (!empty($tracking_mail_config)):
            $mail_config             = json_decode($tracking_mail_config[0]->mail_config);

            $data['mail_subject']    = $mail_config->mail_subject;
            $data['from_name']       = $mail_config->from_name;
            $data['message_content'] = $mail_config->message_content;
            $data['to_address']      = $mail_config->to_address;
            $data['cc']              = $mail_config->cc;
            $data['bcc']             = $mail_config->bcc;
            $data['status']          = $mail_config->status;
        else:
            $data['mail_subject']    = "";
            $data['from_name']       = "";
            $data['message_content'] = "";
            $data['to_address']      = "";
            $data['cc']              = "";
            $data['bcc']             = "";
            $data['status']          = "";
        endif;
        
        $data['heading'] = 'Tracking - Mail Configuration';
        $data['title']   = 'Tracking - Mail Configuration | Administrator';
        $this->load->view('template/meta_head', $data);
        $this->load->view('tracking_header');
        $this->admin_header->index();
        $this->load->view('mail_config');
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    /**
     * Insert Update Tracking Mail config
     */
    function insert_update_tracking_mail_configure()
    {
        $continue = $this->input->post('btn_continue');
        $this->Tracking_model->insert_update_mail_config();
        
        if (isset($continue) && ($continue === "Save & Continue")):
            $url = 'tracking/mail_config';
        else:
            $url = 'tracking';
        endif;
        
        redirect($url);
        
    }

    /**
	 * Get Page Not Found - It is not used in google analytics because it's not taken form google tools
	 */

	 function get_page_not_found()
	 {
		 $website_id = $this->admin_header->website_id();
         $page_not_found_urls = $this->Tracking_model->get_page_not_found($website_id);
         $current_date = date('Y-m-d');
         $date = date('m-d-Y', (strtotime('-1 day', strtotime($current_date))));
         
         if(!empty($page_not_found_urls)) :

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
				
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:B1');
					$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Page Not Found URL - ' . $date);
				
					$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
					$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);					
				
					$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Date');
					$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Page-Url');
				
					$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
					$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
				
					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
					$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);					
					
					$row = 3;
					
					foreach ($page_not_found_urls as $value)
					{
                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $value->created_at);
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $value->url);				
						$row++;
					}

					$filename = $date . '-page-not-found.xls';
				
					header('Content-Type: application/vnd.ms-excel');
					header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
					header('Cache-Control: max-age=0');
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					$objWriter->save("reports/$filename");

         endif;

         
	 }

    /**
     * Send daily tracking reports in mail
     */
    function send_daily_tracking_reports()
    {
        $website_id = $this->admin_header->website_id();

        $tracking_mail_config = $this->Tracking_model->get_tracking_mail_config($website_id);

        if (!empty($tracking_mail_config)) :
            $mail_config = json_decode($tracking_mail_config[0]->mail_config);
            if ($mail_config->status == '1') :

                $mail_configurations = $this->Tracking_model->get_mail_configuration($website_id);

                if(!empty($mail_configurations))
                {
                    $config['protocol']	 = 'smtp';
                    $config['smtp_host']	= $mail_configurations[0]->host;
                    $config['smtp_port']	= $mail_configurations[0]->port;
                    $config['smtp_timeout'] = '7';
                    $config['smtp_user']	= $mail_configurations[0]->email;
                    $config['smtp_pass']	= $mail_configurations[0]->password;
                    $config['charset']	  = 'utf-8';
                    $config['newline']	  = "\r\n";
                    $config['mailtype']	 = 'html'; 
                    $config['validation']   = TRUE; 

                    $this->google_analytic->daily_tracking_reports();
                    $page_not_found_report = $this->get_page_not_found();
                    $current_date = date('Y-m-d');
                    $date = date('m-d-Y', (strtotime('-1 day', strtotime($current_date))));
                    $filename = 'reports/' . $date . '-Tracking.xls';

                    if (!empty($page_not_found_report)) :
                        $page_not_found_filename = 'reports/' . $date . '-page-not-found.xls';
                    endif;

                    $this->email->initialize($config);
                    $this->email->from($mail_configurations[0]->mail_from, $mail_config->from_name);
                    $this->email->subject($mail_config->mail_subject);
                    $this->email->attach($filename);

                    if (!empty($page_not_found_report)) :
                        $this->email->attach($page_not_found_filename);
                    endif;

                    $this->email->message($mail_config->message_content);
                    
                    ($mail_config->to_address != '') ? $this->email->to($mail_config->to_address) : '';

                    ($mail_config->cc != '') ? $this->email->cc($mail_config->cc): '';

                    ($mail_config->bcc != '') ? $this->email->bcc($mail_config->bcc): '';

                    if(!$this->email->send())
                    {
                        echo $this->email->print_debugger();
                    }   

                    unlink('reports/' . $date . '-Tracking.xls');

                    if (!empty($page_not_found_report)) :
                        unlink('reports/' . $date . '-page-not-found.xls');
                    endif;                    
                }

            endif;
        endif;
    }
}
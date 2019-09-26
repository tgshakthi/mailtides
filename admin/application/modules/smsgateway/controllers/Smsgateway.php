<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;
class Smsgateway extends MX_Controller
{
	
	function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->module('admin_header');
        $this->load->module('color');
		
    }
	function index()
	{
		$data['heading'] = 'Sms Gateway';
        $data['title']   = "Sms Gateway | Administrator";
        $this->load->view('template/meta_head', $data);
		$this->load->view('smsgateway_header');
        $this->admin_header->index();
        $this->load->view('view', $data);
        $this->load->view('template/footer_content');
        $this->load->view('template/footer');
	}
	
	function sms_gateway_data()
	{
		// Update the path below to your autoload.php,
		// see https://getcomposer.org/doc/01-basic-usage.md
		require_once("application/third_party/Twilio/autoload.php");
		
		// Find your Account Sid and Auth Token at twilio.com/console
		// DANGER! This is insecure. See http://twil.io/secure
		$sid    = "AC839320f02176c877d19a2816218a9674";
		$token  = "943086168eb029d1f2e5af5455284fde";
		$twilio = new Client($sid, $token);
		$numbers = array(
						'+17139339132',
						'+17135578001',
						'+18324449173',
						'+12813947218'
					);
		foreach($numbers as $number){
			print_r($number);die;
		}
		$message = $twilio->messages
						  ->create("+17139339132", // to
								   array(
									   "body" => "Hello Desss !!!",
									   "from" => "+12818843247"
								   )
						  );

		print($message->sid);
	}
}
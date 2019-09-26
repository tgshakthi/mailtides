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
		foreach($numbers as $number)
		{
			$message = $twilio->messages
							->create($number, // to
										array(
										   "body" => "Dear Chandler,
Thanks for visiting the Digestive & Liver Disease Consultants, P.A . Your wellbeing is very important to us. To help serve you and others more effectively, please take a moment to let us know about your experience.	
Please click the link below and give your feedback. 
<h2>https://tinyurl.com/y34jqkn6</h2>
Thank You"										,
										   "from" => "+12818843247"
										)
									);
		}
		

		print($message->sid);
		echo '<br>';
		print($message->status);
	}
}
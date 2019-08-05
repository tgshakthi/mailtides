<?php
/**
 * Mail
 * Created at : 03-July-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mail extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mail_model');
		$this->load->module('Setting');
		$this->load->library('email');
	}
	
	// Mail Configure
	function index()
	{
		$website_id = $this->setting->website_id();
		$mail_configurations = $this->Mail_model->get_mail_configuration($website_id);
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
		
			$this->email->initialize($config);
			
			return $mail_configurations[0]->mail_from;
		}
	}
	
	// Send Mail
	function send_mail($website_id, $mailvalueto, $mailvalue, $tbl_name)
	{
		$out = array(' ');
		$in = array('_');
		$contact_mail_configures = $this->Mail_model->contact_form_mail_configure($website_id);
		if(!empty($contact_mail_configures))
		{
			$mail_form_fields = ($contact_mail_configures->sort_label_name != '') ? explode(',', $contact_mail_configures->sort_label_name): array();
			$mailvalue = ($mailvalue != '') ? explode(',', $mailvalue): array();
			$tr = '';
			if (!empty($mail_form_fields) && !empty($mailvalue))
			{
				$m = 0;
				foreach($mail_form_fields as $mail_form_field)
				{
					$label_name = str_replace($out, $in, $mail_form_field);
					$tr .= '<tr>
					<td>
					' . $mail_form_field . '
					</td>
					<td>
					' . $mailvalue[$m] . '
					</td>
					</tr>';
					$m++;
				}
			}
			
			$send = '
				  <table cellpadding="8" cellspacing="0" border="1" width="600" bordercolor="#fcfcfc">
					  '.$tr.'
					   <tr>
					  <td colspan="3" valign="middle" style="text-align:center;">
					  '.$contact_mail_configures->message_content.'
					  </td>
					</tr>
				  </table>
				 ';
				  
			$from_email = $this->mail->index();
			
			$this->email->from($from_email, $contact_mail_configures->from_name);
			$this->email->subject($contact_mail_configures->mail_subject);
			$this->email->message($send); 
			$mailvaluetos = ($mailvalueto != '') ? $mailvalueto.',': '';
			
			($contact_mail_configures->to_address != '') ? $this->email->to($mailvaluetos.$contact_mail_configures->to_address): $this->email->to($mailvalueto);
			($contact_mail_configures->ccid != '') ? $this->email->cc($contact_mail_configures->ccid): '';
			($contact_mail_configures->bccid != '') ? $this->email->bcc($contact_mail_configures->bccid): '';
			if(!$this->email->send())
			{
				echo $this->email->print_debugger();
			}
		}
	}
	
	function send_mail_register($website_id, $mailvalueto, $mailvalue, $tbl_name)
	{
		$out = array(' ');
		$in = array('_');
		$register_mail_configures = $this->Mail_model->register_form_mail_configure($website_id);
		if(!empty($register_mail_configures))
		{
			//$mail_form_fields = ($register_mail_configures->sort_label_name != '') ? explode(',', $register_mail_configures->sort_label_name): array();
			$mail_form_fields  = $this->Mail_model->get_register_mail_form_field($website_id);
			$mailvalue = ($mailvalue != '') ? explode(',', $mailvalue): array();
			$tr = '';
			if (!empty($mail_form_fields) && !empty($mailvalue))
			{
				$m = 0;
				foreach($mail_form_fields as $mail_form_field)
				{
					$label_name = strtolower(str_replace($out, $in, $mail_form_field->label_name));
					$tr .= '<tr>
					<td style="padding:15px 0px 15px 0px; margin:0px; width:50%;">
					<h3 style="font-size:16px; padding:0px 0px 0px 0px; margin:0px;color: #1AA7D4; font-weight:bold; text-align:right;">' . $mail_form_field->label_name . ' :</h3>
					</td>
					<td style="padding:0px 0px 0px 10px; margin:0px; width:50%;">
					<p style="padding:0px 0px; margin:0px; font-size:16px;">' . $mailvalue[$m] . '</p>
					</td>
					</tr>';
					$m++;
				}
			}
			
			$send = '<center>
				  <table width="600" cellspacing="0" cellpadding="0" align="center" style="background:#f3f3f3;">
				  <tr>
					</tr>
					  '.$tr.'
					   <tr>
					  <td colspan="2" style="padding:10px 30px 15px; margin:0px;">
					  <p style="padding:5px 0px 0px; margin:0px; font-size:16px; line-height:28px; text-align:center;">'.$register_mail_configures[0]->message_content.'</p>
					  </td>
					</tr>
				  </table>
				  </center>';
				  
			$from_email = $this->mail->index();
			
			$this->email->from($from_email, $register_mail_configures[0]->from_name);
			$this->email->subject($register_mail_configures[0]->mail_subject);
			$this->email->message($send); 
			$mailvaluetos = ($mailvalueto != '') ? $mailvalueto.',': '';
			
			($register_mail_configures[0]->to_address != '') ? $this->email->to($mailvaluetos.$register_mail_configures[0]->to_address): $this->email->to($mailvalueto);
			($register_mail_configures[0]->cc != '') ? $this->email->cc($register_mail_configures[0]->cc): '';
			($register_mail_configures[0]->bcc != '') ? $this->email->bcc($register_mail_configures[0]->bcc): '';
			if(!$this->email->send())
			{
				echo $this->email->print_debugger();
			}
		}
	}
	
	
	// Blog Rating Mail
	function blog_rating_mail($website_id, $mailvalueto, $mailvalue)
	{
		$rating_mail_configures = $this->Mail_model->rating_mail_configure($website_id);
		if(!empty($rating_mail_configures))
		{
			$mail_form_fields  = (!empty($rating_mail_configures[0]->rating_field_status)) ? explode(',', $rating_mail_configures[0]->rating_field_status): array();
			$mailvalue = ($mailvalue != '') ? explode(',', $mailvalue): array();

			$tr = '';
			if (!empty($mail_form_fields) && !empty($mailvalue))
			{
				foreach($mail_form_fields as $mail_form_field)
				{
					$field_name = ($mail_form_field == 1 ? 'Name': ($mail_form_field == 2 ? 'Email': ($mail_form_field == 3 ? 'Comment': ($mail_form_field == 4 ? 'Rating': ''))));
					
					$tr .= '<tr>
					<td style="padding:15px 0px 15px 0px; margin:0px; width:50%;">
					<h3 style="font-size:16px; padding:0px 0px 0px 0px; margin:0px;color: #1AA7D4; font-weight:bold; text-align:right;">' . $field_name . ' :</h3>
					</td>
					<td style="padding:0px 0px 0px 10px; margin:0px; width:50%;">
					<p style="padding:0px 0px; margin:0px; font-size:16px;">' . $mailvalue[$mail_form_field - 1] . '</p>
					</td>
					</tr>';
				}
			}
			
			$send = '<center>
				  <table width="600" cellspacing="0" cellpadding="0" align="center" style="background:#f3f3f3;">
				  <tr>
					</tr>
					  '.$tr.'
					   <tr>
					  <td colspan="2" style="padding:10px 30px 15px; margin:0px;">
					  <p style="padding:5px 0px 0px; margin:0px; font-size:16px; line-height:28px; text-align:center;">'.$rating_mail_configures[0]->message_content.'</p>
					  </td>
					</tr>
				  </table>
				  </center>';
				  
			$from_email = $this->mail->index();
			
			$this->email->from($from_email, $rating_mail_configures[0]->from_name);
			$this->email->subject($rating_mail_configures[0]->mail_subject);
			$this->email->message($send); 
			$mailvaluetos = ($mailvalueto != '') ? $mailvalueto.',': '';
			
			($rating_mail_configures[0]->to_address != '') ? $this->email->to($mailvaluetos.$rating_mail_configures[0]->to_address): $this->email->to($mailvalueto);
			($rating_mail_configures[0]->cc != '') ? $this->email->cc($rating_mail_configures[0]->cc): '';
			($rating_mail_configures[0]->bcc != '') ? $this->email->bcc($rating_mail_configures[0]->bcc): '';
			if(!$this->email->send())
			{
				echo $this->email->print_debugger();
			}
		}
	}
	
	// Blog Rating Reply Mail
	function blog_rating_reply_mail($website_id, $name, $mailvalueto)
	{
		$rating_mail_configures = $this->Mail_model->rating_mail_configure($website_id);
		if(!empty($rating_mail_configures))
		{
			$send = '<span>Hi '.$name.'</span>
			<p>Reply for your Comments</p>';
			
			$from_email = $this->mail->index();
			$this->email->from($from_email, $rating_mail_configures[0]->from_name);
			$this->email->subject($rating_mail_configures[0]->mail_subject);
			$this->email->message($send); 
			$mailvaluetos = ($mailvalueto != '') ? $mailvalueto.',': '';
			
			($rating_mail_configures[0]->to_address != '') ? $this->email->to($mailvaluetos.$rating_mail_configures[0]->to_address): $this->email->to($mailvalueto);
			($rating_mail_configures[0]->cc != '') ? $this->email->cc($rating_mail_configures[0]->cc): '';
			($rating_mail_configures[0]->bcc != '') ? $this->email->bcc($rating_mail_configures[0]->bcc): '';
			if(!$this->email->send())
			{
				echo $this->email->print_debugger();
			}
		}
	}
	
	// Sweet Alert
	function sweetalert($title, $text, $type, $url)
	{
		$data['title'] = $title;
		$data['text'] = $text;
		$data['type'] = $type;
		$data['url'] = base_url().$url;		
		$this->load->view('sweetalert', $data);
	}

	// Newsletter Mail Config
	function send_newsletter_mail($website_id, $email, $mail_config)
	{
		if (!empty($mail_config)) :

			$send = '<center>
					<table width="600" cellspacing="0" cellpadding="0" align="center" style="background:#f3f3f3;">
						<tr>
							<td colspan="2" style="padding:10px 30px 15px; margin:0px;">
								<p style="padding:5px 0px 0px; margin:0px; font-size:16px; line-height:28px; text-align:center;">'.$mail_config['message_content'].'</p>
							</td>
						</tr>
					</table>
				</center>';

		endif;

		$from_email = $this->mail->index();
		
		$this->email->from($from_email, $mail_config['from_name']);
		$this->email->subject($mail_config['mail_subject']);
		$this->email->message($send); 	
		$mailvaluetos = ($email != '') ? $email.',': '';	
		($mail_config['to_address'] != '') ? $this->email->to($mailvaluetos.$mail_config['to_address']) : $this->email->to($mailvaluetos);
		($mail_config['cc'] != '') ? $this->email->cc($mail_config['cc']) : '';
		($mail_config['bcc'] != '') ? $this->email->bcc($mail_config['bcc']) : '';
		if(!$this->email->send())
		{
			echo $this->email->print_debugger();
		}		
	}
	
	// Review Entry Mail Config
	function send_review_entry_mail($website_id,$name, $email,$reviews,$ratings, $mail_config)
	{
		if (!empty($mail_config)) :
			$tr .= '
					<tr><td>Name</td>
					<td>
					' . $name . '
					</td></tr>
					<tr><td>Email</td>
					<td>
					 ' . $email . '
					</td></tr>
					<tr><td>Reviews</td>
					<td>
					 ' . $reviews . '
					</td></tr>	
					<tr><td>Ratings</td>
					<td>
					 ' . $ratings . '
					</td></tr>				
					';
			$send = '
				  <table cellpadding="8" cellspacing="0" border="1" width="600" bordercolor="#fcfcfc">					 
					   '.$tr.'
					   <tr>
					  <td colspan="3" valign="middle" style="text-align:center;">
					  '.$mail_config['message_content'].'
					  </td>
					</tr>
				  </table>
				 ';

		endif;

		$from_email = $this->mail->index();
		
		$this->email->from($from_email, $mail_config['from_name']);
		$this->email->subject($mail_config['mail_subject']);
		$this->email->message($send); 	
		$mailvaluetos = ($email != '') ? $email.',': '';	
		($mail_config['to_address'] != '') ? $this->email->to($mailvaluetos.$mail_config['to_address']) : '';
		($mail_config['cc'] != '') ? $this->email->cc($mail_config['cc']) : '';
		($mail_config['bcc'] != '') ? $this->email->bcc($mail_config['bcc']) : '';
		if(!$this->email->send())
		{
			echo $this->email->print_debugger();
		}		
	}
}

?>
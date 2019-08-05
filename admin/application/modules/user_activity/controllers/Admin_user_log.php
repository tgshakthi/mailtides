<?php
/**
 * Admin User Log
 * @category class
 * @package  Admin User Log
 * @author   Shiva
 * Created at:  14-May-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_user_log extends MX_Controller

{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Admin_user_log_model');
		$this->load->module('admin_header');
		$this->form_validation->CI = & $this;
	}

	function index()
	{
		$data['admin_user_details_website'] = $this->Admin_user_log_model->get_user_log_role_details();
		$admin_user_details_website = $data['admin_user_details_website'];
		$cms_page_count = $this->Admin_user_log_model->cms_page_count();
		foreach($cms_page_count as $cms_page_count_det)
		{
			$data['cms_count'] = $cms_page_count_det->cms_page_count - 1;
		}

		$data['heading'] = 'Admin User Log';
		$data['title'] = "Admin User Log | Administrator";
		$data['ImageUrl'] = $this->admin_header->image_url();
		$this->load->view('template/meta_head', $data);
		$this->load->view('admin_user_log/admin_user_log_header');
		$this->admin_header->index();
		$this->load->view('admin_user_log/admin_user_log', $data);
		$this->load->view('template/footer_content');
		$this->load->view('admin_user_log/script');
		$this->load->view('template/footer');
	}

	function search_values()
	{
		$result = "";
		$ImageUrl = $this->admin_header->image_url();
		if (!empty($_POST["searchval"]))
		{
			$searchval = $_POST["searchval"];
			$get_searchdata = $this->Admin_user_log_model->get_user_search_details($searchval);
			if (!empty($get_searchdata))
			{
				$cnt = "0";
				foreach($get_searchdata as $searchdata)
				{
					$user_id_val = $searchdata->id;
					$first_name = $searchdata->first_name;
					$last_name = $searchdata->last_name;
					$email = $searchdata->email;
					$user_image = $searchdata->user_image;
					$user_role_name = $searchdata->user_role_name;
					$website_name = $searchdata->website_name;
					$website_url = $searchdata->website_url;
					$result.= '<div  class="col-md-4 col-sm-4 col-xs-12 profile_details">
								<div  class="well profile_view">
									<div class="col-sm-12">
											<h4 class="brief"><i>' . $user_role_name . ' </i></h4>
												<div class="left col-xs-7">
													<h2>' . $first_name . '&nbsp;' . $last_name . '</h2>
														<ul class="list-unstyled">
															<li><i class="fa fa-building"></i> Email : ' . $email . '</li>
															<li><i class="fa fa-globe"></i> Website :' . $website_name . '</li>
														</ul>
												</div>
												<div class="right col-xs-5 text-center">';
					if (!empty($user_image))
					{
						$result.= '<img src="' . $user_image . '" alt="" class="img-circle img-responsive"/>';
					}
					else
					{
						$result.= '<img src="' . $ImageUrl . 'images/userimg.png" alt="" class="img-circle img-responsive"/>';
					}

					$result.= '</div>
									</div>
									<div class="col-xs-12 bottom text-center">
										<div class="col-xs-12 col-sm-6 emphasis">
											  <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-user"></i><i class="fa fa-comments-o">Online</i></button>
											 
											   <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-user"></i> 
											   <a style="color:white;" href="' . base_url() . '/index.php/admin_user_profile/profile/' . $user_id_val . '">View Profile</a></button>
										</div>
									 </div>
								</div>
							</div>
						';
					$cnt++;
				}

				print_r($result);
			}
			else
			{
				$result . '<p>No Results Found!</p>';
				echo $result;
			}
		}
		else
		{
			$result . '<p>No Results Found!</p>';
			echo $result;
		}
	}

	function search_alpha_values()
	{
		$result = "";
		$ImageUrl = $this->admin_header->image_url();
		if (!empty($_POST["searchval_alpha"]))
		{
			$search_alpha_values = $_POST["searchval_alpha"];
			$get_searchdata = $this->Admin_user_log_model->get_user_search_alpha_details($search_alpha_values);
			if (!empty($get_searchdata))
			{
				$cnt = "0";
				foreach($get_searchdata as $searchdata)
				{
					$first_name = $searchdata->first_name;
					$last_name = $searchdata->last_name;
					$email = $searchdata->email;
					$user_image = $searchdata->user_image;
					$website_name = $searchdata->website_name;
					$website_url = $searchdata->website_url;
					$user_role_name = $searchdata->user_role_name;
					$result.= '   <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
					<div class="well profile_view">
									<div class="col-sm-12">
										<h4 class="brief"><i>' . $user_role_name . ' </i></h4>
											<div class="left col-xs-7">
												<h2>' . $first_name . '&nbsp;' . $last_name . '</h2>
													<ul class="list-unstyled">
														<li><i class="fa fa-building"></i> Email : ' . $email . '</li>
													    <li><i class="fa fa-globe"></i> Website :' . $website_name . '</li>
													</ul>
												</div>
												<div class="right col-xs-5 text-center">';
					if (!empty($user_image))
					{
						$result.= '<img src="' . $user_image . '" alt="" class="img-circle img-responsive"/>';
					}
					else
					{
						$result.= '<img src="' . $ImageUrl . 'images/userimg.png" alt="" class="img-circle img-responsive"/>';
					}

					$result.= '</div>
										</div>
										  <div class="col-xs-12 bottom text-center">
										   <div class="col-xs-12 col-sm-6 emphasis">
											  <button type="button" class="btn btn-success btn-xs"><i class="fa fa-user">
												</i> <i class="fa fa-comments-o">Online</i> </button>
											   <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-user"></i> 
											   <a style="color:white;" href="' . base_url() . '/index.php/admin_user_profile/profile/' . $searchdata->id . '">View Profile</a></button>
											</div>
										  </div>
									 </div> 
							</div>
                        	';
					$cnt++;
				}

				print_r($result);
			}
			else
			{
				$result . '<p>No Results Found!</p>';
				echo $result;
			}
		}
		else
		{
			$result . '<p>No Results Found!</p>';
			echo $result;
		}
	}
}

?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> -->

<!-- <section>
    <div class="container">
        <div class="row">
            <div class="common-space">
                <div class="contact-us-form">
                    <h4 class="dark-marroon-text center"> Make an Appointment</h4>
                    <form>
                        <div class="contact-us-full-form center">
                            <ul>
                                <li class="col s12 m12 l12 xl12 contact-radio left-align">
                                    <label for="new-patient">
                                        <input type="radio" name="patient" id="new-patient" value="New Patient" checked> 
                                        New Patient
                                    </label>
                                    <label for="existing-patient">
                                        <input type="radio" name="patient" id="existing-patient" value="Existing Patient"> 
                                        Existing Patient
                                    </label>   
                                    <label for="referral-patient">
                                        <input type="radio" name="patient" id="referral-patient" value="Referral"> 
                                        Referral
                                    </label>   
                                    <label for="schedule-Procedure">
                                        <input type="radio" name="patient" id="schedule-Procedure" value="Schedule Procedure"> 
                                        Schedule Procedure
                                    </label>                        
                                </li>

                                <li class="col s12 m12 l12 xl12">
                                    <input type="text" placeholder=" Name"> 
                                </li>

                                <li class="col s12 m12 l12 xl12"> 
                                    <input type="text" placeholder="Email"> 
                                </li>
                                <li class="col s12 m12 l12 xl12"> 
                                    <input type="text" placeholder="DOB" id="datepicker"> 
                                </li>
								<script>

								$( function() {
								$( "#datepicker" ).datepicker();
								} );
									</script>

                                <li class="col s12 m12 l12 xl12"> 
                                    <input type="text" placeholder="Telephone"> 
                                </li>

                             

                                <li class="col s12 m12 l12 xl12">
                                    <textarea placeholder="Message" rows="4"> </textarea> 
                                </li>

                                <li class="col s12 m12 l12 xl12"> 
                                    <button class="dark-marroon appointment-btn white-text">
                                    Send 
                                    </button>
                                </li>

                                <li class="col s12 m12 l12 xl12"> 
                                    <a href="#" class="white-text grey darken-1 experience"> 
                                        Have an experience? share your story!
                                    </a> 
                                </li>

                            </ul>
                        </div>
                    </form>
                </div>
                <div class="spacer"></div>
            </div>
        </div>
    </div>
</section> -->

<?php if(!empty($contact_form_field)) : ?>
	
	<section class="common-space bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
    

<div data-aos="zoom-in-down" class="txgidocs-contactus">
		<div class="container">
			<div class="row">

				<?php
				$contact_column_data_value = '';
					if(!empty($contact_column)):
						$contact_row_column = explode("/", $contact_column);
						$count_contact_row_column = count($contact_row_column);

						for($cr = 0; $cr < $count_contact_row_column; $cr++):
							$contact_column_data = explode("-", $contact_row_column[$cr]);
							if(!empty($contact_column_data)):
								if($contact_column_data[1] != ""):
									$contact_column_data_value = ($cr != 0) ? $contact_column_data_value: array();
									$contact_column_datas = explode(",", $contact_column_data[1]);
									$contact_column_data_value = array_merge($contact_column_datas, $contact_column_data_value);
								endif;
							endif;
						endfor;

						for($cr = 0; $cr < $count_contact_row_column; $cr++):
							$contact_column_data = explode("-", $contact_row_column[$cr]);
							if(!empty($contact_column_data)):
								if($contact_column_data[1] != ""):
									$contact_column_datas	  = explode(",", $contact_column_data[1]);
									$contact_column_count	  = count($contact_column_datas);
									$contact_row_column_count = ($contact_column_count == 2 ? 'l6': ($contact_column_count == 1 ? 'l12': 'l12'));
									
									for($cc = 0; $cc < $contact_column_count; $cc++):
										// Get Contact Us Form With Information
										echo $controller->contact_us_information($website_id, $page_id, $page_url, $contact_row_column_count, $contact_column_datas[$cc]);
									endfor;
								endif;
							endif;
						endfor;
					endif;
					
					$contact_column_data_value = !empty($contact_column_data_value) ? $contact_column_data_value: array();
					
					$single_contact_column_data = array_diff($forms_fields, $contact_column_data_value);
					if(!empty($single_contact_column_data)):
				
						foreach($single_contact_column_data as $key => $value):
							
							echo $controller->contact_us_information($website_id, $page_id, $page_url, 'l12', $single_contact_column_data[$key]);
							
						endforeach;
						
					endif;
				?>

			</div>
		</div>
        </div>
 	</section>

<?php endif; ?>

<?php if ($this->setting->page_url() == 'index.html') :?>
<section class="dark-marroon">
        <div class="container">
            <div class="common-space">

                <h2 class="h1-head  center white-text slider-title">Professional Affiliations</h2>
                <div class="carousel-wrap">
                    <div id="txgidoc-professional" class="row owl-carousel">
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                            <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/17.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/4th.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/18.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/7th.png">
                          
                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/5th.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/19.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/14.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/8.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/21.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/2.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/3.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/4.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/5.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/6.png">

                        </a>
                        <a href="JavaScript:void(0);" class="col s12 m6 l6 xl6 item">
                        <img src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/service%20logo/7.png">

                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php endif;?>
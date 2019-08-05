<?php
/**
 * Footer 
 * 
 * @category view
 * @package Footer
 * @author
 * 
 * Modified Date: 25-Feb-2019
 * Modified By: Saravana
 */
?>

<!--<section class="bg-img-common common-space grey">
    <div class="container">
        <h4 class="h1-head center dark-marroon-text">Video Gallery</h4>

        <div class="row">

            <div class="col s12 m6 l4 xl4">
                <div class="video-component">
                    <iframe width="100%" height="230px" src="//www.youtube.com/embed/YE7VzlLtp-4" frameborder="0"
                        allowfullscreen></iframe>
                </div>

                <div class="video-content">
                    <p class="center white-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nobis, vitae.
                    </p>
                </div>
            </div>

            <div class="col s12 m6 l4 xl4">
                <div class="video-component">
                    <iframe width="100%" height="230px" src="//www.youtube.com/embed/YE7VzlLtp-4" frameborder="0"
                        allowfullscreen></iframe>
                </div>

                <div class="video-content">
                    <p class="center white-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nobis, vitae.
                    </p>
                </div>
            </div>

            <div class="col s12 m6 l4 xl4">
                <div class="video-component">
                    <iframe width="100%" height="230px" src="//www.youtube.com/embed/YE7VzlLtp-4" frameborder="0"
                        allowfullscreen></iframe>
                </div>

                <div class="video-content">
                    <p class="center white-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nobis, vitae.
                    </p>
                </div>
            </div>

            <div class="col s12 m12 l12 xl12 center">
                <a href="#" class="video-btn dark-marroon white-text">View More videos</a>
            </div>

        </div>

    </div>
</section>

<section>
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
                                    <label for="Referral-patient">
                                        <input type="radio" name="patient" id="referral-patient" value="Referral"> 
                                        Referral
                                    </label>   
                                    <label for="existing-patient">
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
                                    <select>
                                        <option value="New">New Patient</option>
                                        <option value="Current">Current Patinent</option>
                                    </select> 
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

<?php if ($footer_status === '1') :?>

<!-- <footer class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
    <div class="footer-padding">
        <ul class="row container-wrapper">
            <?php
                // Footer Logo
                echo $footer_logo;

                // Footer Events
                echo $footer_events;

                // Footer Contact info
                echo $footer_contact_info;

                // Footer Blog
                echo $footer_blog;                
            ?>           
        </ul>   
        
        <?php
            // Footer Social Media
            echo $footer_social_media;
        ?>
    </div>

    <div class="foot-copyrights black center">
        <p class="white-text">Copyrights@2008,desss.Inc.</p>
    </div>

</footer> -->

<?php endif;?>


<footer>
    <div class="footer-padd lighten-marroon">
        <div class="common-space-footer">
        
            <div class="container">
                <div class="footer-all-details">

                    <ul class="row">

                        <li class=" col s12 m12 l12 xl12">

                            <!-- <div class="f-logo-socialmedia f-equal-height">
                                <a href="#" class="f-foot-logo"><img
                                        src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/logo/logo.jpg"
                                        alt="" title=""></a>
                                <p class="white-text center-align">DIGESTIVE & LIVER DISEASE CONSULTANTS,P.A.
                                </p>

                            </div> -->

                            <ul class="social-media-footer">
                                <li>
                                    <a href="https://www.facebook.com/TxGIDocs/" class="white-text"><i class="fab fa-facebook-square"></i></a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/TxGIDocs" class="white-text"><i class="fab fa-twitter"></i></a>
                                </li>
                               
                                <li>
                                    <a href="https://www.instagram.com/txgidocs/" class="white-text"><i class="fab fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/company/digestive-&-liver-disease-consultants-pa" class="white-text"><i class="fab fa-linkedin-in"></i></a>
                                </li>
                            </ul>


                        </li>

                     
                        <!-- <li class="col s12 m12 l4 xl6">
                            <div class="f-event f-equal-height">
                                <h3 class="f-h3-head white-text">Office Location </h3>
                                <ul class="footer-menu">
                                    <li>
                                        <a href="#" class="white-text">275 Lantern Bend Dr. Suite 200 Houston, TX
                                            77090</a>
                                    </li>
                                    <li>
                                        <a href="#" class="white-text">18955 Memorial North Suite 500 Humble, TX
                                            77338</a>
                                    </li>
                                    <li>
                                        <a href="#" class="white-text">920 Medical Plaza Dr. Suite 550 The Woodlands, TX
                                            77380</a>
                                    </li>


                                </ul>

                            </div>
                        </li>
                        <li class=" col s12 m12 l4 xl3">
                            <div class="f-event f-equal-height">
                                <h3 class="f-h3-head white-text">Contact Info</h3>
                                <ul class="f-address-details">

                                    <li class="white-text"><i class="fa fa-phone" aria-hidden="true"></i>
                                        <p>(281) 440-0101</p>
                                    </li>

                                    <li class="white-text"><i class="fa fa-phone" aria-hidden="true"></i>
                                        <p> (281) 453-2050</p>
                                    </li>
                                    <li class="white-text"><i class="fa fa-fax" aria-hidden="true"></i>
                                        <p> (855) 404-4345</p>
                                    </li>


                                </ul>
                            </div>
                        </li>

                        <li class="col s12 m12 l4 xl3">

                            <p class="white-text  center">Experience Speaks Volumes</p>
                            <p class="white-text center">Excellence in Patient Care-Every Patient-Every Day</p>
                            <ul class="f-footer-social center">

                                <li><a href="#" class="teal white-text" target="_blank"><i
                                            class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" class="white-text teal" target="_blank"><i
                                            class="fab fa-twitter"></i></a></li>
                                <li><a href="#" class="teal white-text" target="_blank"><i
                                            class="fab fa-instagram"></i></a></li>
                                <li><a href="#" class="teal white-text" target="_blank"><i
                                            class="fab fa-linkedin-in "></i></a></li>
                            </ul>


                

                </li> -->

                </ul>
                <!-- <ul class="footer-static-menu">
                    <li> <a href="#">Home </a></li>
                    <li> <a href="#">About </a></li>
                    <li> <a href="#">Our Physicians </a></li>
                    <li> <a href="#">Services </a></li>
                    <li> <a href="#">Disorders & Diseases </a></li>
                    <li> <a href="#">For Our Patients </a></li>
                    <li> <a href="#">Schedule an Appointment </a></li>
                    <li> <a href="#">More </a></li>
                </ul> -->
            </div>
        </div>
        
                    <div class="txgi-foot">
                        <div class="container">
                            <?php 
                                echo $menus_new['menus'];
                            ?>
                            </div>
                        </div>

    </div>
    </div>
    <div class="footer-social-copyrights dark-marroon">

        <div class="footer-copyrights center">
            <p class="white-text">Copyrights@2019, <a href="http://www.desss.com" class="white-text">Desss.Inc.</a></p>
        </div>
        <div class="spacer"></div>
    </div>
</footer>

<style>
    .common-space-footer {
        padding: 20px 0px 20px 0px;
        margin: 0px;
    }

    .f-address-details li i {
        font-size: 14px !important;
    }

    .f-foot-logo {
        width: 10% !important;
    }

    .f-logo-socialmedia>.f-foot-logo {
        margin: auto !important;
    }

    .f-logo-socialmedia>p {

        font-weight: 500;
    }

    .f-footer-social {
        padding: 15px 0px !important;

    }

    .footer-static-menu {
        padding: 0px;
        margin: 20px 0px 0px 0px;
        display: table;
    }

    .footer-static-menu li {
        padding: 0px;
        margin: 17px 17px 0px 17px;
        float: left;
    }

    .footer-static-menu li a {
        padding: 0px;
        margin: 0px;
        color: #fff;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 14px;
    }
   

    @media (min-width: 320px) and (max-width: 767px) {

        .footer-static-menu li {

            float: none;
        }

    }

    /* style for static contact us*/
    /* select {
        display: block !important;
        border: 1px solid #818a91 !important;
        margin: 0px 0px 10px 0px;
    } */

    .contact-us-form [type="radio"]:not(:checked),
    .contact-us-form [type="radio"]:checked {
        position: static !important;
        opacity: 1 !important;
        pointer-events: visible !important;
    }

    .contact-us-form [type="textarea"] {
        width: 100%;
    }

    .contact-us-form {
        padding: 0px;
        margin: 0px;
    }

    .contact-us-form textarea {
        height: auto !important;
    }

    .contact-us-form h4 {
        padding: 0px;
        margin: 0px 0px 10px 0px;
    }

    .contact-us-form input[type=text]:not(.browser-default),
    .contact-us-form textarea :not(.browser-default) {
        border: 1px solid #818a91 !important;
        height: 40px !important;
        border-radius: 5px;
        padding: 0px 15px !important;
        box-sizing: border-box;
    }

    .contact-us-full-form {
        padding: 0px;
        margin: 0px;
    }

    .contact-us-full-form ul {
        padding: 0px;
        margin: 0px;
    }

    .contact-us-full-form ul li {
        padding: 0px;
        margin: 0px 0px 10px 0px;
    }

    .appointment-btn {
        width: 100%;
        padding: 10px 0px;
        margin: 0px 0px 10px 0px;
        border: none;
        border-radius: 5px;
    }

    .experience {
        padding: 8px 10px;
        margin: 0px;
        border-radius: 3px;
        display:inline-block;
    }

    .contact-radio label {
        color: #ababab;
        font-size: 16px;
        padding: 0px 10px 0px 0px;
    }

    .contact-us-form form {
        width: 70%;    
        margin: auto;
    }
    @media (min-width:280px) and (max-width:767px) {
        .contact-us-form form {
        width: 90%;    
        margin: auto;
    }
    }


    /*end of the style for static contact us*/

    .video-component {
        border: 10px solid #7a7a7a;
        line-height: 0;
        padding: 0px;
        margin: 0px;
    }

    .video-content {
        padding: 15px;
        margin: 0px;
    }

    .video-content p {
        padding: 0px;
        margin: 0px;
        font-size: 18px;
        font-weight: 300;
        line-height: 30px;
    }

    .video-btn {
        padding: 10px 20px;
        margin: 20px auto 0px;
        font-size: 16px;
        display: table;
        position: relative;
    }

    /* Social Media */
    .social-media-footer
    {
        width: 100%;
        padding: 0px;
        margin: 0px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .social-media-footer li
    {
      padding:0px 0px;
      margin:0px
    }
    .social-media-footer li a
    {
        padding:10px;
        margin:0px;
       display:block;
    }
    .social-media-footer li:nth-child(odd) a:hover
    {
        color:#149aea !important;
    }
    .social-media-footer li:nth-child(even) a:hover
    {
        color:#71b4e4 !important;
    }
    .social-media-footer li a i
    {
        padding:0px;
        margin:0px;
        font-size:30px;
    }
</style>

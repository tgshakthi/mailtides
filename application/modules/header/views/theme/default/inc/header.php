<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <header class="<?php echo $header_background;?>">

        <div id="contact_us_loader" class="contact_loder hide">
            <div class="sk-folding-cube">
                <div class="sk-cube1 sk-cube"></div>
                <div class="sk-cube2 sk-cube"></div>
                <div class="sk-cube4 sk-cube"></div>
                <div class="sk-cube3 sk-cube"></div>
            </div>
        </div>

        <?php
			// Top header
			echo $top_header;
		?>

        <!-- Header -->
        <div class="container">
            <div id="header" class="row">
            <div class="header-contact-detail col s12 m6 l3 xl3 left-align hide-on-med-and-down">
<h5 class="dark-marroon-text center"> Main  </h5>
<h3 class="dark-marroon-text center">281.440.0101</h3>
                    </div>
                <div
                    class="col s12 m12 l6 xl6 <?php echo (empty($logo['logo_size'])) ? 'logo-length-15' : $logo['logo_size'];?><?php echo $logo['logo_position'].' '.$menus['menu_position'];?>">
                    <?php
						// Logo
						$image = array(
							'src'   => $logo['logo'],
							'alt'   => $logo['website_name'],
							'title' => $logo['website_name']
						);

						echo anchor($logo['website_url'], img($image), 'class = "logo"');
					?>

                </div>
                <div class="header-contact-detail col s12 m6 l3 xl3 right-align hide-on-med-and-down">
<h5 class="dark-marroon-text center"> Schedule an appointment</h5>
<h3 class="dark-marroon-text center">281.453.2050</h3>
                    </div>


                    <div class="col xl12 m12 s12 l12 facility-title">
                   <a href="index.html">
        <h4 class="dark-grey-blue-text center"> 
Digestive & Liver Disease Consultants, P.A. </h4>
                    </a>
                    <ul class="header-social center">
                              
                                <li><a href="https://www.facebook.com/TxGIDocs/" class="dark-marroon-text" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="https://twitter.com/TxGIDocs" class="dark-marroon-text" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="https://www.instagram.com/txgidocs/" class="dark-marroon-text" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="https://www.linkedin.com/company/digestive-&-liver-disease-consultants-pa" class="dark-marroon-text" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                            </ul>
    </div>
            </div>

    </header>
<div class="dark-marroon">
<div class="container">
    <div>
        <?php
			// Menu
			if (!empty($menus['menus']) && $menus['status'] == 1) :
		?>

        <?php echo $mobile_nav['mobile_menu'];?>
        <?php echo $menus['menus'];?>

        <?php endif; ?>
    </div>
    </div>
            </div>
    <div class="spacer"></div>
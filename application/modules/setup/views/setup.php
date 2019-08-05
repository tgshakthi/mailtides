<!-- Installation Page -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="robots" content="noindex,nofollow" />
    <title>Setup Configuration File</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ;?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ;?>assets/icon/fontawesome/css/font-awesome.min.css">
	<script type="text/javascript" src="<?php echo base_url() ; ?>assets/theme/default/js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ;?>assets/bootstrap/js/bootstrap.min.js"></script>

    <style media="screen">

    body {
         font-family: 'Roboto Condensed', sans-serif;
         margin: 0px;
         padding: 0px;
         overflow-y: auto;
         overflow-x: hidden;
         background: #f4f4f4;
    }
     .small, small {
         font-size: 100%;
         font-weight: 600;
    }
     .process-step .btn:focus {
         outline: none
    }
     .process {
         display: table;
         width: 100%;
         position: relative
    }
     .process-row {
         display: table-row
    }
     .process-step button[disabled] {
         opacity: 1 !important;
         filter: alpha(opacity=100) !important
    }
     .process-row:before {
         top: 30px;
         bottom: 0;
         position: absolute;
         content: " ";
         width: 75%;
         height: 2px;
         background-color: #DFDFDF;
         z-order: 0;
         margin: 0px auto;
         left: 14%;
         right: auto;
    }
     .process-step {
         display: table-cell;
         text-align: center;
         position: relative;
         width:25%;
    }
     .process-step p {
         margin-top: 10px;
         font-size: 20px;
         color: #fff;
    }
     .btn-circle {
         width: 60px;
         height: 60px;
         text-align: center;
         font-size: 10px;
         border-radius: 50%
    }
     .alert-box {
         border: 2px solid #FF0000;
    }
     .alert-success-box {
         border-color: #00e600
    }
     .pattern_bg1 {
        /* background: rgba(0, 0, 0, 0) url("../install/images/pattern-bg.png") repeat fixed 0 0;
        */
         height: 100%;
         margin: 0;
         padding: 0;
         position: fixed;
         top: 0;
         width: 100%;
    }
     .patt_bg {
         position:relative;
    }
     #logo {
         padding: 20px 0px 30px;
         margin: 0px auto;
         display: block;
         width: 250px;
    }
     #logo img {
         padding:0px;
         margin:0px;
         width:100%;
    }
     .tab-content {
         padding:20px 0px 0px;
         margin:0px;
    }
     .tab_contant {
         padding: 30px;
         margin: 0px auto 30px;
         width: 800px;
         background: rgba(0, 0, 0, 0.6);
         border-radius: 5px;
         display: table;
    }
     .tab_contant p {
         padding: 0px 0px 15px;
         margin: 0px;
         font-size: 16px;
         line-height: 24px;
         color: #fff;
    }
     .tab_contant ol {
         padding:0px 0px 0px 18px;
         margin:0px;
    }
     .tab_contant ol li {
         padding: 0px 0px 10px 0px;
         margin: 0px;
         font-size: 16px;
         color: #fff;
    }
     .next-step, .menu2-step, .prev-step, .menu3-step, .success_grr {
         padding: 10px 10px;
         margin: 0px 0px ;
         width: 100px;
    }
     .form-control {
         height:auto !important;
         padding:12px;
         margin:0px 0px 5px;
         font-size: 15px;
    }
     .form-group label {
         padding: 0px 0px 10px;
         margin: 0px;
         font-size: 16px;
         color: #fff;
         font-weight: 400;
    }
     .text-muted {
         color: #E7E7E7;
         font-weight: 600;
         font-size: 14px;
    }
     .form-group {
         margin-bottom: 25px;
    }
     #errorpass {
         color: #FF9936;
         font-size: 16px;
         font-weight: 400;
    }
     #showemaill_error{
         color: #FF9936;
         font-size: 16px;
         font-weight: 400;
    }
     .pull-right {
         padding:0px;
         margin:0px;
    }
     .btn-info {
         background: #FF7411 !important;
         border: 1px solid #FF7411 !important;
    }
    .test_button {
      padding : 10px;
    }
    .progress {
      display: block;
      text-align: center;
      width: 0;
      height: 3px;
      background: #FF7411;
      transition: width .3s;
    }
    .progress.hide {
      opacity: 0;
      transition: opacity 1.3s;
    }
    .spinner {
      margin: -15px 50px;
      width: 40px;
      height: 40px;
      position: relative;
      text-align: center;

      -webkit-animation: sk-rotate 2.0s infinite linear;
      animation: sk-rotate 2.0s infinite linear;
    }

    .dot1, .dot2 {
      width: 60%;
      height: 60%;
      display: inline-block;
      position: absolute;
      top: 0;
      background-color: #FF7411;
      border-radius: 100%;

      -webkit-animation: sk-bounce 2.0s infinite ease-in-out;
      animation: sk-bounce 2.0s infinite ease-in-out;
    }

    .dot2 {
      top: auto;
      bottom: 0;
      -webkit-animation-delay: -1.0s;
      animation-delay: -1.0s;
    }

    @-webkit-keyframes sk-rotate { 100% { -webkit-transform: rotate(360deg) }}
    @keyframes sk-rotate { 100% { transform: rotate(360deg); -webkit-transform: rotate(360deg) }}

    @-webkit-keyframes sk-bounce {
      0%, 100% { -webkit-transform: scale(0.0) }
      50% { -webkit-transform: scale(1.0) }
    }

    @keyframes sk-bounce {
      0%, 100% {
        transform: scale(0.0);
        -webkit-transform: scale(0.0);
      } 50% {
        transform: scale(1.0);
        -webkit-transform: scale(1.0);
      }
    }
  </style>

    <script type="text/javascript">
      $(document).ready(function() {
       $('.btn-circle').on('click',function(){
         $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');
         $(this).addClass('btn-info').removeClass('btn-default').blur();
       });

       $('.next-step, .prev-step').on('click', function (e){
         var $activeTab = $('.tab-pane.active');

         $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');

         if ( $(e.target).hasClass('next-step') )
         {
            var nextTab = $activeTab.next('.tab-pane').attr('id');
            $('[href="#'+ nextTab +'"]').addClass('btn-info').removeClass('btn-default');
            $('[href="#'+ nextTab +'"]').tab('show');
         }
         else
         {
           var prevTab = $activeTab.prev('.tab-pane').attr('id');
           $('[href="#'+ prevTab +'"]').addClass('btn-info').removeClass('btn-default');
           $('[href="#'+ prevTab +'"]').tab('show');
         }
       });

       $('#menu2_next_btn').on('click', function(e){
         var hostname   = $('#dbhostname').val();
         var dbusername = $('#dbusername').val();
         var dbname     = $('#dbname').val();

         if(hostname == "" || dbusername == "" || dbname == "")
         {
           if(hostname == "")
           {
             $("#dbhostname").addClass('alert-box');
           }

           if(dbusername == "")
           {
             $("#dbusername").addClass('alert-box');
           }

           if(dbname == "")
           {
             $('#dbname').addClass('alert-box');
           }
         }
         else
         {
           $("#dbhostname").removeClass('alert-box');
           $("#dbusername").removeClass('alert-box');
           $('#dbname').removeClass('alert-box');

           var $activeTab = $('.tab-pane.active');

           $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');

           if ( $(e.target).hasClass('menu2-step') )
           {
              var nextTab = $activeTab.next('.tab-pane').attr('id');
              $('[href="#'+ nextTab +'"]').addClass('btn-info').removeClass('btn-default');
              $('[href="#'+ nextTab +'"]').tab('show');
           }
           else
           {
             var prevTab = $activeTab.prev('.tab-pane').attr('id');
             $('[href="#'+ prevTab +'"]').addClass('btn-info').removeClass('btn-default');
             $('[href="#'+ prevTab +'"]').tab('show');
           }
         }
       });

       $('#menu3_next_btn').on('click', function(e){
         var username = $('#adminusername').val();
         var email    = $('#adminemail').val();
         var password = $('#adminpass').val();

         if(username == "" || email == "" || password == "")
         {
           if(username == "")
           {
             $("#adminusername").addClass('alert-box');
           }

           if(email == "")
           {
             $("#adminemail").addClass('alert-box');
           }

           if(password == "")
           {
             $('#adminpass').addClass('alert-box');
           }
         }
         else
         {
           $("#adminusername").removeClass('alert-box');
           $("#adminemail").removeClass('alert-box');
           $('#adminpass').removeClass('alert-box');

           var $activeTab = $('.tab-pane.active');

           $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');

           if ( $(e.target).hasClass('menu3-step') )
           {
              var nextTab = $activeTab.next('.tab-pane').attr('id');
              $('[href="#'+ nextTab +'"]').addClass('btn-info').removeClass('btn-default');
              $('[href="#'+ nextTab +'"]').tab('show');
           }
           else
           {
             var prevTab = $activeTab.prev('.tab-pane').attr('id');
             $('[href="#'+ prevTab +'"]').addClass('btn-info').removeClass('btn-default');
             $('[href="#'+ prevTab +'"]').tab('show');
           }
         }
       });

       $('#dbhostname, #dbusername, #dbname').on('keypress', function(){
         var val = $(this).val();
         if(val.length >= 3)
         {
           $(this).removeClass('alert-box').addClass('alert-success-box');
         }
       });

       $('#adminusername, #adminemail, #adminpass').on('keypress', function(){
         var val = $(this).val();
         if(val.length >= 3)
         {
           $(this).removeClass('alert-box').addClass('alert-success-box');
         }
       });

       $('#adminpass_con').on('blur', function(){
         var pass     = $('#adminpass').val();
         var con_pass = $(this).val();
         if(pass != con_pass)
         {
           $('#errorpass').html('Password Does not match !');
           $('#adminpass, #adminpass_con').addClass('alert-box');
           $('#menu3_next_btn').prop('disabled', true);
         }
         else
         {
           $('#errorpass').html('Password matched');
           $('#adminpass, #adminpass_con').addClass('alert-success-box');
           $('#menu3_next_btn').prop('disabled', false);
         }
       });

       // Check Database Connection

       $('#test_connection').on('click', function() {
         var hostname   = $('#dbhostname').val();
         var dbusername = $('#dbusername').val();
         var password   = $('#password').val();
         var dbname     = $('#dbname').val();

         if(hostname == "" || dbusername == "" || dbname == "")
         {
           if(hostname == "")
           {
             $("#dbhostname").addClass('alert-box');
           }

           if(dbusername == "")
           {
             $("#dbusername").addClass('alert-box');
           }

           if(dbname == "")
           {
             $('#dbname').addClass('alert-box');
           }
         }
         else
         {
           $("#dbhostname").removeClass('alert-box');
           $("#dbusername").removeClass('alert-box');
           $('#dbname').removeClass('alert-box');

           $.ajax({
             xhr: function () {
                 var xhr = new window.XMLHttpRequest();
                 xhr.upload.addEventListener("progress", function (evt) {
                     if (evt.lengthComputable) {
                         var percentComplete = evt.loaded / evt.total;
                         console.log(percentComplete);
                         $('.progress').css({
                             width: percentComplete * 100 + '%'
                         });
                         if (percentComplete === 1) {
                             $('.progress').addClass('hide');
                         }
                     }
                 }, false);
                 xhr.addEventListener("progress", function (evt) {
                     if (evt.lengthComputable) {
                         var percentComplete = evt.loaded / evt.total;
                         console.log(percentComplete);
                         $('.progress').css({
                             width: percentComplete * 100 + '%'
                         });
                     }
                 }, false);
                 return xhr;
             },
             type : "POST",
             url : '<?php echo base_url() ;?>setup/test_connection',
             data : {hostname : hostname, dbusername : dbusername, password : password, dbname : dbname},
             success : function(data)
             {
               $('#myModal').modal('show');
               $('#alert_msg').html(data);
             }
           });
         }

       });

        $("#alert_box").fadeTo(5000, 500).slideUp(500, function(){
          $("#alert_box").slideUp(500);
        });

        $('#setupform').submit(function() {
          $('#submit').hide();
          $('#back_btn').hide();
          $('.spinner').css('display','block');
        });

      });

      function verifyEmail()
      {
        var status = false;
        var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
        if (document.myform.adminemail.value.search(emailRegEx) == -1)
        {
          $('#showemaill_error').html("Please enter a valid email address.");
          $('#menu3_next_btn').prop('disabled', true);
          $('#adminemail').focus();
        }
        else
        {
          $('#showemaill_error').html("");
          $('#menu3_next_btn').prop('disabled', false);
          status = true;
        }
        return status;
      }
    </script>

    </head>

    <body>

      <!-- Popup alert modal -->

      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          <div class="modal-body" id="alert_msg">

          </div>
        </div>
      </div>

      <!-- Session alert box -->

      <?php if($this->session->flashdata('warning')!='') { ?>
        <div class="alert alert-warning alert-dismissable" id="alert_box">
          <p align="center"><strong><?php echo $this->session->flashdata('warning');?></strong></p>
        </div>
      <?php } ?>

      <div class="patt_bg">
         <a href="http://www.desss.com/" tabindex="-1" id="logo" target="_blank">
           <img src="<?php echo base_url() ;?>images/logo.png" />
         </a>

      <div class="tab_contant">
        <div class="process">
          <div class="process-row nav nav-tabs">

            <div class="process-step">
              <?php
                echo form_button(array(
                  'type'        => 'button',
                  'class'       => 'btn btn-info btn-circle',
                  'data-toggle' => 'tab',
                  'disabled'    => 'disabled',
                  'href'        => '#menu1',
                  'content'     => '<i class="fa fa-home fa-3x"></i>'
                ));
              ?>              
              <p> <small>Home</small> </p>
            </div>

            <div class="process-step">
              <?php 
                echo form_button(array(
                  'type'        => 'button',
                  'class'       => 'btn btn-default btn-circle',
                  'data-toggle' => 'tab',
                  'disabled'    => 'disabled',
                  'href'        => '#menu2'                  ,
                  'content'     => '<i class="fa fa-database fa-3x"></i>'
                ));
              ?>             
              <p> <small> Configure	Database </small> </p>
            </div>

            <div class="process-step">
              <?php 
                  echo form_button(array(
                    'type'        => 'button',
                    'class'       => 'btn btn-default btn-circle',
                    'data-toggle' => 'tab',
                    'disabled'    => 'disabled',
                    'href'        => '#menu3',                  
                    'content'     => '<i class="fa fa-user fa-3x"></i>'
                  ));
                ?>
                <p> <small> Create Admin Account </small> </p>
            </div>

            <div class="process-step">
              <?php 
                echo form_button(array(
                  'type'        => 'button',
                  'class'       => 'btn btn-default btn-circle',
                  'data-toggle' => 'tab',
                  'disabled'    => 'disabled',
                  'href'        => '#menu4',
                  'content'     => '<i class="fa fa-check fa-3x"></i>'
                ));
              ?>
              <p> <small> Install </small> </p>
            </div>

          </div>
        </div>

        <div class="progress"></div>
        
        <?php 
          echo form_open(
            base_url('setup/install'),
            'name = "myform" id="setupform"'
          );
        ?>
        
          <div class="tab-content">

            <div id="menu1" class="tab-pane fade active in">

                <p>
                  Welcome to DESSS CMS.
                  Before getting started, we need some information on the database.
                  You will need to know the following items before proceeding.
                </p>
                <ol>
                  <li>Database name</li>
                  <li>Database username</li>
                  <li>Database password</li>
                  <li>Database host</li>
                </ol>
                <p>
                  We are going to use this information to create a <code>database config</code> file.
                </p>
                <p>
                  In all likelihood, these items were supplied to you by your Web Host.
                  If you don&#8217;t have this information, then you will need to contact them before you can continue.
                  If you&#8217;re all ready&hellip;
                </p>

                <?php 
                  echo form_button(array(
                    'type'    => 'button',
                    'id'      => 'menu1_next_btn',
                    'class'   => 'btn btn-info next-step',
                    'content' => 'Next'
                  ));
                ?>

              </div>

            <div id="menu2" class="tab-pane fade">

              <p>Below you should enter your database connection details. If you’re not sure about these, contact your host.</p>

              <?php
                echo form_fieldset( 
                  '',                 
                  array(
                    'class' => 'form-group'
                  )
                );

                echo form_label(
                  'Database Host Name',
                  'dbhostname'                  
                );

                echo form_input(array(
                  'type'        => 'text',
                  'class'       => 'form-control',
                  'name'        => 'dbhostname',
                  'id'          => 'dbhostname',
                  'placeholder' => 'Eg : localhost'
                ));
               
                echo '<small class="text-muted">
                You should be able to get this info from your web host, if <code>localhost</code> doesn&#8217;t work.
                </small>' ;
                
                echo form_fieldset_close();

                echo form_fieldset(
                  '',
                  array(
                    'class' => 'form-group'
                  )
                );
                
                echo form_label(
                  'Database Username',
                  'dbusername'
                );

                echo form_input(array(
                  'type'        => 'text',
                  'class'       => 'form-control',                  
                  'id'          => 'dbusername',
                  'name'        => 'dbusername',
                  'placeholder' => 'Eg : root'
                ));

                echo '<small class="text-muted">Your MySQL Database username.</small>';

                echo form_fieldset_close();

                echo form_fieldset(
                  '',
                  array(
                    'class' => 'form-group'
                  )
                );

                echo form_label(
                  'Database Password',
                  'password'
                );

                echo form_input(array(
                  'type'          => 'password',
                  'class'         => 'form-control',
                  'id'            => 'password',
                  'name'          => 'password',
                  'placeholder'   => '******',
                  'autocomplete'  => 'off'
                ));

                echo '<small class="text-muted">Your MySQL Database Password.</small>';

                echo form_fieldset_close();

                echo form_fieldset(
                  '',
                  array(
                    'class' => 'form-group'
                  )
                );

                echo form_label(
                  'Database Name',
                  'dbname'
                );

                echo form_input(array(
                  'type'        => 'text',
                  'class'       => 'form-control',
                  'id'          => 'dbname',
                  'name'        => 'dbname',
                  'placeholder' => 'Eg : testdb'
                ));

                echo '<small class="text-muted">The name of the database you want to run DESSS CMS in.</small>';

                echo form_fieldset_close();

                echo form_fieldset(
                  '',
                  array(
                    'class' => 'form-group'
                  )
                );

                echo form_label(
                  'Table Prefix',
                  'dbtableprefix'
                );

                echo form_input(array(
                  'type'        => 'text',
                  'class'       => 'form-control',
                  'id'          => 'dbtableprefix',
                  'name'        => 'dbtableprefix',
                  'placeholder' => 'Prefix (optional)'
                ));

                echo form_fieldset_close();

                $list = array(
                  form_button(array(
                    'type'    => 'button',
                    'class'   => 'btn btn-default test_button',
                    'id'      => 'test_connection',
                    'content' => 'Test Connection'
                  )),
                  form_button(array(
                    'type'    => 'button',
                    'class'   => 'btn btn-default prev-step',
                    'content' => 'Back'
                  )),
                  form_button(array(
                    'type'    => 'button',
                    'id'      => 'menu2_next_btn',
                    'class'   => 'btn btn-info menu2-step',
                    'content' => 'Next'
                  ))
                );

                $list_attributes = array(
                  'class' => 'list-unstyled list-inline pull-right'
                );

                echo ul($list, $list_attributes);

              ?>
            </div>

            <div id="menu3" class="tab-pane fade">
              <p>Add Administrator account</p>
              
              <?php 
                echo form_fieldset(
                  '',
                  array(
                    'class' => 'form-group'
                  )
                );

                echo form_label(
                  'First Name',
                  'firstname'
                );

                echo form_input(array(
                  'type'        => 'text',
                  'class'       => 'form-control',
                  'name'        => 'firstname',
                  'id'          => 'firstname',
                  'placeholder' => 'First Name',
                  'required'    => 'required' 
                ));

                echo form_fieldset_close();

                echo form_fieldset(
                  '',
                  array(
                    'class' => 'form-group'
                  )
                );

                echo form_label(
                  'Last Name',
                  'lastname'
                );

                echo form_input(array(
                  'type'        => 'text',
                  'class'       => 'form-control',
                  'name'        => 'lastname',
                  'placeholder' => 'Last Name',
                  'required'    => 'required'
                ));

                echo form_fieldset_close();

                echo form_fieldset(
                  '',
                  array(
                    'class' => 'form-group'
                  )
                );

                echo form_label(
                  'User Name',
                  'adminusername'
                );

                echo form_input(array(
                  'type'        => 'text',
                  'class'       => 'form-control',
                  'name'        => 'adminusername',
                  'id'          => 'adminusername',
                  'placeholder' => 'Username'
                ));

                echo form_fieldset_close();

                echo form_fieldset(
					  '',
					  array(
						'class' => 'form-group'
					  )
					);

                echo form_label(
                  'Email address',
                  'adminemail'
                );

                echo form_input(array(
                  'type'        => 'email',
                  'class'       => 'form-control',
                  'name'        => 'adminemail',
                  'id'          => 'adminemail',
                  'onblur'      => 'verifyEmail()',
                  'placeholder' => 'Email'
                ));

                echo '<span id="showemaill_error"></span>';

                echo form_fieldset_close();

                echo form_fieldset(
                  '',
                  array(
                    'class' => 'form-group'
                  )
                );

                echo form_label(
                  'Password',
                  'adminpass'
                );

                echo form_input(array(
					  'type'        => 'password',
					  'class'       => 'form-control',
					  'name'        => 'adminpass',
					  'id'          => 'adminpass',
					  'placeholder' => 'Password'
					));

                echo form_fieldset_close();

                echo form_fieldset(
                  '',
                  array(
                    'class' => 'form-group'
                  )
                );

                echo form_label(
                  'Confirm Password',
                  'adminpass_con'
                );

                echo form_input(array(
                  'type'        => 'password',
                  'class'       => 'form-control',
                  'name'        => 'adminpass_con',
                  'id'          => 'adminpass_con',
                  'placeholder' => 'Confirm Password'
                ));

                echo '<span id="errorpass"></span>';

                echo form_fieldset_close();

                $list_btn = array(
                  form_button(array(
                    'type'    => 'button',
                    'class'   => 'btn btn-default prev-step',
                    'content' => 'Back'
                  )),
                  form_button(array(
                    'type'    => 'button',
                    'class'   => 'btn btn-info menu3-step',
                    'id'      => 'menu3_next_btn',
                    'content' => 'Next'
                  ))
                );

                $list_btn_attributes = array(
                  'class' => 'list-unstyled list-inline pull-right'
                );

                echo ul($list_btn, $list_btn_attributes);
              ?>
            </div>

            <div id="menu4" class="tab-pane fade">
              <p>
                All right, sparky! You’ve made it through this part of the installation.
                DESSS CMS TOOL can now communicate with your database. If you are ready, time now to…
              </p>
              
              <?php 
                $list_install = array(
                  form_button(array(
                    'type'    => 'button',
                    'id'      => 'back_btn',
                    'class'   => 'btn btn-default prev-step',
                    'content' => 'Back'
                  )),
                  form_button(array(
                    'type'  => 'submit',
                    'name'  => 'submit',
                    'id'    => 'submit',
                    'class' => 'btn btn-success success_grr',
                    'content' => '<i class="fa fa-check"></i> Install'
                  )).'<!-- Spinner -->
                  <div class="spinner" style="display:none;">
                  <div class="dot1"></div>
                  <div class="dot2"></div>
                </div>
                  '
                );

                $list_install_att = array(
                  'class' => 'list-unstyled list-inline pull-right'
                );
                echo ul($list_install, $list_install_att);
              ?>              
            </div>
          </div>
        </form>
      </div>
	</div>
</body>
</html>

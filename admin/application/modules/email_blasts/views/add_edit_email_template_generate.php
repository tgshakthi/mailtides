<?php
function include_script(string $url, string $version='', string $path=''){
	if(filter_var($url, FILTER_VALIDATE_URL)===false)
	{
		if(empty($path))
			$path = $url;
			
		$version = preg_replace("/[^0-9\.\_]/Ui","",$version);
		
		$id = '';
		if(file_exists($path) || file_exists(dirname(__FILE__).$path) || file_exists(dirname(__FILE__).'/'.$path))
		{
			$id = sprintf("?version=%d.%d.%d",filemtime($path),filesize($path),strlen($path));
		}
		else
		{
			if(!empty($version))
				$id = sprintf("?version=%s.%d",$version,strlen($url));
		}
	}
	else
	{
		if(!empty($version))
				$id = sprintf("?version=%s.%d",$version,strlen($url));
	}
	
	$url = $url.$id;
	
	printf('<script src="%s"></script>%s',$url,PHP_EOL);
}

function include_style(string $url, string $version='', string $path=''){
	if(filter_var($url, FILTER_VALIDATE_URL)===false)
	{
		if(empty($path))
			$path = $url;
			
		$version = preg_replace("/[^0-9\.\_]/Ui","",$version);
		
		$id = '';
		if(file_exists($path) || file_exists(dirname(__FILE__).$path) || file_exists(dirname(__FILE__).'/'.$path))
		{
			$id = sprintf("?version=%d.%d.%d",filemtime($path),filesize($path),strlen($path));
		}
		else
		{
			if(!empty($version))
				$id = sprintf("?version=%s.%d",$version,strlen($url));
		}
	}
	else
	{
		if(!empty($version))
				$id = sprintf("?version=%s.%d",$version,strlen($url));
	}
	
	$url = $url.$id;
	
	printf('<link href="%s" rel="stylesheet">%s',$url,PHP_EOL);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <script type="text/javascript">

        // console.log(window.location.href);

        if (window.location.href == "http://txgidocs.mailtides.com/admin/email_blasts/add_edit_email_template_generate/") {
            window.location.href = "http://txgidocs.mailtides.com/admin/email_blasts/add_edit_email_template_generate/#no-sidebar";
        } 

        // if (window.location.href == "http://localhost/mail-editor/#left-sidebar") {
        //     window.location.reload("http://localhost/mail-editor/#left-sidebar");
        //     // window.location.href = ;
        // } 

        /*<![CDATA[*/
        /*
         * SETUP BASE URL
         * @author         Ivijan-Stefan Stipic <creativform@gmail.com>
         *
         * AVAILABLE OBJECTS
         * window.base              //- Define base URL of this application
         * window.session_id        //- Define unique session ID for current user [timestamp-random]
         * window.start_time        //- Define current start loading timestamp in microseconds
         */
        (function (base, search, replace) {

            window.start_time = Math.round(new Date().getTime() / 1000);

            var extend = function (a, b) {
                    for (var key in b)
                        if (b.hasOwnProperty(key))
                            a[key] = b[key];
                    return a;
                },
                refactor = function () {

                    if (!replace)
                        replace = true;

                    var elements = extend({
                            script: 'src',
                            img: 'src',
                            link: 'href',
                            a: 'href',
                        }, search),
                        generateID = function (min, max) {
                            min = min || 0;
                            max = max || 0;

                            if (
                                min === 0 ||
                                max === 0 ||
                                !(typeof (min) === "number" ||
                                    min instanceof Number) ||
                                !(typeof (max) === "number" ||
                                    max instanceof Number)
                            )
                                return Math.floor(Math.random() * 999999) + 1;
                            else
                                return Math.floor(Math.random() * (max - min + 1)) + min;
                        };

                    var baseURL = window.location.protocol + '//' + window.location.hostname + base;

                    if (localStorage.getItem("session_id")) {
                        window.session_id = localStorage.getItem("session_id");
                    } else {
                        var generate = new Date().getTime() + '-' + generateID(10000, 99999) + '' + generateID(
                            100000, 999999) + '' + generateID(1000000, 9999999) + '' + generateID(10000000,
                            99999999);
                        window.session_id = generate;
                        localStorage.setItem("session_id", generate);
                    }

                    localStorage.setItem("baseURL", baseURL);
                    window.base = baseURL;

                    for (tag in elements) {
                        var list = document.getElementsByTagName(tag)
                        listMax = list.length;
                        if (listMax > 0) {
                            for (i = 0; i < listMax; i++) {
                                var src = list[i].getAttribute(elements[tag]);
                                if (
                                    !(/^(((a|o|s|t)?f|ht)tps?|s(cp|sh)|as2|chrome|about|javascript)\:(\/\/)?([a-z0-9]+)?/gi
                                        .test(src)) &&
                                    !(/^#\S+$/gi.test(src)) &&
                                    '' != src &&
                                    null != src &&
                                    replace
                                ) {
                                    src = baseURL + '/' + src;
                                    list[i].setAttribute('src', src);
                                }
                            }
                        }
                    }

                }
            document.addEventListener("DOMContentLoaded", function () {
                refactor();
            });
        }('/mail-editor'));

        if (localStorage.getItem("baseURL")) {
            window.base = localStorage.getItem("baseURL");
        }
        if (localStorage.getItem("session_id")) {
            window.session_id = localStorage.getItem("session_id");
        }
        /* ]]> */
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MAIL EDITOR</title>

    <?=include_style('assets/css/bootstrap.min.css'); ?>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <?=include_style('assets/css/bootstrap-colorpicker.min.css'); ?>
    <?=include_style('assets/css/bootstrap-slider.min.css'); ?>
    <?=include_style('assets/plugins/medium-editor/medium-editor.min.css'); ?>
    <?=include_style('assets/plugins/medium-editor/template.min.css'); ?>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
    <link href="https://fonts.googleapis.com/css?family=Allerta+Stencil|Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <?=include_style('assets/css/style.css'); ?>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class="container-fullscreen">
        <div class="top-header">
            <a href="#" class="logo">Mail Template</a>

            <div class="mini-setting">
                <button type="button" class="btn" onclick="openNav()">
                <i class="fas fa-file-invoice"></i> Choose Template
                </button>
                <!-- <a href="http://localhost/mail-editor/#left-sidebar" class="btn btn-primary" id="left-sidebar">Left Sidebar</a> -->
            </div>
        </div>
       
        <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <ul>
      <li>
      <a href="http://txgidocs.mailtides.com/admin/email_blasts/add_edit_email_template_generate/#no-sidebar" class="btn" id="no-sidebar">
      <img src="http://txgidocs.mailtides.com/admin/assets/email-blast/image/no-sidebar.jpg" class="img-responsive" alt="">
      <span>No Sidebar</span></a>
      </li>
      <li>
      <a href="http://txgidocs.mailtides.com/admin/email_blasts/add_edit_email_template_generate/#left-sidebar" class="btn " id="left-sidebar">
      <img src="http://txgidocs.mailtides.com/admin/assets/email-blast/image/left-sidebar.jpg" class="img-responsive" alt="">
      <span>Left Sidebar</span></a>
      </li>
      <li>
      <a href="http://txgidocs.mailtides.com/admin/email_blasts/add_edit_email_template_generate/#right-sidebar" class="btn" id="right-sidebar">
      <img src="http://txgidocs.mailtides.com/admin/assets/email-blast/image/right-sidebar.jpg" class="img-responsive" alt="">
      <span>Right Sidebar</span></a>
          </li>
          <li>
          <a href="http://txgidocs.mailtides.com/admin/email_blasts/add_edit_email_template_generate/#both-sidebar" class="btn" id="both-sidebar">
          <img src="http://txgidocs.mailtides.com/admin/assets/email-blast/image/both-sidebar.jpg" class="img-responsive" alt="">
          <span>Both Sidebar</span></a>
          </li>
  </ul>
 
</div>

        <div class="text-center" style="display:none">
                            <div id="choose-template" class="text-center hidden">
                                <button class="choose" type="button" data-id="no-sidebar"><img
                                        src="assets/img/no-sidebar.jpg" class="img-responsive" alt=""><span>No Sidebar
                                        (wide)</span></button>
                                <button class="choose" type="button" data-id="left-sidebar"><img
                                        src="assets/img/left-sidebar.jpg" class="img-responsive" alt=""><span>Left
                                        Sidebar</span></button>
                                <button class="choose" type="button" data-id="right-sidebar"><img
                                        src="assets/img/right-sidebar.jpg" class="img-responsive" alt=""><span>Right
                                        Sidebar</span></button>
                                <button class="choose" type="button" data-id="both-sidebar"><img
                                        src="assets/img/both-sidebar.jpg" class="img-responsive" alt=""><span>Both
                                        Sidebars</span></button>
                            </div>
                        </div>


        <div class="container-sidebar hidden" id="option-tabs">

            <div id="get-options" class="">
                <h4>Blocks</h4>
                <!--    <div class="get-options choose" data-id="title" id="title"><span class="glyphicon glyphicon-text-size"></span><div>Heading</div></div>  -->
                <div class="get-options choose" data-id="content" id="content"><span
                        class="glyphicon glyphicon-list-alt"></span>
                    <div>Text</div>
                </div>
                <div class="get-options choose" data-id="image" id="image"><span
                        class="glyphicon glyphicon-picture"></span>
                    <div>Image</div>
                </div>
                <div class="get-options choose" data-id="link" id="link">
                    <span class="glyphicon glyphicon-link"></span>
                    <div>Link</div>
                </div>
                <div class="get-options choose" data-id="video" id="video"><span
                        class="glyphicon glyphicon-play"></span>
                    <div>Video</div>
                </div>
                <div class="get-options choose" data-id="divider" id="divider"><span
                        class="glyphicon glyphicon-minus"></span>
                    <div>Divider</div>
                </div>
                <!--    <div class="get-options choose" data-id="quote" id="quote"><span class="glyphicon glyphicon-comment"></span><div>Blockquote</div></div> -->
                <div id="editor"></div>
                <ul id="attach-data" class="list-group"></ul>
            </div>

        </div>
        <div class="container-content hidden" id="mail-template">
            Content
        </div>


    </div>
    <div id="modal" class="reset-this"></div>
    <button class="btn btn-lg preview-green btn-materialize btn-left-bottom btn-left-bottom-1 hidden" type="button"
        id="preview" title="Preview" data-toggle="tooltip" data-placement="left" data-trigger="hover"><span
            class="glyphicon glyphicon-zoom-in"></span></button>

    <form method="post" enctype="multipart/form-data"
        class="btn btn-lg layout-blue btn-materialize btn-left-bottom btn-left-bottom-2 hidden" type="button"
        id="attachment" title="Attachment 7Mb Max" data-toggle="tooltip" data-placement="left" data-trigger="hover">
        <span class="glyphicon glyphicon-paperclip"></span><input type="file" name="attachment[]"></form>

    <button class="btn btn-lg setting-red btn-materialize btn-left-bottom btn-left-bottom-3 hidden" type="button"
        id="setting" title="Layout Options" data-toggle="tooltip" data-placement="left" data-trigger="hover"><span
            class="fa fa-cog fa-spin"></span></button>

    <div id="alerts"></div>

    <div class="tools tools-left animate-right" id="settings">
        <div class="tools-header">
            <button type="button" class="close" data-dismiss="tools" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            <h4><span class="fa fa-cog fa-spin"></span> Settings</h4>
        </div>
        <div class="tools-body">
            <h5 class="text-left option-title">Layout</h5>
            <div class="form-horizontal">


                <div class="form-group">
                    <label for="body-layout-bkg-color-form" class="col-sm-6 control-label text-left">Background
                        Color:</label>
                    <div class="col-sm-6">
                        <div id="body-layout-bkg-color" class="input-group colorpicker-component">
                            <span class="input-group-addon"><i></i></span>
                            <input type="text" value="" class="form-control input-sm" id="body-layout-bkg-color-form">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="body-layout-bkg-color-form" class="col-sm-6 control-label text-left">Body Color:</label>
                    <div class="col-sm-6">
                        <div id="body-layout-bkg-color-body" class="input-group colorpicker-component">
                            <span class="input-group-addon"><i></i></span>
                            <input type="text" value="" class="form-control input-sm"
                                id="body-layout-bkg-color-body-form">
                        </div>
                    </div>
                </div>

            </div>

            <h5 class="text-left option-title">Header Section</h5>
            <div class="form-horizontal">

                <div class="form-group">
                    <label for="head-bkg-color-form" class="col-sm-6 control-label text-left">Background Color:</label>
                    <div class="col-sm-6">
                        <div id="head-bkg-color" class="input-group colorpicker-component">
                            <span class="input-group-addon"><i></i></span>
                            <input type="text" value="" class="form-control input-sm" id="head-bkg-color-form">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="head-height" class="col-sm-4 control-label text-left">Height:</label>
                    <div class="col-sm-8 text-right">
                        <input type="text" class="form-control input-sm" id="head-height" data-slider-min="0"
                            data-slider-max="1000" data-slider-step="10"
                            data-slider-value="0">&nbsp;&nbsp;&nbsp;<small>Height: <span
                                id="head-height-val">auto</span></small>
                    </div>
                </div>

            </div>

            <div id="dd-body-exists">
                <h5 class="text-left option-title">Content Section</h5>
                <div class="form-horizontal">

                    <div class="form-group">
                        <label for="content-bkg-color-form" class="col-sm-6 control-label text-left">Background
                            Color:</label>
                        <div class="col-sm-6">
                            <div id="content-bkg-color" class="input-group colorpicker-component">
                                <span class="input-group-addon"><i></i></span>
                                <input type="text" value="" class="form-control input-sm" id="content-bkg-color-form">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content-height" class="col-sm-4 control-label text-left">Height:</label>
                        <div class="col-sm-8 text-right">
                            <input type="text" class="form-control input-sm" id="content-height" data-slider-min="0"
                                data-slider-max="1000" data-slider-step="10"
                                data-slider-value="0">&nbsp;&nbsp;&nbsp;<small>Height: <span
                                    id="content-height-val">auto</span></small>
                        </div>
                    </div>

                </div>
            </div>

            <div id="dd-sidebar-left-exists">
                <h5 class="text-left option-title">Left Sidebar Section</h5>
                <div class="form-horizontal">

                    <div class="form-group">
                        <label for="left-bkg-color-form" class="col-sm-6 control-label text-left">Background
                            Color:</label>
                        <div class="col-sm-6">
                            <div id="left-bkg-color" class="input-group colorpicker-component">
                                <span class="input-group-addon"><i></i></span>
                                <input type="text" value="" class="form-control input-sm" id="left-bkg-color-form">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="left-height" class="col-sm-4 control-label text-left">Height:</label>
                        <div class="col-sm-8 text-right">
                            <input type="text" class="form-control input-sm" id="left-height" data-slider-min="0"
                                data-slider-max="1000" data-slider-step="10"
                                data-slider-value="0">&nbsp;&nbsp;&nbsp;<small>Height: <span
                                    id="left-height-val">auto</span></small>
                        </div>
                    </div>

                </div>
            </div>

            <div id="dd-sidebar-right-exists">
                <h5 class="text-left option-title">Right Sidebar Section</h5>
                <div class="form-horizontal">

                    <div class="form-group">
                        <label for="right-bkg-color-form" class="col-sm-6 control-label text-left">Background
                            Color:</label>
                        <div class="col-sm-6">
                            <div id="right-bkg-color" class="input-group colorpicker-component">
                                <span class="input-group-addon"><i></i></span>
                                <input type="text" value="" class="form-control input-sm" id="right-bkg-color-form">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="right-height" class="col-sm-4 control-label text-left">Height:</label>
                        <div class="col-sm-8 text-right">
                            <input type="text" class="form-control input-sm" id="right-height" data-slider-min="0"
                                data-slider-max="1000" data-slider-step="10"
                                data-slider-value="0">&nbsp;&nbsp;&nbsp;<small>Height: <span
                                    id="right-height-val">auto</span></small>
                        </div>
                    </div>

                </div>
            </div>

            <h5 class="text-left option-title">Footer Section</h5>
            <div class="form-horizontal">

                <div class="form-group">
                    <label for="footer-bkg-color-form" class="col-sm-6 control-label text-left">Background
                        Color:</label>
                    <div class="col-sm-6">
                        <div id="footer-bkg-color" class="input-group colorpicker-component">
                            <span class="input-group-addon"><i></i></span>
                            <input type="text" value="" class="form-control input-sm" id="footer-bkg-color-form">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="footer-height" class="col-sm-4 control-label text-left">Height:</label>
                    <div class="col-sm-8 text-right">
                        <input type="text" class="form-control input-sm" id="footer-height" data-slider-min="0"
                            data-slider-max="1000" data-slider-step="10"
                            data-slider-value="0">&nbsp;&nbsp;&nbsp;<small>Height: <span
                                id="footer-height-val">auto</span></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="tools-footer">
            <div class="button-group text-center">
                <button class="btn btn-success btn-sm" data-dismiss="tools" type="button" id="send-message"><span
                        class="glyphicon glyphicon-ok"></span> I'm Done</button>
                <button class="btn btn-primary btn-sm" type="button" id="test"><span
                        class="glyphicon glyphicon-envelope"></span> Send Test</button>
                <button class="btn btn-danger btn-sm" type="button" id="delete"><span
                        class="glyphicon glyphicon-remove-sign"></span> Delete Project</button>
            </div>
        </div>
    </div>
    


    <script>
        const leftSideBarBtn = document.querySelector('#left-sidebar');
        const rightSideBarBtn = document.querySelector('#right-sidebar');
        const noSideBarBtn = document.querySelector('#no-sidebar');
        const bothSideBarBtn = document.querySelector('#both-sidebar');

        leftSideBarBtn.addEventListener('click', () => {
            window.location.href = "http://txgidocs.mailtides.com/admin/email_blasts/add_edit_email_template_generate/#left-sidebar";
            window.location.reload();
        });

        noSideBarBtn.addEventListener('click', () => {
            window.location.href = "http://txgidocs.mailtides.com/admin/email_blasts/add_edit_email_template_generate/#no-sidebar";
            window.location.reload();
        });

        rightSideBarBtn.addEventListener('click', () => {
            window.location.href = "http://txgidocs.mailtides.com/admin/email_blasts/add_edit_email_template_generate/#right-sidebar";
            window.location.reload();
        });

        bothSideBarBtn.addEventListener('click', () => {
            window.location.href = "http://txgidocs.mailtides.com/admin/email_blasts/add_edit_email_template_generate/#both-sidebar";
            window.location.reload();
        });

    </script>
<script>

function openNav() {
  document.getElementById("mySidenav").style.width = "260px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>
</body>

</html>

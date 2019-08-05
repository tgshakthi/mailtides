<!DOCTYPE html>
 
<html>
 
<head>
 
   <title>Implement Captcha in Codeigniter using helper</title>
 <script src="http://192.168.1.43/zcms/assets/theme/default/js/jquery-3.2.1.min.js">
   <script>
 
       $(document).ready(function(){
 
           $('.captcha-refresh').on('click', function(){
 
               $.get('<?php echo base_url().'captcha/refresh'; ?>', function(data){
 
                   $('#image_captcha').html(data);
 
               });
 
           });
 
       });
 
   </script>
 
   
 
</head>
 
<body>
 
<p id="image_captcha"><?php echo $captchaImg; ?></p>
 
<a href="javascript:void(0);" class="captcha-refresh" >refresh</a>
 
<form method="post">
 
   <input type="text" name="captcha" value=""/>
 
   <input type="submit" name="submit" value="SUBMIT"/>
 
</form>
 
</body>
 
</html>
<?php
/**
 * Desss CMS
 * Install Setup and Database Configuration
 * Created at : 07-Mar-2018
 * Author : Saravana
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Setup extends CI_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->library('session');
    }

    function index()
    {
      $this->load->view('setup');
    }

    // Test Database connection

    function test_connection()
    {
      $hostname   = $this->input->post('hostname');
      $dbusername = $this->input->post('dbusername');
      $password   = $this->input->post('password');
      $dbname     = $this->input->post('dbname');

      $con = $this->checkDBconnection($hostname, $dbusername, $password, $dbname);

      if (is_array($con)) :

        echo '<div class="alert alert-danger alert-dismissible" style="text-align:center">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong> Error:  '. $con[1].' </strong>
        </div>';
      	exit();

      else :

        echo '<div class="alert alert-success alert-dismissible" style="text-align:center">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong> Connection established </strong>
        </div>';

      endif;

    }

    // check MYSQL Database connection
    function checkDBconnection($hostname, $dbusername, $password, $dbname)
    {
      $con = @new mysqli($hostname, $dbusername, $password, $dbname);

      if ($con->connect_error) :
        $output[] = 0;
        $output[] = $con->connect_error;
        return $output;
      	exit();
      else :
        return 1;
      endif;

    }

    // Install
    function install()
    {
      $dbhostname    = $this->input->post('dbhostname');
      $dbusername    = $this->input->post('dbusername');
      $dbpassword    = $this->input->post('password');
      $dbname        = $this->input->post('dbname');
      $dbtableprefix = ($this->input->post('dbtableprefix') != "") ? trim($this->input->post('dbtableprefix')) : 'tbl_';
      $adminfname    = $this->input->post('firstname');
      $adminlname    = $this->input->post('lastname');
      $adminuser     = $this->input->post('adminusername');
      $adminemail    = $this->input->post('adminemail');
      $adminpass     = $this->input->post('adminpass');
      $adminpass_con = md5($this->input->post('adminpass_con'));

      if (empty($dbhostname) && empty($dbusername) && empty($dbname))
      {
        $this->session->set_flashdata('warning', 'Something went Wrong. Please try again !');
        redirect('setup.html', 'location');
        exit;
      }
      $connectiontest = $this->checkDBconnection(
        $dbhostname,
        $dbusername,
        $dbpassword,
        $dbname
      );

      if(isset($connectiontest) && !is_array($connectiontest))
      {
        // Front end Base Path

        $fbaseurl  = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].'/zcms/';
        $fbase_url = "['base_url'] = '$fbaseurl'";

        $searchFrontConfArr  = "['base_url'] = (isset(\$_SERVER['HTTPS']) ? 'https://' : 'http://') . \$_SERVER['HTTP_HOST'].'/zcms/'";
        $replaceFrontConfArr = $fbase_url;

        //File Path

        $ConfigFromcopyPath  = APPPATH .'config\config.php';
        $ConfigTocopyPath    = APPPATH .'config\config.php';

        //Replace content

        $this->CredentialConf(
          $ConfigFromcopyPath,
          $searchFrontConfArr,
          $replaceFrontConfArr,
          $ConfigTocopyPath,
          $ConfigFromcopyPath,
          $ConfigTocopyPath
        );

        //Front end Database

        $searchArray  = array(
          "'hostname' => 'localhost'",
          "'username' => ''",
          "'password' => ''",
          "'database' => ''",
          "'dbprefix' => ''"
        );
        $replaceArray = array(
          "'hostname' => '$dbhostname'",
          "'username' => '$dbusername'",
          "'password' => '$dbpassword'",
          "'database' => '$dbname'",
          "'dbprefix' => '$dbtableprefix'"
        );

        // Get Content From File Path
        $FromcopyPath = APPPATH .'config\database.php';
        $TocopyPath   = APPPATH .'config\database.php';

        // Replace content
        $this->CredentialConf(
          $FromcopyPath,
          $searchArray,
          $replaceArray,
          $TocopyPath,
          $FromcopyPath,
          $TocopyPath
        );

        //Admin Config Base URL;

        $adminurl = APPPATH;
        $adminurl = str_replace('application', 'admin', $adminurl);

        // Admin autoload

        $adminautoload_path = $adminurl.'application\config\autoload.php';
        $searchautoload     = "['libraries'] = array();";
        $replaceautoload    = "['libraries'] = array('session', 'form_validation', 'database', 'table');";

        $this->CredentialConf(
			  $adminautoload_path,
			  $searchautoload,
			  $replaceautoload,
			  $adminautoload_path,
			  $adminautoload_path,
			  $adminautoload_path
			);

        // Admin change base url

        $adminConfPath  = $adminurl.'application\config\config.php';
        $adminbase_url  = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].'/zcms/admin/';
        $adminbase_url  = "['base_url'] = '$adminbase_url'";
        $searchConfArr  = "['base_url'] = (isset(\$_SERVER['HTTPS']) ? 'https://' : 'http://') . \$_SERVER['HTTP_HOST'].'/zcms/admin/'";
        $replaceConfArr = $adminbase_url;

        $this->CredentialConf(
          $adminConfPath,
          $searchConfArr,
          $replaceConfArr,
          $adminConfPath,
          $adminConfPath,
          $adminConfPath
        );

        // Admin Config Database

        $adminDbgetPath = $adminurl.'application\config\database.php';
        $searchDbArr    = array(
          "'hostname' => 'localhost'",
          "'username' => ''",
          "'password' => ''",
          "'database' => ''",
          "'dbprefix' => ''"
        );
        $replaceDbArr   = array(
          "'hostname' => '$dbhostname'",
          "'username' => '$dbusername'",
          "'password' => '$dbpassword'",
          "'database' => '$dbname'",
          "'dbprefix' => '$dbtableprefix'"
        );
        $adminDbpath = $adminurl.'application\config\database.php';

        $this->CredentialConf(
          $adminDbpath,
          $searchDbArr,
          $replaceDbArr,
          $adminDbpath,
          $adminDbpath,
          $adminDbpath
        );

        // Front end Routes

        $FromroutePath = APPPATH .'config\routes.php';
        $ToroutePath   = APPPATH .'config\routes.php';

        $searchRoutesArr = "['default_controller'] = 'setup'";
        $replaceRouteArr = "['default_controller'] = 'Page'";

        $this->CredentialConf(
          $FromroutePath,
          $searchRoutesArr,
          $replaceRouteArr,
          $ToroutePath,
          $FromroutePath,
          $ToroutePath
        );

        // Back end Routes

        $FromBackEndroutePath = $adminurl.'application\config\routes.php';
        $ToBackEndroutePath   = $adminurl.'application\config\routes.php';

				$searchBackEndRoutesArr = "['default_controller'] = 'error_dbconnect'";
        $replaceBackEndRouteArr = "['default_controller'] = 'login'";

        $this->CredentialConf(
          $FromBackEndroutePath,
          $searchBackEndRoutesArr,
          $replaceBackEndRouteArr,
          $ToBackEndroutePath,
          $FromBackEndroutePath,
          $ToBackEndroutePath
        );

        // Create Tables
				$this->load->model('Setup_model');
				$this->Setup_model->CreateTable();

				// Insert Data
				$this->load->model('Insert_data_model');
        $this->Insert_data_model->insertData();

        $webiste_data = array(
          'website_name' => 'Your Site',
          'website_url'  => $fbaseurl,
          'logo'         => 'images/no-logo.png',
          'status'       => '1',
          'created_at'   => date("m-d-Y")
        );

        $this->db->insert('websites', $webiste_data);
        $website_id = $this->db->insert_id();

        $data = array(
          'first_name'    => $adminfname,
          'last_name'     => $adminlname,
          'username'      => $adminuser,
          'password'      => $adminpass_con,
          'email'         => $adminemail,
          'gender'        => NULL,
          'user_role_id'  => '2',
          'website_id'    => $website_id,
          'created_at'    => date("m-d-Y")
        );

        $this->db->insert('admin_user', $data);

        redirect('index.html', 'location');
      }
      else
      {
          $this->session->set_flashdata('warning', 'Something went Wrong. Please try again !');
          redirect('setup.html', 'location');
          exit;
      }

    }

    // Configuration Setup

    /*
        Parameters
        1. Get Content From File Path
        2. Search Content
        3. Replace content
        4. Copy Content From File Path
        5. Paste Content To File Path
    */

    function CredentialConf($getContent_path, $searchArray, $replaceArray, $putContent_path, $copyFromPath, $copyToPath)
    {
      $str     = file_get_contents($getContent_path);
      $new_str = str_replace($searchArray, $replaceArray, $str);
      $newStr  = file_put_contents($putContent_path, $new_str);
      copy($copyFromPath, $copyToPath);
    }
}
?>

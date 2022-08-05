<?php

function baseUrl()
{
   return sprintf(
      "%s://%s%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME'],
      $_SERVER['REQUEST_URI']
   );
}

$dirname = str_replace('install','/application/config/database.php',dirname(__FILE__));
if(filesize($dirname) != 0)
{
   $baseUrl = str_replace('install/','login',baseUrl());
   header('Location: '.$baseUrl);
}

error_reporting(0);
$db_config_path = '../application/config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST) {
    
	require_once('taskCoreClass.php');
	require_once('includes/databaseLibrary.php');

	$core = new Core();
	$database = new Database();

	if($core->checkEmpty($_POST) == true)
	{
      if($core->confirmPassword($_POST) == true)
      {
         if($database->create_database($_POST) == false)
         {
            $warning_msg = $core->show_message('error',"The database could not be created, make sure your the host, username, password, database name is correct.");
         } 
         else if ($core->write_config($_POST) == false)
         {
            $warning_msg = $core->show_message('error',"The database configuration file could not be written, please chmod application/config/database.php file to 777");
         }
         else if ($database->create_tables($_POST) == false)
         {
            $warning_msg = $core->show_message('error',"The database could not be created, make sure your the host, username, password, database name is correct.");
         }
         else if ($core->checkFile() == false)
         {
            $warning_msg = $core->show_message('error',"File application/config/database.php is Empty");
         }
      }
      else
      {
         $warning_msg = $core->show_message('error','Password confirmation mismatch');
      }

		if(!isset($warning_msg)) {

         $success_msg = $core->show_message('success','It will take a few seconds, please wait!');

         $baseUrl = str_replace('index.php','welcome.php?fname='.$_POST['txt_firstName'],baseUrl());
         header('refresh:10;url='.$baseUrl);
		}
	}
	else {
		$warning_msg = $core->show_message('error','The host, username, password, database name, and URL are required.');
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Install | Welcome to Installer CodeIginter by Abed Putra</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
      <div class="container">

         <?php 
         if(is_writable($db_config_path))
         {
         ?>
            <?php 
            if(isset($warning_msg)) {
               echo '
               <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
               ' . $warning_msg . '
               </div>';
            }
            else if(isset($success_msg))
            {
               echo '
               <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
               ' . $success_msg . '
               </div>';
            }
            ?>
            
            <form id="install_form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <h1>Database Config</h1>
                        <hr>
                        <div class="form-group">
                            <label for="hostname">Hostname</label>
                            <input type="text" id="hostname" value="localhost" class="form-control" name="hostname" />
                        </div>
                        
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" class="form-control" name="username" />
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" name="password" />
                        </div>
                        
                        <div class="form-group">
                            <label for="database">Database Name</label>
                            <input type="text" id="database" class="form-control" name="database" />
                        </div>
                                        
                        <div class="form-group">
                            <label for="database">CodeIgniter Version</label>
                            <select class="form-control" id="template" name="template">
                                <option value="3">3</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <h1>Create User</h1>
                        <hr>
                        <div class="form-group">
                            <label for="hostname">Salutation</label>
                            <select class="form-control" id="slc_salutation" name="slc_salutation">
                                <option value="Mr.">Mr.</option>
                                <option value="Ms.">Ms.</option>
                                <option value="Mrs.">Mrs.</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="txt_firstName">First Name</label>
                            <input type="text" id="txt_firstName" class="form-control" name="txt_firstName" />
                        </div>
                        
                        <div class="form-group">
                            <label for="txt_lastName">Last Name</label>
                            <input type="text" id="txt_lastName" class="form-control" name="txt_lastName" />
                        </div>
                        
                        <div class="form-group">
                            <label for="txt_email">Email</label>
                            <input type="email" id="txt_email" class="form-control" name="txt_email" />
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <div class="form-group">
                                    <label for="txt_password">Password</label>
                                    <input type="password" class="form-control" id="txt_password" name="txt_password" />
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="form-group">
                                    <label for="txt_confirmPassword">Confirm Password</label>
                                    <input type="password" class="form-control" id="txt_confirmPassword" name="txt_confirmPassword" />
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
                <hr>
                <input type="submit" value="Install Now" class="btn btn-primary" id="submit" />
            </form>
     
         <?php 
         } 
         else {
         ?>
            <p class="alert alert-danger">
               Please make the application/config/database.php file writable.<br>
               <strong>Example</strong>:<br />
               <code>chmod 777 application/config/database.php</code>
            </p>
         <?php 
         } 
         ?>
            
      </div>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>

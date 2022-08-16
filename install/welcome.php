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

if(isset($_GET['fname']))
{
    $ndex = strpos(baseUrl(),'install/welcome.php');
    $substrLink = substr(baseUrl(),0,$ndex);
    $loginLink = $substrLink.'index.php/login/asd123';
}
else
{
    $baseUrl = str_replace('install/welcome.php','login',baseUrl());
    header('Location: '.$baseUrl);
}


    
    
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Installed | Welcome to Arkonor LLC - CRM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <div class="col-sm-12 col-lg-12">
            <center>
                <br><br>
                <h1>Hi, <?php echo $_GET['fname']; ?>!</h1>
                <h1>Welcome to Arkonor LLC CRM</h1>

                <br>

                <p style="color:red;">IMPORTANT <br> Please copy the link bellow, paste it on a notepad and save. You will be using it for your next login.</p>

                <div class="alert alert-info" role="alert">
                  <?php echo $loginLink; ?>
                </div>

                <br>

                <p>I think all was setup successfully, you can sign in now!</p>

                <a href="<?php echo $loginLink; ?>" class="btn btn-primary">Sign In</a>

            </center>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
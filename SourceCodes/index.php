<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';

 // Never let you go to the login page if you're already logged in!
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: home.php");
  exit;
 }

 if( isset($_POST['btn-login']) ) {

  $email = $_POST['email'];
  $upass = $_POST['pass'];

  $email = strip_tags(trim($email));
  $upass = strip_tags(trim($upass));

  $password = hash('sha256', $upass); // password hashing using SHA256

  $res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");

  $row=mysql_fetch_array($res);

  $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row

  if( $count == 1 && $row['userPass']==$password ) {
   $_SESSION['user'] = $row['userId'];
   header("Location: home.php");
  } else {
   $errMSG = "The username/password is not recognized, Please try again!";
  }
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Prospekt | Member's Area | Login</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container">

 <div id="login-form">
    <form method="post" autocomplete="off">

     <div class="col-md-12">

         <div class="form-group">
             <h2 class="">Prospekt | Login</h2>
            </div>

         <div class="form-group">
             <hr />
            </div>

            <?php
   if ( isset($errMSG) ) {

    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="Your Email" required />
                </div>
            </div>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Your Password" required />
                </div>
            </div>

            <div class="form-group">
             <hr />
            </div>

            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
            </div>

            <div class="form-group">
             <hr />
            </div>

            <div class="form-group"><p> New Member?
             <a href="register.php">Sign Up Here!</a></p>
            </div>

        </div>

    </form>
    </div>

</div>

</body>
</html>

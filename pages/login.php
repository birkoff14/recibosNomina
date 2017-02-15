<?php require_once('../Connections/oConn.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['noempleado'])) {
  $loginUsername=$_POST['noempleado'];
  $password=sha1($_POST['password']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "principal.php?IDYear=";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_oConn, $oConn);
  
  $LoginRS__query=sprintf("SELECT NoEmpleado, Password FROM mtb_Usuarios WHERE NoEmpleado='%s' AND Password='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
      
  $LoginRS = mysql_query($LoginRS__query, $oConn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Recibos de nómina</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
			<br /><div align="center"><img src="../img/MAN_logo.png" width="266" height="146">		
		      </div>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Impresión de recibos de nómina </h3>
                    </div>
                    <div class="panel-body">
                        <form role="form1" name="form1" action="<?php echo $loginFormAction; ?>" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="No. de empleado" name="noempleado" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="password" type="password" value="">
                                </div>                                
                                <!-- Change this to a button or input when using this as a form -->                                
								<input name="btnIngreso" type="submit" class="btn btn-primary btn-lg btn-block" value="Ingresar">
                            </fieldset>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>

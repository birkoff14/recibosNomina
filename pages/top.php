<?php require_once('../Connections/oConn.php'); ?><?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
$colname_rsUsuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsUsuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_oConn, $oConn);
$query_rsUsuario = sprintf("SELECT * FROM mtb_Usuarios WHERE NoEmpleado = '%s'", $colname_rsUsuario);
$rsUsuario = mysql_query($query_rsUsuario, $oConn) or die(mysql_error());
$row_rsUsuario = mysql_fetch_assoc($rsUsuario);
$totalRows_rsUsuario = mysql_num_rows($rsUsuario);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charsAdministrativoset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>MTB Mexico | Recibos de n&oacute;mina</title>
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

<script language="javascript" type="text/javascript">

//Nombramos la funci&oacute;n
function valida_envia(){
alert("Se actualizaron los datos de usuario exitosamente");
//document.form1.submit();
}
    
</script>
<script language="javascript" type="text/javascript">
function EnviaForm(){
	//alert("Vas....");
	if (document.formVac.txtNoEmpleado.value.length==0){
	alert("El campo numero de empleado no puede estar vacio");
	document.formVac.txtNoEmpleado.focus();
	return 0;
	}
	
	if (document.formVac.txtFechaInicio.value.length==0){
	alert("El campo Fecha Inicio no puede estar vacio");
	document.formVac.txtFechaInicio.focus();
	return 0;
	}
	
	if (document.formVac.txtFechaFin.value.length==0){
	alert("El campo Fecha Fin no puede estar vacio");
	document.formVac.txtFechaFin.focus();
	return 0;
	}
	
	document.formVac.submit();
}
</script>
<script type="text/javascript">
     function anular(e) {
          tecla = (document.all) ? e.keyCode : e.which;
          return (tecla != 13);
     }
</script>
</head>
<body>
<div id="wrapper">
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="principal.php">Man Truck and BUS | Impresion de recibos</a>
  </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $logoutAction ?>"><i class="fa fa-sign-out fa-fw"></i>Salir</a>
						</li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <form name="form1" method="post" onKeyPress="return anular(event);" action="http://www.google.com">
							<div class="input-group custom-search-form">
							<!--input name="text" type="text" class="form-control" placeholder="Buscar empleado">
							<span class="input-group-btn" onClick="valida_envia();">
                                <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                            </button-->			
							<b><?php echo $row_rsUsuario['Nombre']; ?></b>
                              </span>
						  </form>
                      </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>						
					</ul>
  </div>
</div>
        </nav>
        <?php
mysql_free_result($rsUsuario);
?>

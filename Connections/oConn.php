<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_oConn = "192.168.2.90";
$database_oConn = "recibosNomina";
$username_oConn = "tickets";
$password_oConn = "2000";
$oConn = mysql_pconnect($hostname_oConn, $username_oConn, $password_oConn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
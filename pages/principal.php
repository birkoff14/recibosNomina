<?php
	require_once("top.php");
?>
<?php //require_once('../Connections/oConn.php'); ?>
<?php
mysql_select_db($database_oConn, $oConn);
$query_rsAnios = "SELECT distinct Anio FROM mtb_Recibos order by 1 asc";
$rsAnios = mysql_query($query_rsAnios, $oConn) or die(mysql_error());
$row_rsAnios = mysql_fetch_assoc($rsAnios);
$totalRows_rsAnios = mysql_num_rows($rsAnios);

$colname_rsRecibos = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsRecibos = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}


if($_GET['IDYear'] == ''){
	$qry = '2017';
}else{
	$qry = $_GET['IDYear'];
}

mysql_select_db($database_oConn, $oConn);
$query_rsRecibos = "SELECT DISTINCT Anio, Semana, NombreArchivo FROM mtb_Recibos WHERE REPLACE(NombreArchivo, '_', '|') like '%%|$colname_rsRecibos|%%' and NombreArchivo like '%.pdf' and Anio = $qry";
$rsRecibos = mysql_query($query_rsRecibos, $oConn) or die(mysql_error());
$row_rsRecibos = mysql_fetch_assoc($rsRecibos);
$totalRows_rsRecibos = mysql_num_rows($rsRecibos);
?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
              <div class="row">
                  <div class="col-lg-12">
                      <h1 class="page-header">Recibos de n&oacute;mina</h1>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><b>Periodos</b> <?php //echo $query_rsRecibos; ?></td>
                          </tr>
                          <tr>
                            <td>|
							<?php do { ?>
                            	<a href="principal.php?IDYear=<?php echo $row_rsAnios['Anio']; ?>"><?php echo $row_rsAnios['Anio']; ?></a> |
                            <?php } while ($row_rsAnios = mysql_fetch_assoc($rsAnios)); ?>
							</td>
                          </tr>
                        </table>
                        <p>&nbsp;</p>
						<?php do { ?>
						  <div class="col-lg-3 col-md-6">
						    <div class="panel panel-primary">
						      <div class="panel-heading">
						        <div class="row">
						          <div class="col-xs-3">
						            <i class="fa fa-file-o fa-5x"></i>
								  </div>
                                  <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $row_rsRecibos['Semana']; ?></div>
                                      <div>Semana <?php echo $row_rsRecibos['Semana']; ?></div>
                                  </div>
                              </div>
                          </div>
                          <a href="../Recibos/<?php echo $qry; ?>/<?php echo $row_rsRecibos['NombreArchivo']; ?>">
                            <div class="panel-footer">
                              <span class="pull-left">View Recibo </span>
                              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                              <div class="clearfix"></div>
                          </div>
                          </a>
						  	</div>
                    </div>
					<?php } while ($row_rsRecibos = mysql_fetch_assoc($rsRecibos)); ?>
			    </div>				    
                    <!-- /.col-lg-12 -->
              </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

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
<?php
mysql_free_result($rsAnios);

mysql_free_result($rsRecibos);
?>

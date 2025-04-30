<?php
	require_once("../../config/conexion.php");
	if(isset($_SESSION["usu_id"])){
		
?>

<!DOCTYPE html>
<html>
<?php require_once("../MainHead/head.php");?>
<title>Mantenimiento a categorias :. TLA SuTra</title>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

	<div class="mobile-menu-left-overlay"></div>
	
    <?php require_once("../MainNav/nav.php");?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Mantenimiento a categorias
							</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								
								<li class="active">
									Mantenimiento a categorias
								</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<table id="usuario_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<th style="width: 8%;">Nombre</th>
							<!-- <th style="width: 8%;">Area</th> -->
							<th class="d-none d-sm-table-cell" style="width: 5%;"></th>
							<th class="d-none d-sm-table-cell" style="width: 5%;"></th>
							
						</tr>
					</thead>
					<tbody>
						
						</tbody>
					</table>
					<button id="btnnuevo" type="button" class="btn btn-inline btn-primary">
						<i class="fa fa-user-plus" aria-hidden="true"></i>	
						Nuevo
					</button>
			</div>
		</div><!--.container-fluid-->
	</div><!--.page-content-->


	<?php require_once("modalmantenimiento.php");?>
	<?php require_once("../MainJs/js.php");?>
	<script type="text/javascript" src="mtncategoria.js"></script>
	

<script src="js/app.js"></script>
</body>
</html>
<?php
	}else{
		header("Location:"."http://localhost:80/HelpDesk_Tecno/"."index.php");
	}

?>
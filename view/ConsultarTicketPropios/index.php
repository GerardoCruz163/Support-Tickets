<?php
	require_once("../../config/conexion.php");
	if(isset($_SESSION["usu_id"])){
		
?>

<!DOCTYPE html>
<html>
<?php require_once("../MainHead/head.php");?>
<title>Consulta Tickets: TLA SuTra</title>
<audio id="notif_sound" src="../../public/sound/bell_not_sutra.wav" preload="auto"></audio>
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
							<h3>
								Consultar mis Tickets
							</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								
								<li class="active">
									Consultar mis Tickets
								</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">

				<div class="row" id="viewuser">
					<div class="col-lg-3">
						<fieldset class="form-group">
							<label class="form-label" for="tick_titulo">Titulo</label>
							<input type="text" class="form-control" id="tick_titulo" name="tick_titulo" placeholder="Titulo" required>
						</fieldset>
					</div>

					<div class="col-lg-3">
						<fieldset class="form-group">
							<label class="form-label" for="cat_id">Categoria</label>
							<select class="select2" id="cat_id" name="cat_id" data-placeholder="Seleccionar">
								<option label="Seleccionar">Seleccionar</option>
							</select>
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="prio_id">Prioridad</label>
							<select class="select2" id="prio_id" name="prio_id">
								
							</select>
						</fieldset>
					</div>
					<div class="col-lg-3">
						<fieldset class="form-group">
							<label class="form-label" for="usu_id">Usuario</label>
							<select class="select2" id="usu_id" name="usu_id">
								
								</select>
						</fieldset>
					</div>
				</div>
					
				
				
				

				<div class="box-typical box-typical-padding" id="table">
					<table id="ticket_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
							<th style="width: 2%;">#</th>
								<th class="d-none d-sm-table-cell" style="width: 26%;">Titulo</th>
								<th style="width: 10%;">Categoria</th>
								<th class="d-none d-sm-table-cell" style="width: 8%;">Prioridad</th>
								<th class="d-none d-sm-table-cell" style="width: 8%;">Creación</th>
								<th class="d-none d-sm-table-cell" style="width: 8%;">Solicitante</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Area</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Estado</th>
								<th class="d-none d-sm-table-cell" style="width: 5%;">Cierre</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Soporte</th>
								<th class="text-center" style="width: 5%;"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>

				</div>
			</div>
		</div><!--.container-fluid-->
	</div><!--.page-content-->

	<?php require_once("modalasignar.php");?>
	<?php require_once("../MainJS/js.php");?>
	<script type="text/javascript" src="consultarticketspropios.js"></script>
	<script type="text/javascript" src="../notificacion.js"></script>


</body>
</html>
<?php
	}else{
		header("Location:"."http://localhost:80/HelpDesk_Tecno/"."index.php");
		//header("Location:"."https://support-tracking.tecnologisticaaduanal.com/"."index.php");
	}

?>
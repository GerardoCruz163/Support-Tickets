<?php
	require_once("../../config/conexion.php");
	if(isset($_SESSION["usu_id"])){
		
?>

<!DOCTYPE html>
<html>
<?php require_once("../MainHead/head.php");?>
<title>Consulta tu ticket: SUTRA</title>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

	<div class="mobile-menu-left-overlay"></div>
	
    <?php require_once("../MainNav/nav.php");?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">
		<span id="realTicketId" data-id=""></span>

			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3 id="lblnomidticket">Detalle del ticket</h3>
							<div id="lblestado"></div>
							<div class="label label-pill label-primary" id="lblnomusuario"></div>
							<div class="label label-pill label-info" id="lblarea"></div>
							<span class="label label-pill label-default" id="lblfechcrea"></span>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<div class="row">
					<div class="col-lg-12">
						<fieldset class="form-gsroup">
							<label class="form-label semibold" for="cat_nom">Titulo</label>
							<input type="text" class="form-control" id="tick_titulo" name="tick_titulo" readonly>
						</fieldset>
					</div>
					<div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label semibold" for="cat_nom">Categoria</label>
							<input type="text" class="form-control" id="cat_nom" name="cat_nom" readonly>
						</fieldset>
					</div>

					<div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label semibold" for="cats_nom">Subcategoria</label>
							<input type="text" class="form-control" id="cats_nom" name="cats_nom" readonly>
						</fieldset>
					</div>

					<div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label semibold" for="prio_nom">Prioridad</label>
							<input type="text" class="form-control" id="prio_nom" name="prio_nom" readonly>
						</fieldset>
					</div>

					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label semibold" for="tick_titulo">Documentos adjuntos</label>
							<table id="documentos_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
								<thead>
									<tr>
										<th style="width: 90%;">Nombre</th>
										<th class="text-center" style="width: 10%;"></th>

									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</fieldset>
					</div>

					<!-- AQUI QUIERO AGREGAR LOS SEGUIDORES DEL TICKET -->
					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label semibold" for="tickd_descripusu">Seguidores</label>
							<div class="label label-pill label-default" id="lblnomusuarioseg"></div>
							
						</fieldset>
					</div>

					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label semibold" for="tickd_descripusu">Descripcion</label>
							<div class="summernote-theme-1">
								<textarea class="summernote" id="tickd_descripusu" name="tickd_descripusu"></textarea>
								<p></p>
							</div>
							
							
						</fieldset>
					</div>
				</div>
			</div>

        <section class="activity-line" id="lbldetalle">
		
			
			</section><!--.activity-line-->

			<span class="label label-pill label-default">
				<i class="font-icon font-icon-pencil-thin"></i>
				• • •
			</span>
			<div class="box-typical box-typical-padding" id="pnldetalle">
				<div class="row">
					<div class="col-lg-12">
						<fieldset class="form-group">
							<div class="summernote-theme-1">
								<textarea class="summernote" id="tickd_descrip" name="tick_descrip"></textarea>
							</div>
						</fieldset>
						
					</div>

					<div class="col-lg-12">
						<fieldset class="form-group">
								<label class="form-label semibold" for="fileElem">Adjuntar documento</label>
								<input type="file" name="fileElem" id="fileElem" class="form-control" multiple>
						</fieldset>
					</div>
					<div class="col-lg-12">
						<button id="btnUrgente" type="button" class="btn btn-rounded btn-inline btn-secondary">
							<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>	
							Marcar como Urgente
						</button>

						<button type="button" id="btnseguidores" name="action" value="add" class="btn btn-rounded btn-inline btn-secondary">
							<i class="fa fa-users" aria-hidden="true"></i>
							Añadir Seguidor/es
						</button>

						<button type="button" id="btnenviar" name="action" value="add" class="btn btn-rounded btn-inline btn_primary">
						<i class="fa fa-paper-plane" aria-hidden="true"></i>	
						Enviar</button>

						<button type="button" id="btncerrar" name="action" value="add" class="btn btn-rounded btn-inline btn-default">
						<i class="fa fa-times-circle" aria-hidden="true"></i>	
						Cerrar Ticket</button>
					</div>
					
				</div><!--.row-->
			</div>
		</div><!--.container-fluid-->
	</div><!--.page-content-->

	<?php require_once("../MainJS/js.php");?>
	<?php require_once("modalseguidorticket.php");?>
	<script src="http://cdn.socket.io/4.7.2/socket.io.min.js"></script>
	<script type="text/javascript" src="detalleticket.js"></script>
	<script type="text/javascript" src="../notificacion.js"></script>

	
	<!-- <script src="js/app.js"></script> -->
</body>
</html>
<?php
	}else{
		header("Location:"."http://localhost:80/HelpDesk_Tecno/"."index.php");
		//header("Location:"."https://support-tracking.tecnologisticaaduanal.com/"."index.php");
	}

?>
<?php
	require_once("../../config/conexion.php");
	if(isset($_SESSION["usu_id"])){

?>

<!DOCTYPE html>
<html>
<?php require_once("../MainHead/head.php");?>
<title>Nuevo ticket: SUTRA</title>
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
							<h3>Nuevo ticket</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								
								<li class="active">Nuevo ticket</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<p>
					¿Necesitas ayuda? Puedes crear nuevas solicitudes aquí:
				</p>

				<h5 class="m-t-lg with-border">Ingresa detalles</h5>

				<div class="row">
					<form method="post" id="ticket_form">

						<input type="hidden" name="usu_id" id="usu_id" value="<?php echo $_SESSION["usu_id"] ?>">

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="exampleInput">Categoría</label>
								<select id="cat_id" name="cat_id" class="form-control">
	
								</select>
							
							</fieldset>
						</div>
						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="tick_titulo">Título</label>
								<input type="text" class="form-control" id="tick_titulo" name="tick_titulo" placeholder="Ingrese el título">
							</fieldset>
						</div>
						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="tick_descrip">Descripción</label>
								<div class="summernote-theme-1">
									<textarea class="summernote" id="tick_descrip" name="tick_descrip"></textarea>
								</div>
							</fieldset>
						</div>
						<div class="col-lg-12">
							<button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn_primary">
							<i class="fa fa-paper-plane" aria-hidden="true"></i>	
							Guardar y enviar</button>
						</div>
					</form>
				</div><!--.row-->
			</div>
		</div><!--.container-fluid-->
	</div><!--.page-content-->

	<?php require_once("../MainJs/js.php");?>
	<script type="text/javascript" src="nuevoticket.js"></script>
	

<script src="js/app.js"></script>
</body>
</html>
<?php
	}else{
		header("Location:"."http://localhost:80/HelpDesk_Tecno/"."index.php");
	}

?>
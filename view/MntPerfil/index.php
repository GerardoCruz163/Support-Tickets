<?php
	require_once("../../config/conexion.php");
	if(isset($_SESSION["usu_id"])){

?>

<!DOCTYPE html>
<html>
<?php require_once("../MainHead/head.php");?>
<title>Perfil: <?php echo $_SESSION["usu_nom"] ?> <?php echo $_SESSION["usu_ape"] ?></title>
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
							<h3>Perfil: <?php echo $_SESSION["usu_nom"] ?> <?php echo $_SESSION["usu_ape"] ?></h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								
								<li class="active">Cambiar contraseña</li>
								
							</ol>
							
						</div>
						
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				

				<h5 class="m-t-lg with-border">Cambiar tu contraseña</h5>
                <p>Es importante que tu contraseña no sea facil de descifrar, anotala y guardala en un lugar seguro.</p>

				<div class="row">
					<div class="col-lg-6">
						<fieldset class="form-group">
							<label class="form-label semibold" for="exampleInput">Nueva contraseña</label>
							<input type="password" class="form-control" id="txtpass" name="txtpass" placeholder="Nueva contraseña">
						</fieldset>
					</div>

					<div class="col-lg-6">
						<fieldset class="form-group">
							<label class="form-label semibold" for="exampleInput">Confirmar contraseña</label>
							<input type="password" class="form-control" id="txtpassnew" name="txtpassnew" placeholder="Nueva contraseña">
						</fieldset>
					</div>
					
					
					<div class="col-lg-12">
						<button type="button" id="btnactualizar" name="action" class="btn btn-rounded btn-inline btn_primary">
						<i class="fa fa-floppy-o" aria-hidden="true"></i>	
						Guardar cambios</button>
					</div>
					
				</div><!--.row-->
			</div>
		</div><!--.container-fluid-->
	</div><!--.page-content-->

	<?php require_once("../MainJS/js.php");?>
	<script type="text/javascript" src="mntperfil.js"></script>
	<script type="text/javascript" src="../notificacion.js"></script>

<script src="js/app.js"></script>
</body>
</html>
<?php
	}else{
		header("Location:"."http://localhost:80/HelpDesk_Tecno/"."index.php");
	}

?>
<?php
	require_once("../../config/conexion.php");
	require_once ('../../vendor/autoload.php');

	use Dotenv\Dotenv;
	if(isset($_SESSION["usu_id"])){
		
?>

<!DOCTYPE html>
<html>
<?php require_once("../MainHead/head.php");?>
<title>Consulta Tickets: TLA SuTra</title>
<audio id="notif_sound" src="../../public/sound/bell_not_sutra.wav" preload="auto"></audio>
<link rel="shortcut icon" href="../../public/img/SuTra_icon.png" type="image/x-icon">
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
								Consultar Tickets
							</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								
								<li class="active">
									Consultar Tickets
								</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<section class="tabs-section">
				<div class="tabs-section-nav tabs-section-nav-icons">
					<div class="tbl">
						<ul class="nav" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pestPendientes" role="tab" data-toggle="tab" aria-expanded="true">
									<span class="nav-link-in">
                                    <i class="fa fa-file-text" aria-hidden="true"></i>
										Pendientes
									</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pestCerrados" role="tab" data-toggle="tab" aria-expanded="false">
									<span class="nav-link-in">
                                    <i class="fa fa-recycle" aria-hidden="true"></i>
										Tickets Cerrados
									</span>
								</a>
							</li>
						</ul>
					</div>
				</div><!--.tabs-section-nav-->

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
								<!-- <option label="Seleccionar">Seleccionar</option> -->
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
					
				<?php
					if($_SESSION['rol_id']==1 || $_SESSION['rol_id']==2){
						echo '';
					}else{
						echo '
						<div class="row" id="viewuser">
							<div class="col-lg-2">
								<fieldset class="form-group">
									<label class="form-label" for="btnfiltrar">&nbsp;</label>
									<button type="submit" class="btn btn-rounded btn-primary btn-block" id="btnfiltrar" required>
										Filtrar	
									</button>
								</fieldset>
							</div>
		
							<div class="col-lg-2">
								<fieldset class="form-group">
									<label class="form-label" for="btntodo">&nbsp;</label>
									<button class="btn btn-rounded btn-primary btn-block" id="btntodo" required>Ver todo</button>
								</fieldset>
							</div>
	
						</div>';
					}
				?>
				
				

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
			</section>
			

			
		</div><!--.container-fluid-->
	</div><!--.page-content-->

	<script>
    	const URL_DOMAIN = "<?= $_ENV['URL_DOMAIN'] ?>";
	</script>
	<?php require_once("modalasignar.php");?>
	<?php require_once("../MainJS/js.php");?>
	<script type="text/javascript" src="consultarticket.js"></script>
	<script type="text/javascript" src="../notificacion.js"></script>


</body>
</html>
<?php
	}else{
	// Cargar el archivo .env
	$URL_DOMAIN = $_ENV['URL_DOMAIN'];
		header("Location:"."$URL_DOMAIN"."/index.php"); 
	}

?>
<?php
	require_once("../../config/conexion.php");
	if(isset($_SESSION["usu_id"])){

?>

<!DOCTYPE html>
<html>
	<?php require_once("../MainHead/head.php");?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<title>Home: SUTRA</title>
</head>
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
							<h3>Panel de inicio</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								
								<li class="active">
								</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="row">
				<div class="col-xl-12">
					<div class="row">
						<div class="col-sm-4">
							<article class="statistic-box green">
								<div>
									<div class="number" id="lbltotal"></div>
									<div class="caption"><div>Tickets en total</div></div>
								</div>
							</article>
						</div>

						<div class="col-sm-4">
							<article class="statistic-box yellow">
								<div>
									<div class="number" id="lbltotalabiertos"></div>
									<div class="caption"><div>Tickets Abiertos</div></div>
								</div>
							</article>
						</div>

						<div class="col-sm-4">
							<article class="statistic-box red">
								<div>
									<div class="number" id="lbltotalcerrados"></div>
									<div class="caption"><div>Tickets Cerrados</div></div>
								</div>
							</article>
						</div>
					</div>
				</div>

			</div>
			
			<section class="card">
				<header class="card-header">
					Estadísticas
				</header>
				<div class="card-block">
					<div id="line-chart"></div>
					<div id="divgrafico" style="height: 250px;"></div>
				</div>
			</section>
		</div><!--.container-fluid-->
	</div><!--.page-content-->

	<?php require_once("../MainJS/js.php");?>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	
	<script type="text/javascript" src="home.js"></script>
	<script type="text/javascript" src="../notificacion.js"></script>
	
</body>
</html>
<?php
	}else{
		header("Location:"."http://localhost:80/HelpDesk_Tecno/"."index.php");
	}

?>
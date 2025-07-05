<?php
    require_once("../../config/conexion.php");
	if(isset($_SESSION["usu_id"])){
?>

<!DOCTYPE html>
<html>
<?php require_once("../MainHead/head.php");?>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>StartUI - Premium Bootstrap 4 Admin Dashboard Template</title>

	<link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="img/favicon.png" rel="icon" type="image/png">
	<link href="img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

<body>

<?php require_once("../MainHeader/header.php");?>

	<div class="mobile-menu-left-overlay"></div>
	
    <?php require_once("../MainNav/nav.php");?>x
<div class="page-content">
		<div class="container-fluid">
			<div class="box-typical box-typical-full-height">
				<div class="add-customers-screen tbl">
					<div class="add-customers-screen-in">
						<div class="add-customers-screen-user">
							<i class="font-icon font-icon-user"></i>
						</div>
						<h2>Your customers list</h2>
						<p class="lead color-blue-grey-lighter">Create items with names, contact information<br/> and locations to speed-up dispatching.</p>
						<a href="#" class="btn">Add customer</a>
					</div>
				</div>
			</div><!--.box-typical-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->



	<script src="js/lib/jquery/jquery.min.js"></script>
	<script src="js/lib/tether/tether.min.js"></script>
	<script src="js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>

	<script src="js/app.js"></script>
<?php
	}else{
		header("Location:"."http://localhost:80/HelpDesk_Tecno/"."index.php");
	}

?>
<?php
	require_once("../../config/conexion.php");
	if(isset($_SESSION["usu_id"])){
		
?>

<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>TLA SuTra: No se encontró la pagina (404)</title>

	<link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="img/favicon.png" rel="icon" type="image/png">
	<link href="img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	
	<link rel="stylesheet" href="../../public/css/separate/pages/error.min.css">
    <link rel="stylesheet" href="../../public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="../../public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/main.css">

	<?php require_once("../MainJS/js.php");?>
</head>
<body>

	<div class="page-error-box">
			
		<div class="error-code">
			<i class="fa fa-meh-o" aria-hidden="true"></i>	
		</div>
		
		<div class="error-title">No se encontró esta pagina.</div>
		<div class="error-title">Error: 404</div>
		<a href="http://localhost:80/HelpDesk_Tecno/view/Home/" class="btn btn-rounded">Volver</a>
		<!-- <a href="https://support-tracking.tecnologisticaaduanal.com/view/Home/" class="btn btn-rounded">Volver</a> -->
	</div>

</body>
<?php
	}else{
		header("Location:"."http://localhost:80/HelpDesk_Tecno/"."index.php");
		//header("Location:"."https://support-tracking.tecnologisticaaduanal.com/"."index.php");
	}

?>
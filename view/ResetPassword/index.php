<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Recuperar contraseña: SuTra</title>
    <audio id="notif_sound" src="../../public/sound/bell_not_sutra.wav" preload="auto"></audio>

	<link href="../../public/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="../../public/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="../../public/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="../../public/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="../../public/img/favicon.png" rel="icon" type="image/png">
	<link href="../../public/img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
<link rel="stylesheet" href="../../public/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="../../public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="../../public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/main.css">
</head>
<body>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form class="sign-box reset-password-box">
                    <!--<div class="sign-avatar">
                        <img src="img/avatar-sign.png" alt="">
                    </div>-->
                    <header class="sign-title">Recuperar contraseña</header>
                    <p>Introduce tu correo electrónico</p>
                    <div class="form-group">
                        <input type="text" id="usu_correo" name="usu_correo" class="form-control" placeholder="example@tecnologisticaaduanal.com"/>
                    </div>
                    <button type="button" id="btnenviar" class="btn btn-rounded">Enviar</button>
                    o <a href="../../index.php">Regresar</a>
                </form>
            </div>
        </div>
    </div><!--.page-center-->

<script src="../../public/js/lib/jquery/jquery.min.js"></script>
<script src="../../public/js/lib/tether/tether.min.js"></script>
<script src="../../public/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="../../public/js/plugins.js"></script>
<script src="../../public/js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>

<link rel="stylesheet" href="../../public/css/lib/bootstrap-sweetalert/sweetalert.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/sweet-alert-animations.min.css">
    <script type="text/javascript" src="../../public/js/lib/match-height/jquery.matchHeight.min.js"></script>
    <script>
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function(){
                setTimeout(function(){
                    $('.page-center').matchHeight({ remove: true });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                },100);
            });
        });
    </script>
<script src="../../public/js/app.js"></script>
<script type="text/javascript" src="resetpassword.js"></script>
</body>
</html>

<header class="site-header">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
    <div class="container-fluid">

        <a href="#" class="site-logo">
            <img class="hidden-md-down" src="../../public/img/SUTRAT.png" alt="">
            <img class="hidden-lg-up" src="../../public/img/SUTRA REDT.png" alt="">
        </a>

        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
            <span>toggle menu</span>
        </button>

        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>
        
        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">

                    <div class="dropdown dropdown-notification notif">
                        <a href="../MtnNotificacion/index.php" class="header-alarm">
                            <i class="font-icon-alarm"></i>
                        </a>
                    </div>
                    <div class="dropdown user-menu">   
                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="../../public/img/<?php echo $_SESSION["rol_id"]?>.png" alt="">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                            <a class="dropdown-item" href="../MntPerfil/"><i class="fa fa-user" aria-hidden="true"></i>    Perfil</a>
                            <a class="dropdown-item" href="#"><i class="fa fa-question-circle" aria-hidden="true"></i> Ayuda</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../Logout/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar Sesion</a>
                        </div>
                    </div>
                </div>

                <div class="mobile-menu-right-overlay"></div>

                <input type="hidden" id="user_idx" value="<?php echo $_SESSION["usu_id"] ?>"><!-- ID del Usuario-->
                <input type="hidden" id="rol_idx" value="<?php echo $_SESSION["rol_id"] ?>"><!-- rol del Usuario-->

                <div class="dropdown dropdown-typical">
                    <a href="#" class="dropdown-toggle no-arr">
                        <!-- <span class="font-icon font-icon-user"></span> -->
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="lblcontactonomx"><?php echo $_SESSION["usu_nom"] ?> <?php echo $_SESSION["usu_ape"];
                        if($_SESSION["rol_id"]==2){
                            echo ' (Cuenta de Soporte)';
                        }

                        ?></span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</header>
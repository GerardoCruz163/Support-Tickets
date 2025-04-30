<?php
    if($_SESSION["rol_id"] == 1){ /**SI EL ROL ES USUARIO */
        ?>
            <nav class="side-menu ">
                
                <ul class="side-menu-list">
                    <li class="blue-dirty">
                        <a href="..\Home\">
                            <span>

                            <i class="fa fa-home" aria-hidden="true"></i>
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="20" height="20" stroke-width="2"> <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path> <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path> <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path> </svg>  -->
                            
                            </span>
                            <span class="lbl">Inicio</span>
                        </a>
                    </li>

                    <li class="aquamarine">
                        <a href="..\NuevoTicket\">
                            <span>
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </span>
                            <span class="lbl">Nuevo Ticket</span>
                        </a>
                    </li>

                    <li class="gold">
                        <a href="..\ConsultarTicket\">
                            <span>
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </span>
                            <span class="lbl">
                                <?php
									if($_SESSION['rol_id']==1){
										echo 'Consultar mis Tickets';
									}else{
										echo 'Consultar tickets';
									}
								?>
                            </span>
                        </a>
                    </li>

                    <?php
                        if($_SESSION['rol_id']==1){
                            echo '
                                <li class="aquamarine">
                                    <a href="..\NuevoTicket\">
                                        <span>
                                        <i class="fa fa-ticket" aria-hidden="true"></i>
                                        </span>
                                        <span class="lbl">Tickets Asignados</span>
                                    </a>
                                </li>
                            ';
                        }else{
                            echo '';
                        }
					?>

                </ul>
            
            </nav><!--.side-menu-->
        <?php
    }else{/* SI EL ROL ES SOPORTE */
        ?>
            <nav class="side-menu">
                <ul class="side-menu-list">
                    <li class="blue-dirty">
                        <a href="..\Home\">
                            <span>

                            <i class="fa fa-home" aria-hidden="true"></i>
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="20" height="20" stroke-width="2"> <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path> <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path> <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path> </svg>  -->
                            
                            </span>
                            <span class="lbl">Inicio</span>
                        </a>
                    </li>

                    
                    <li class="gold">
                        <a href="..\ConsultarTicket\">
                            <span>
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </span>
                            <span class="lbl">Consultar Ticket</span>
                        </a>
                    </li>
                    <li class="aquamarine">
                        <a href="..\MtnUsuario\">
                            <span>
                            <i class="fa fa-users" aria-hidden="true"></i>
                            </span>
                            <span class="lbl">Mantenimiento a usuarios</span>
                        </a>
                    </li>

                    <li class="blue-darker">
                        <a href="..\MtnCategoria\">
                            <span>
                            <i class="fa fa-tag" aria-hidden="true"></i>
                            </span>
                            <span class="lbl">Mantenimiento a categorias</span>
                        </a>
                    </li>

                    <li class="blue-sky">
                        <a href="..\MtnSubategoria\">
                            <span>
                            <i class="fa fa-tags" aria-hidden="true"></i>
                            </span>
                            <span class="lbl">Mantenimiento a subcategorias</span>
                        </a>
                    </li>

                    <li class="red">
                        <a href="..\MtnPrioridad\">
                            <span>
                            <i class="fa fa-tachometer" aria-hidden="true"></i>
                            </span>
                            <span class="lbl">Mantenimiento a prioridades</span>
                        </a>
                    </li>
                </ul>
            </nav><!--.side-menu-->
        <?php
    }
?>

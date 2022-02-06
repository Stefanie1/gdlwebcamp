<section class="seccion contenedor ">
        <?php
        try {
            require_once('includes/funciones/db_conexion.php') ;//crea la conexion ***no olvidar espacio al final
            $sql =" SELECT * FROM `invitados` " ; //escribir la consulta
            $resultado = $conn->query($sql); //variable que realiza la consulta la base de datos
        } catch (\Exception $e) {
           echo $e->getMessage();
        }?>

        <section class="invitados contenedor seccion">
                    <div id="mapa" class="mapa" style="display: none !important;"> </div>
                        <h2>Nuestros Invitados</h2>
                        <ul class="lista-invitados clearfix">
                                <?php while($invitados=$resultado->fetch_assoc() ){ ?>
                                    <li>
                                        <div class="invitado">
                                            <a class="invitado-info" href="#invitado<?php echo $invitados['invitado_id'];?>">
                                                <img src="img/<?php echo $invitados['url_imagen'] ?>" alt="imagen invitado">
                                                <p><?php echo $invitados['nombre_invitado'] . " " . $invitados['apellido_invitado'] ?></p>
                                            </a>
                                        </div>
                                    </li>
                                    <div style="display:none;">
                                        <div class="invitado-info" id="invitado<?php echo $invitados['invitado_id'];?>">
                                            <h2><?php echo $invitados['nombre_invitado'] . " " . $invitados['apellido'];?></h2>
                                            <img src="img/<?php echo $invitados['url_imagen'] ?>" alt="">
                                                <p> <?php echo $invitados['descripcion']?></p>
                                        </div>
                                </div>
                                <?php } ?>
                        </ul>
                </section>
              
                    
        <?php //cierra la conexion
        $conn->close();
        ?>


</section>

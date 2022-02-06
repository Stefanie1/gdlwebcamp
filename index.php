<?php include_once 'includes/templates/header.php';?>

    <section class="seccion contenedor">
        <h2>La mejor Conferencia de diseño web en Español</h2>
        <p>Donec non elit porta orci volutpat ornare. Nulla scelerisque non metus in euismod. Nam sed ex mauris. Vestibulum in mauris ultrices, venenatis odio id, lobortis purus. Fusce et lacinia magna, a elementum eros. Pellentesque id erat neque. Quisque
            pellentesque metus eget felis posuere, leo odio aliquet tortor, posuere varius est orci sed purus.</p>
    </section>

    <section class="programa">
        <div class="contenerdor-video">
            <video playsiline autoplay muted loop poster="img/bg-talleres.jpg">
              <source src="video/video.mp4" type="video/mp4">
              <source src="video/video.webm" type="video/webm">
              <source src="video/video.ogv" type="video/ogv">
            </video>
        </div>
        <!--contenedor video-->
        <div class="contenido-programa">
            <div class="contenedor">
                <div class="programa-evento"> 
                    <h2>Porograma del evento</h2>

                        <?php
                            try {
                                require_once('includes/funciones/db_conexion.php') ;
                                $sql = "SELECT * FROM `categoria_evento` "; 
                                $resultado = $conn->query($sql); 
                            } catch (\Exception $e) {
                            echo $e->getMessage();
                            }
                        ?>
                    <nav class="menu-programa">
                        <?php while($cat = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>
                            <?php $categoria = $cat['cat_evento']; ?>
                            <a href="#<?php echo strtolower($categoria) ?>">
                                <i class="fa <?php echo $cat['icono'] ?>" aria-hidden="true"></i><?php echo $categoria?></a>
                        <?php } ?>
                    </nav>

                        <?php
                            try {
                                require_once('includes/funciones/db_conexion.php');//crea la conexion ***no olvidar espacio al final
                                $sql = " SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado "; //escribir la consulta
                                $sql .= " FROM eventos ";
                                $sql .= "INNER JOIN categoria_evento ";//la tabla con la que unes 
                                $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";//cueal es  id de cada  tabla
                                $sql .= "INNER JOIN invitados ";
                                $sql .= " ON eventos.id_inv = invitados.invitado_id ";
                                $sql .= " AND eventos.id_cat_evento = 1 ";
                                $sql .= "ORDER BY evento_id LIMIT 2; ";
                                //SEGUHNDO
                                $sql .= " SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado "; //escribir la consulta
                                $sql .= " FROM eventos ";
                                $sql .= "INNER JOIN categoria_evento ";//la tabla con la que unes 
                                $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";//cueal es  id de cada  tabla
                                $sql .= "INNER JOIN invitados ";
                                $sql .= " ON eventos.id_inv = invitados.invitado_id ";
                                $sql .= " AND eventos.id_cat_evento = 2 ";
                                $sql .= "ORDER BY evento_id LIMIT 2; ";
                                //TERCERO
                                $sql .= " SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado "; //escribir la consulta
                                $sql .= " FROM eventos ";
                                $sql .= "INNER JOIN categoria_evento ";//la tabla con la que unes 
                                $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";//cueal es  id de cada  tabla
                                $sql .= "INNER JOIN invitados ";
                                $sql .= " ON eventos.id_inv = invitados.invitado_id ";
                                $sql .= " AND eventos.id_cat_evento = 3 ";
                                $sql .= "ORDER BY evento_id LIMIT 2; ";
                            } catch (\Exception $e) {
                            echo $e->getMessage();
                            }
                        ?>
                        <?php $conn->multi_query($sql);//connn referencia a la conexion?>
                       
                       <?php
                          do {
                            $resultado =$conn->store_result();
                            $row = $resultado->fetch_all(MYSQLI_ASSOC); //arreglo?>

                                <?php $i=0;?>
                                <?php foreach($row as $evento): ?>
                                <?php if ($i % 2 == 0){//solo se ejecuta en los pares?>
                                    <div id="<?php echo strtolower($evento['cat_evento']) ?>" class="info-curso ocultar clearfix">
                                <?php } ?>
                                        <div class="detalle-evento">
                                            <h3><?php echo $evento['nombre_evento']//utf8_encode(?></h3>
                                            <p><i class="far fa-clock" aria-hidden="true"></i><?php echo $evento['hora_evento']; ?></p>
                                            <p><i class="fas fa-calendar-alt" aria-hidden="true"></i><?php echo $evento['fecha_evento']; ?></p>
                                            <p><i class="fas fa-user" aria-hidden="true" ></i><?php echo $evento['nombre_invitado'] . " " . $evento['apellido_invitado']; ?></p>
                                        </div>
                                       
                                        <?php if($i % 2 == 1 ):?>
                                            <a href="calendario.php" class="button float-right">Ver Todos</a>
                                        </div> <!--#talleres-->
                                        <?php endif; ?>

                                <?php $i++;?>
                                <?php endforeach; ?>
                                <?php $resultado->free();//libera la consulta ?>
                                <?php  } while ($conn->more_results() && $conn->next_result());//mientras la connecion tenga smas resultados y sean los siguientes
                                ?>

                </div>
                <!--programaevento-->
            </div>
            <!--contenedor-->
        </div>
        <!--contenido del programa -->

            <!--invitados-->
    </section>
    <div id="mapa" class="mapa" ></div> <!--termina contenedor-->

    <?php include_once 'includes/templates/invitados.php';?>
    <!--programa-->

    <div class="contador parallax">
        <div class="contenedor">
            <ul class="resumen-evento clearfix">
                <li>
                    <p class="numero"></p>Invitados</li>
                <!--aqui estabn numeros-->
                <li>
                    <p class="numero"></p>Talleres</li>
                <li>
                    <p class="numero"></p>Dias</li>
                <li>
                    <p class="numero"></p>Conferencias</li>

            </ul>
        </div>
    </div>
    <!--contador-->

    <section class="precios seccion">
        <h2>Precios</h2>
        <div class="contenedor">
            <ul class="lista-precios clearfix">
                <li>
                    <div class="tabla-precio">
                        <h3>Pase por día</h3>
                        <p class="numero">$30</p>
                        <ul>
                            <li>Bocadillos Gratis</li>
                            <li>Todas las Conferencias</li>
                            <li>Todos los talleres</li>
                        </ul>
                        <a href="#" class="button hollow">Comprar</a>
                    </div>
                </li>
                <li>
                    <div class="tabla-precio">
                        <h3>Todos los dias</h3>
                        <p class="numero">$50</p>
                        <ul>
                            <li>Bocadillos Gratis</li>
                            <li>Todas las Conferencias</li>
                            <li>Todos los talleres</li>
                        </ul>
                        <a href="#" class="button ">Comprar</a>
                    </div>
                </li>
                <li>
                    <div class="tabla-precio">
                        <h3>Pase por 2 días</h3>
                        <p class="numero">$45</p>
                        <ul>
                            <li>Bocadillos Gratis</li>
                            <li>Todas las Conferencias</li>
                            <li>Todos los talleres</li>
                        </ul>
                        <a href="#" class="button hollow">Comprar</a>
                    </div>
                </li>
            </ul>
         
        </div>

    </section>
    <!--precios seccion-->

     <!--termina contenedor........-->

      
    <!--mapa-->

    <section class="seccion">
   
        <h2>Testimoniales</h2>
        <div class="testimoniales contenedor clearfix">
            <div class="testimonial">
                <blockquote>
                    <p>In ut leo suscipit, vulputate elit sit amet, ultricies massa. Sed in tincidunt erat, a luctus purus. Cras tincidunt nisl leo, dictum condimentum nunc dapibus nec. Vestibulum ac libero lacus. </p>
                    <footer class="info-testimonial clearfix">
                        <img src="img/testimonial.jpg" alt="imagen testimonial">
                        <cite>Oswaldo Aponte Escobedo <span>Diseñador de @prisma</span></cite>
                    </footer>
                </blockquote>
            </div>
            <!--testimonial-->
            <div class="testimonial">
                <blockquote>
                    <p>In ut leo suscipit, vulputate elit sit amet, ultricies massa. Sed in tincidunt erat, a luctus purus. Cras tincidunt nisl leo, dictum condimentum nunc dapibus nec. Vestibulum ac libero lacus. </p>
                    <footer class="info-testimonial clearfix">
                        <img src="img/testimonial.jpg" alt="imagen testimonial">
                        <cite>Oswaldo Aponte Escobedo <span>Diseñador de @prisma</span></cite>
                    </footer>
                </blockquote>
            </div>
            <!--testimonial-->
            <div class="testimonial">
                <blockquote>
                    <p>In ut leo suscipit, vulputate elit sit amet, ultricies massa. Sed in tincidunt erat, a luctus purus. Cras tincidunt nisl leo, dictum condimentum nunc dapibus nec. Vestibulum ac libero lacus. </p>
                    <footer class="info-testimonial clearfix">
                        <img src="img/testimonial.jpg" alt="imagen testimonial">
                        <cite>Oswaldo Aponte Escobedo <span>Diseñador de @prisma</span></cite>
                    </footer>
                </blockquote>
            </div>
            <!--testimonial-->
        </div>
    </section>
    <!--testimoniales-->

    <div class="newsletter parallax">
        <div class="contenido contenedor">
            <p> Registrate al newslatter:</p>
            <h3>gdlwebcamp</h3>
            <a href="#" class="button transparent">Registro</a>
        </div>
        <!--contenido-->
    </div>
    <!--newslater-->

    <section class="seccion">
        <h2>Faltan</h2>
        <div class="cuenta-regresiva contenedor">
            <ul class="clearfix">
                <li>
                    <p id="dias" class="numero"></p>dias </li>
                <li>
                    <p id="horas" class="numero"></p>horas </li>
                <li>
                    <p id="minutos" class="numero"></p>minmutos</li>
                <li>
                    <p id="segundos" class="numero"></p>segundos</li>
            </ul>
        </div>
        <!--fincuentaregresiva-->
    </section>
    <!--finseccion-->


<?php include_once 'includes/templates/footer.php';?>

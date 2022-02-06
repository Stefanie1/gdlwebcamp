<?php include_once 'includes/templates/header.php';?>

 

<section class="seccion contenedor  ">
        <h2>Calendario de Eventos </h2>

        <?php
        try {
            require_once('includes/funciones/db_conexion.php');//crea la conexion ***no olvidar espacio al final
            $sql = " SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado "; //escribir la consulta
            $sql .= " FROM eventos ";
            $sql .= "INNER JOIN categoria_evento ";//la tabla con la que unes 
            $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";//cueal es  id de cada  tabla
            $sql .= "INNER JOIN invitados ";
            $sql .= " ON eventos.id_inv = invitados.invitado_id ";
            $sql .= "ORDER BY evento_id ";
            $resultado = $conn->query($sql); //variable que realiza la consulta la base de datos
        } catch (\Exception $e) {
           echo $e->getMessage();
        }
        ?>

        <div class="calendario">

            <?php
            // echo $sql;
                $calendario = array ();//fuera para que empiece vacio
                while( $eventos = $resultado->fetch_assoc()){ //funcion qu eimprime los resultados como arreglo
                        
                    //obtine la fecha del evento 
                        $fecha = $eventos['fecha_evento'];
                        $categoria = $eventos['cat_evento']; //llave para agrupar
                    
                        $evento = array(
                        'titulo' => $eventos['nombre_evento'],
                        'fecha' => $eventos['fecha_evento'],
                        'hora' => $eventos['hora_evento'],
                        'categoria' => $eventos['cat_evento'],  
                        'icono' => 'fa' . ' ' . $eventos['icono'],  
                        'invitado' => $eventos['nombre_invitado'] . ' ' .  $eventos['apellido_invitado']  
                    );
                    $calendario[$fecha][] = $evento;//agrupa los eventos de la misma llave
                ?>
            <?php } //while de fetch_assoc?>

            <?php //imprime  todos los eventos 
                foreach($calendario as $dia => $lista_eventos){ //var que quiero recorrerque es la llave?>
                <div class= 'espacio_dia '>
                    <h3>
                        <i class="fa fa-calendar-alt"></i>
                        <?php
                        setlocale(LC_TIME,'es_ES.UTF-8');//CAMBIARLO A ESPANOL
                        //echo  date("F j, Y",strtotime($dia) );//fromato e la fecha puede ser date()
                        echo  strftime("%A, %d de %B del %Y",strtotime($dia) );//fromato e la fecha 
                        ?>
                    </h3>
                </div>


              
                    <?php foreach($lista_eventos as $evento) {?>
                    
                            <div class= "dia ">
                                <p class="titulo">  <?php echo $evento['titulo']; ?> </p>
                                <p class="hora">
                                    <i class="fa fa-clock-o" aria-hidde="true"></i> 
                                    <?php echo $evento['fecha'] . " " . $evento['hora']; ?> 
                                </p>
                                <p> 
                                    <i class="<?php echo $evento['icono'];?> " aria-hidde="true"></i>
                                    <?php echo $evento['categoria']; ?>
                                </p>
                                <p>
                                    <i class="fa fa-user" aria-hidde="true"></i> 
                                    <?php echo $evento['invitado']; ?> 
                                </p>
                            </div>
                    <?php } //fin forecha que imprime los eventos?>
            
            <?php }//fin forecha que imprime los dias?>
            
            </div>  <!-- termina calendafrio-->

            <?php //cierra la conexion
            $conn->close();
            ?>


        </section>
        
        <footer class="site-footer">
  
  <div class="contenedor clearfix">
      
  <p class="copyright ">
      Todos los derechos Reservados GDLWEBCAMP 2020.
  </p>
</footer>
<script src="js/jquery.js"></script>
<script src="js/vendor/modernizr-3.11.2.min.js"></script>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
<script src="js/plugins.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/jquery.lettering.js"></script> 
<script src="js/jquery.colorbox-min.js"></script>
<script src="js/lightbox.js"></script>

<?php 
  $archivo = basename($_SERVER['PHP_SELF']);
  $pagina = str_replace(".php","",$archivo);
  if ($pagina == 'invitados' || $pagina == 'index') {
  echo ' <script src="js/jquery.colorbox-min.js"></script>';
  } else if ($pagina == 'conferencia'){
      echo '<script src="js/lightbox.js"></script>';
  }
  ?>
<script src="js/main.js"></script>


<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
  window.ga = function() {
      ga.q.push(arguments)
  };
  ga.q = [];
  ga.l = +new Date;
  ga('create', 'UA-XXXXX-Y', 'auto');
  ga('set', 'anonymizeIp', true);
  ga('set', 'transport', 'beacon');
  ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async></script>

</body>

</html>
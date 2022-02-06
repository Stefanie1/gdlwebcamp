<?php
include_once 'funciones/sesiones.php';
include_once 'funciones/funciones.php';
include_once 'templates/header.php';
include_once 'templates/barra.php';
include_once 'templates/navegacion.php';
?>


  <!-- =============================================== -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Dashboard
        <small>Informacion sobre el evento</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            
            <div class="box-body chart-responsive">
            <div class="chart" id="grafica-registros" style="height: 300px;"></div>
            </div>
        </div>

        <h2 class="page-header">Resumen de Registros</h2>
        <div class="row">
            <div class="col-lg-3 col-xs-6">
            <?php   
                $sql = "SELECT COUNT(ID_Registrado) AS registros FROM registrados ";
                $resultado = $conn->query($sql);
                $registrados = $resultado->fetch_assoc();
            ?>
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                    <h3><?php echo $registrados['registros']; ?></h3>

                    <p>Total registrados</p>
                    </div>
                    <div class="icon">
                    <i class="fa fa-user"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                    Más información<i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <?php   
                        $sql = "SELECT COUNT(ID_Registrado) AS registros FROM registrados where pagado = 1  ";
                        $resultado = $conn->query($sql);
                        $registrados = $resultado->fetch_assoc();
                    ?>
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php echo $registrados['registros']; ?></h3>
                            <p>Total Pagados</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="lista-registrados.php" class="small-box-footer">
                            Más Información <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
            </div> <!--.col-->

            <div class="col-lg-3 col-xs-6">
                    <?php   
                        $sql = "SELECT COUNT(ID_Registrado) AS registros FROM registrados where pagado = 0 ";
                        $resultado = $conn->query($sql);
                        $registrados = $resultado->fetch_assoc();
                    ?>
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php echo $registrados['registros']; ?></h3>
                            <p>Total sin  Pagar</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user-times"></i>
                        </div>
                        <a href="lista-registrados.php" class="small-box-footer">
                            Más Información <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
            </div> <!--.col-->
            <div class="col-lg-3 col-xs-6">
                    <?php   
                        $sql = "SELECT SUM(total_pagado) AS ganancias FROM registrados where pagado = 1 ";
                        $resultado = $conn->query($sql);
                        $ganancias = $resultado->fetch_assoc();
                    ?>
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>$ <?php echo number_format( $ganancias['ganancias'] ); ?></h3>
                            <p>Ganancias Totales</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-usd"></i>
                        </div>
                        <a href="lista-registrados.php" class="small-box-footer">
                            Más Información <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
            </div> <!--.col-->
        </div>

        <div>
        <h2 class="page-header">Regalos</h2>
            <div class="row">
            <div class="col-lg-3 col-xs-6">
                    <?php   
                        $sql = "SELECT COUNT(regalo) AS pulseras FROM registrados JOIN regalos ON registrados.regalo = regalos.ID_regalo WHERE regalo = 1 AND pagado = 1 ";
                        $resultado = $conn->query($sql);
                         $regalo = $resultado->fetch_assoc();
                    ?>
                    <!-- small box -->
                     <div class="small-box bg-teal">
                        <div class="inner">
                        <h3><?php echo $regalo['pulseras']; ?></h3>
                            <p>Pulseras</p>
                        </div>
                        <div class="icon">
                             <i class="fa fa-gift"></i>
                        </div>
                        <a href="lista-registrados.php" class="small-box-footer">
                             Más Información <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        </div>
                    </div> <!--.col-xs-6-->

                    <div class="col-lg-3 col-xs-6">
                    <?php   
                          $sql = "SELECT COUNT(regalo) AS etiquetas FROM registrados JOIN regalos ON registrados.regalo = regalos.ID_regalo WHERE regalo = 2 AND pagado = 1 ";
                        $resultado = $conn->query($sql);
                         $regalo = $resultado->fetch_assoc();
                    ?>
                    <!-- small box -->
                     <div class="small-box bg-maroon-active">
                        <div class="inner">
                        <h3><?php echo $regalo['etiquetas']; ?></h3>
                            <p>Etiquetas</p>
                        </div>
                        <div class="icon">
                             <i class="fa fa-gift"></i>
                        </div>
                        <a href="lista-registrados.php" class="small-box-footer">
                             Más Información <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        </div>
                    </div> <!--.col-xs-6-->

                    <div class="col-lg-3 col-xs-6">
                    <?php   
                       $sql = "SELECT COUNT(regalo) AS plumas FROM registrados JOIN regalos ON registrados.regalo = regalos.ID_regalo WHERE regalo = 3 AND pagado = 1 ";
                        $resultado = $conn->query($sql);
                         $regalo = $resultado->fetch_assoc();
                    ?>
                    <!-- small box -->
                     <div class="small-box bg-purple-active">
                        <div class="inner">
                        <h3><?php echo $regalo['plumas']; ?></h3>
                            <p>Plumas</p>
                        </div>
                        <div class="icon">
                             <i class="fa fa-gift"></i>
                        </div>
                        <a href="lista-registrados.php" class="small-box-footer">
                             Más Información <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        </div>
                    </div> <!--.col-xs-6-->
                
            </div>
            
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
    include_once 'templates/footer.php';
  ?>

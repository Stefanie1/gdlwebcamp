<!--Verifica si lo que hay en submit es diferente a NULL-->
        <!--Mandar la información a la base de datos-->
        <?php if(isset($_POST['submit'])):
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $regalo = $_POST['regalo'];
            $total = $_POST['total_pedido'];
            $fecha = date('Y-m-d H:i:s');
            //Pedidos
            $boletos = $_POST['boletos'];
            $camisas = $_POST['pedido_camisas'];
            $etiquetas = $_POST['pedido_etiquetas'];
            include_once 'includes/funciones/funciones.php';
            //Simpre que una función retorna un valor se debe de asignarle una variable
            $pedido = productos_json($boletos, $camisas, $etiquetas);
            //eventos
            $eventos = $_POST['registro'];
            $registro = eventos_json($eventos);
        try{
            require_once('includes/funciones/db_conexion.php');
            //Insercción a la base de datos 
            $stmt =$conn->prepare("INSERT INTO registrados(nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado) VALUES (?,?,?,?,?,?,?,?)");
            //s para cadenas , i para entero
            //$stmt->bind_param("ssssssis", NOMBRE DE LAS VARIABLES QUE RECIBEN LOS ARGUMENTOS EN EL FORMULARIO );
            $stmt->bind_param("ssssssis",$nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            //Lo direcciona a la misma pagina para a la hora de recargar no se repitan los registros
            @header('Location:validar_registro.php?exitoso=1');
        }catch(\Exception $e){
             $e->getMessage();
        }
        ?>
        <?php endif;?>
<?php include_once 'includes/templates/header.php'; ?>
<section class="seccion contenedor">
        <h2>Resumen Registro</h2>
        <?php if(isset($_GET['exitoso'])):
            if($_GET['exitoso']== "1"):
                echo "Registro exitoso";
            endif;
        endif;?>
</section>
<?php include_once 'includes/templates/footer.php'; ?>
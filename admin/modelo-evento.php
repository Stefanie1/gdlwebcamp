<?php
// if($conn->ping()){
// echo "conectado";
// } else {
//   echo "no conectdo ";
// }

//  echo "<pre>";
// var_dump($_POST);
//  echo "</pre>";
include_once 'funciones/funciones.php';
$titulo = $_POST['titulo_evento'];
$categoria_id = $_POST['categoria_evento'];
$invitado_id = $_POST['invitado'];
//fecha cambiar orden
$fecha = $_POST['fecha_evento'];
$fecha_formateada = date('Y-m-d', strtotime($fecha));
//hora
$hora = $_POST['hora_evento'];
$hora_formateada = date('H:i', strtotime($hora));


$id_registro = $_POST['id_registro'];


if($_POST['registro'] == 'nuevo'){
    try{
        $stmt = $conn->prepare('INSERT INTO eventos (nombre_evento, fecha_evento, hora_evento, id_cat_evento, id_inv) VALUES (?, ?, ?, ?, ? ) ');
        $stmt->bind_param('sssii', $titulo, $fecha_formateada, $hora_formateada, $categoria_id, $invitado_id );
        $stmt->execute();
        $id_insertado = $stmt->$insert_id;
        if($stmt->affected_rows){
        $respuesta = array(
            'respuesta'=> 'exito',
            'id_insertado' => $stmt->$id_insertado
        );
        } else {
        $respuesta = array(
            'respuesta ' => 'error'
        );
        }
        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        $respuesta = array(
           'respuesta' =>  $e->getMessage()
        );
     }
     die(json_encode($respuesta));
}


if($_POST['registro'] == 'actualizar'){
    
    try{
        $stmt = $conn->prepare('UPDATE eventos SET nombre_evento = ?, fecha_evento = ?,  hora_evento = ?, id_cat_evento = ?, id_inv = ?, editado = NOW() WHERE evento_id = ?');
        $stmt->bind_param('sssiii', $titulo, $fecha_formateada, $hora_formateada, $categoria_id, $invitado_id, $id_registro );
        $stmt->execute();
        if($stmt->affected_rows){
            $respuesta = array(
                'respuesta' => 'exito',
                'id_actualizado' => $id_registro
            );
        } else{
            $respuesta = array(
                'respuesta' => 'error'
            );
        }

        $stmt->close();
        $conn->close();
    }catch(Exception $e){
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}

if($_POST['registro'] == 'eliminar'){
   //die(json_encode($_POST));
   $id_borrar = $_POST['id'];
   try{
    $stmt = $conn->prepare('DELETE FROM eventos WHERE evento_id = ?');
    $stmt->bind_param('i', $id_borrar);
    $stmt->execute();
    if($stmt->affected_rows){
        $respuesta =array(
            'respuesta'=> 'exito',
            'id_eliminado'=> $id_borrar
        );
    }else {
        $respuesta = array(
            'respuesta' => 'error!'
        );
    }

   }catch(Exception $e){
       $respuesta = array(
            'respuesta' => $e->getMessage()
       );
   }
   die(json_encode($respuesta));
}


if(isset($_POST['login-admin'])){
    //die(json_encode($_POST));
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    try{
        include_once 'funciones/funciones.php';
        $stmt = $conn->prepare("SELECT * FROM admin WHERE usuario = ?;");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($id_admin, $usuario_admin, $nombre_admin, $password_admin, $editado);
        if($stmt->affected_rows){
            $existe = $stmt->fetch();
           if($existe){
                if(password_verify($password, $password_admin )){
                    session_start();
                    $_SESSION['usuario'] = $usuario_admin;
                    $_SESSION['nombre'] = $nombre_admin;
                    $respuesta = array(
                        'respuesta' => 'exitoso',
                        'usuario' => $nombre_admin
                    );
                }else{
                    $respuesta = array(
                        'respuesta' => 'error'
                    );
                 }
           }else{
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
        }
        $stmt->close();
        $conn->close();
    }catch(Exception $e){
        echo "Error: " . $e->getMessage();
    }
    die(json_encode($respuesta));
}
?>

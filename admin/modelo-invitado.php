<?php
include_once 'funciones/funciones.php';
$nombre = $_POST['nombre_invitado'];
$apellido = $_POST['apellido_invitado'];
$biografia = $_POST['biografia_invitado'];

if($_POST['registro'] == 'nuevo'){
        
        $respuesta =array(
        'post' => $_POST,
        'file' => $_FILES
            );
        die(json_encode($respuesta));
        
        $directorio ="../img/invitados/";
        if(!is_dir($directorio)){
            mkdir($directorio, 0755, true);
        }
        if(move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio . $_FILES['archivo_imagen']['name'])){
           $imagen_url = $_FILES['archivo_imagen'] ['name'];
           $imagen_resultado = " Se subio correctamente";
        }else {
            $respuesta = array(
                'respuesta' =>  error_get_last()
            );
        }

                
        $respuesta =array(
            'post' => $_POST,
            'file' => $_FILES
                );
            die(json_encode($respuesta));
    try{
        $stmt = $conn->prepare('INSERT INTO invitados (nombre_invitado, apellido_invitado, descripcion, url_imagen, editado = NOW()) VALUES (?, ?, ?, ?)');
        $stmt->bind_param("ssss", $nombre, $apellido, $biografia, $imagen_url );
        $stmt->execute();
        $id_insertado = $stmt->$insert_id;
        if($stmt->affected_rows){
            $respuesta = array(
                'respuesta' => 'exito',
                'id_admin' =>  $id_insertado,
                'resultado_imagen' => $imagen_resultado
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );

        }
        $stmt->close();
        $conn->close();
    }catch(Exception $e){
        echo "Error: " . $e->getMessage();
    }
    die(json_encode($respuesta));
}


if($_POST['registro'] == 'actualizar'){
   // die(json_encode($_POST));
  
    try{
        $stmt = $conn->prepare('UPDATE categoria_evento SET cat_evento = ?, icono = ?, editado = NOW() WHERE id_categoria = ? ');
        $stmt->bind_param("ssi", $nombre_categoria, $icono, $id_registro);
        $stmt->execute();
        if($stmt->affected_rows){
            $respuesta = array(
                'respuesta' => 'exito',
                'id_actualizado' =>$id_registro
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
    $stmt = $conn->prepare('DELETE FROM categoria_evento WHERE id_categoria = ?');
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

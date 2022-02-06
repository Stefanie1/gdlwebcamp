<?php
include_once 'funciones/funciones.php';
$nombre_categoria = $_POST['nombre_categoria'];
$icono = $_POST['icono'];

$id_registro = $_POST['id_registro'];

if($_POST['registro'] == 'nuevo'){
   // die(json_encode($_POST));
    try{
        $stmt = $conn->prepare('INSERT INTO categoria_evento (cat_evento, icono) VALUES (?, ?)');
        $stmt->bind_param("ss", $nombre_cartegoria, $icono);
        $stmt->execute();
        $id_insertado = $stmt->$insert_id;
        if($stmt->affected_rows){
            $respuesta = array(
                'respuesta' => 'exito',
                'id_admin' =>  $id_insertado
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

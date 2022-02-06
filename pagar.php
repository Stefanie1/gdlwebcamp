<?php

if (!isset($_POST['submit'])) {
    exit("Hubo un error");
}

//===========IMPORTAR CLASES===============================

use PayPal\Api\Payer; //Importa la clase de PAYER
use PayPal\Api\Item; //Importa la clase de ITEM
use PayPal\Api\ItemList; //Importa la clase de ITEMLIST
use PayPal\Api\Details; //Importa la clase de DETAILS
use PayPal\Api\Amount; //Importa la clase de AMOUNT
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;

/* echo "<pre>";
  var_dump($_POST);
  echo "</pre>"; */
require 'includes/paypal.php';
if (isset($_POST['submit'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $regalo = $_POST['regalo'];
    $total = $_POST['total_pedido'];
    $fecha = date('Y-m-d H:i:s');
    //Pedidos
    $boletos = $_POST['boletos'];
    $numero_boletos = $boletos;
    $pedidoExtra = $_POST['pedido_extra'];
    $camisas = $_POST['pedido_extra']['camisas']['cantidad'];
    $precioCamisa = $_POST['pedido_extra']['camisas']['precio'];
    $etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];
    $precioEtiquetas = $_POST['pedido_extra']['etiquetas']['precio'];
    include_once 'includes/funciones/funciones.php';
    //Simpre que una función retorna un valor se debe de asignarle una variable
    $pedido = productos_json($boletos, $camisas, $etiquetas);
    //eventos
    $eventos = $_POST['registro'];
    $registro = eventos_json($eventos);
    $pagado = 0;
    /* echo "<pre>";
      var_dump($pedidoExtra);
      echo "</pre>";
      exit; */
    try {
        require_once('includes/funciones/db_conexion.php');
        //Insercción a la base de datos 
        $stmt = $conn->prepare("INSERT INTO registrados(nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado, pagado) VALUES (?,?,?,?,?,?,?,?,?)");
        //s para cadenas , i para entero
        //$stmt->bind_param("ssssssis", NOMBRE DE LAS VARIABLES QUE RECIBEN LOS ARGUMENTOS EN EL FORMULARIO );
        $stmt->bind_param("ssssssisi", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total, $pagado);
        $stmt->execute();
        $ID_registro = $stmt->insert_id;
        $stmt->close();
        $conn->close();
        //Lo direcciona a la misma pagina para a la hora de recargar no se repitan los registros
        //header('Location:validar_registro.php?exitoso=1');
    } catch (\Exception $e) {
        die($e->getMessage());
    }
}
//=================CREACIÓN DE CLASES======================
$compra = new Payer(); //Instanciar la clase PAYER
$compra->setPaymentMethod('paypal');
$articulo = new Item();
$articulo->setName('GDLWEBCAMP Compra Evento')
        ->setCurrency('MXN')
        ->setQuantity(1)
        ->setPrice($total);
$i = 0;
$arreglo_pedido = array();
foreach ($numero_boletos as $key => $value) {
    if ((int) $value['cantidad'] > 0) {
        ${"articulo$i"} = new Item(); //Va creando las instancias
        $arreglo_pedido[] = ${"articulo$i"};
        ${"articulo$i"}->setName('Pase: ' . $key)
                ->setCurrency('USD')
                ->setQuantity((int) $value['cantidad'])
                ->setPrice((int) $value['precio']);
        $i++;
    }
}
foreach ($pedidoExtra as $key => $value) {
    if ((int) $value['cantidad'] > 0) {
        if ($key == 'camisas') {
            $precio = (float) $value['precio'] * .93;
        } else {
            $precio = (int) $value['precio'];
        }
        ${"articulo$i"} = new Item(); //Va creando las instancias
        $arreglo_pedido[] = ${"articulo$i"};
        ${"articulo$i"}->setName('Extras: ' . $key)
                ->setCurrency('USD')
                ->setQuantity((int) $value['cantidad'])
                ->setPrice($precio);
        $i++;
    }
}
//echo $articulo2->getName();
/* Para checar que se esten creando los objetos
  echo $articulo0->getName();
  echo $articulo0->getQuantity(); */

//echo $articulo->getQuantity();//Imprimir el valor de algunos de los métodos
//echo $articulo->getPrice();
//La clase ItemList, se le pasa todos los articulos que se le van a cobrar al usuario
$listaArticulos = new ItemList();
$listaArticulos->setItems($arreglo_pedido);
/* cho "<pre>";
  var_dump($listaArticulos);
  echo "</pre>"; */
//La clase Amount , cantidad que se va a pagar
$cantidad = new Amount(); //Instancial la clase Amount
$cantidad->setCurrency('USD')
        ->setTotal($total);
//La clase transaction define el contrato de un pago
$transaccion = new Transaction(); //Instancial la clase TRANSACTION
$transaccion->setAmount($cantidad)//Cantidad que va hacer cobrada
        ->setItemList($listaArticulos)
        ->setDescription('Pago GDLWEBCAMP')
        ->setInvoiceNumber($ID_registro); //Numero de indentificador de la persona que realizo el paso, uniqid(genera numeros ID)
/* echo $transaccion->getInvoiceNumber(); */
$redireccionar = new RedirectUrls(); //Instancial la clase RedirectUrls
$redireccionar->setReturnUrl(URL_SITIO . "/pago_finalizado.php?&id_pago={$ID_registro}")//Página donde se va a dirección al usuario una vez que realice su pago.
        ->setCancelUrl(URL_SITIO . "/pago_finalizado.php?&id_pago={$ID_registro}");
//echo $redireccionar->getReturnUrl();
//Clase PAYMENT, envia toda la información a Paypal

$pago = new Payment();
$pago->setIntent("sale")
        ->setPayer($compra)
        ->setRedirectUrls($redireccionar)
        ->setTransactions(array($transaccion));
try {
    //Asocia toda la información con el context que contienen las claves
    $pago->create($apiContext);
} catch (PayPal\Exception\PayPalConnectionException $pce) {
    echo "<pre>";
    print_r(json_decode($pce->getData()));
    exit;
    echo "</pre>";
}
$aprobado = $pago->getApprovalLink();
header("Location: {$aprobado}");
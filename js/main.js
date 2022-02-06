(function() {
    "use strict";

    var regalo = document.getElementById('regalo');
    document.addEventListener('DOMContentLoaded', function() {

        if (window.location.href === "http://localhost/gdlwebcamp/index.php" || window.location.href === "http://localhost/gdlwebcamp/") {
            console.log('holiiiii');

            var map = L.map('mapa').setView([19.481734, -99.06238], 17);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([19.481734, -99.06238]).addTo(map)
                .bindPopup('CASITA DE LA CHAYA <br> que emocion')
                .openPopup()
                .bindTooltip('pura cosa bella')
                .openTooltip();
            console.log(document.getElementById('mapa'));
        }
        if (window.location.href === "http://localhost/gdlwebcamp/registro.php") {
            document.getElementById('btnRegistro').disabled = true;

        }

        console.log("listo");
        //campos datos de ususario 
        var nombre = document.getElementById('nombre');
        var apellido = document.getElementById('apellido');
        var email = document.getElementById('email');
        //campos pases 
        var pase_dia = document.getElementById('pase_dia');
        var pase_completo = document.getElementById('pase_completo');
        var pase_dosdias = document.getElementById('pase_dosdias');
        //botones y divs 
        var calcular = document.getElementById('calcular');
        var errorDiv = document.getElementById('error');
        //var botonRegistro = document.getElementById('btnRegistro');
        var lista_productos = document.getElementById('lista-productos');
        var suma = document.getElementById('suma-total');
        //document.getElementById('btnRegistro').disabled = true;
        //botonRegistro.disabled = true;

        //**Extras */
        var etiquetas = document.getElementById('etiquetas');
        var camisas = document.getElementById('camisa_evento');



        //**Eventos */
        if (document.getElementById('calcular')) { //QUITA EL ERROR Y PUEDE SER CUALQUIER VARIABLE
            calcular.addEventListener('click', calcularMontos);
            pase_dia.addEventListener('blur', mostrarDias); //permite conservar el ultimo valor
            pase_dosdias.addEventListener('blur', mostrarDias);
            pase_completo.addEventListener('blur', mostrarDias);
            nombre.addEventListener('blur', validarCampos);
            apellido.addEventListener('blur', validarCampos);
            email.addEventListener('blur', validarCampos);
            email.addEventListener('blur', validarMail);


            //**VALIGACION DE REGISTRO */
            function validarCampos() {
                if (this.value == '') {
                    errorDiv.style.display = 'block';
                    errorDiv.innerHTML = "ESTE CAMPO ES OBLIGATORIO";
                    this.style.border = '1px solid red';
                    errorDiv.style.border = '1px solid red';
                } else {
                    errorDiv.style.display = 'none'; //borra el margen rojo si ya se lleno
                    this.style.border = '1px solid #cccccc'; //borde del campo
                }
            }

            function validarMail() {
                if (this.value.indexOf("@") > -1) { //si indexof no exist eda -1 buscva un caracter
                    errorDiv.style.display = 'none'; //borra el margen rojo si ya se lleno
                    this.style.border = '1px solid #cccccc'; //borde del campo
                } else {
                    errorDiv.style.display = 'block';
                    errorDiv.innerHTML = "ESTE CAMPO DEBE CONTENER AL MENOS UNA @";
                    this.style.border = '1px solid red';
                    errorDiv.style.border = '1px solid red';
                }
            }

            function calcularMontos(event) {
                event.preventDefault();
                //console.log('hiciste click en calcular');
                //console.log(regalo.value);
                if (regalo.value === '') {
                    alert("Debes elegir un regalo");
                    regalo.focus();
                } else {
                    //console.log(pase_dia.value);
                    //console.log(pase_dosdias.value);
                    //console.log(pase_completo.value);//ya elegieron un regalo
                    var boletosDia = parseInt(pase_dia.value, 10) || 0, //funcion parse int
                        boletos2Dias = parseInt(pase_dosdias.value, 10) || 0,
                        boletoCompleto = parseInt(pase_completo.value, 10) || 0,
                        cantCamisas = parseInt(camisa_evento.value, 10) || 0,
                        cantEtiquetas = parseInt(etiquetas.value, 10) || 0; //USAR sietema decimal 
                    //console.log("Boletos Dia: " + boletosDia);
                    //console.log("Boletos 2 Dias: " + boletos2Dias);
                    //console.log("Boletos Completos: " + boletoCompleto);
                    var totalPagar = (boletosDia * 30) + (boletos2Dias * 45) + (boletoCompleto * 50) + ((cantCamisas * 10) * .93) + (cantEtiquetas * 2);
                    //console.log(totalPagar);
                    var listadoProductos = [];
                    if (boletosDia >= 1) {
                        listadoProductos.push('Pases por dia: ' + boletosDia);
                    }
                    if (boletos2Dias >= 1) {
                        listadoProductos.push('Pases por 2 dias: ' + boletos2Dias);
                    }
                    if (boletoCompleto >= 1) {
                        listadoProductos.push('Pases Completos: ' + boletoCompleto);
                    }
                    if (cantCamisas >= 1) {
                        listadoProductos.push('Camisas: ' + cantCamisas);
                    }
                    if (cantEtiquetas >= 1) {
                        listadoProductos.push('Etiquetas: ' + cantEtiquetas);
                    }

                    //console.log(listadoProductos);

                    //**IMPRESION DEL RESUMEN */
                    lista_productos.style.display = "block"; //lo hacemos visible ya que tiene el valor
                    lista_productos.innerHTML = ''; //arreglo vacio y se va a ir llenando //inner para que no se reescriba todo 
                    for (var i = 0; i < listadoProductos.length; i++) {
                        lista_productos.innerHTML += listadoProductos[i] + '<br/>';
                    }

                    if (window.location.href === "http://localhost/gdlwebcamp/registro.php") {
                        document.getElementById('btnRegistro').disabled = false;

                    }
                    //botonRegistro.disabled = false;
                    suma.innerHTML = "$ " + totalPagar.toFixed(2); //fix solo dos decimal
                    //botonRegistro.disabled = false; //habilitra de nuevo el boton pagar
                    document.getElementById('total_pedido').value = totalPagar;
                }
            }
            //**MUESTRA LOS TALLERES DEPENDIENDO DEL DIA QUE ASITIRAS  */
            function mostrarDias() {
                //console.log(pase_dia.value); 
                var boletosDia = parseInt(pase_dia.value, 10) || 0, //funcion parse int
                    boletos2Dias = parseInt(pase_dosdias.value, 10) || 0,
                    boletoCompleto = parseInt(pase_completo.value, 10) || 0;

                var diasElegidos = [];
                if (boletosDia > 0) {
                    diasElegidos.push('viernes'); //dias son el id de los arreglos
                }
                if (boletos2Dias > 0) {
                    diasElegidos.push('viernes', 'sabado');
                }
                if (boletoCompleto > 0) {
                    diasElegidos.push('viernes', 'sabado', 'domingo');
                }
                for (var i = 0; i < diasElegidos.length; i++) {
                    document.getElementById(diasElegidos[i]).style.display = 'block'; //muestro
                }
            }
        }
    }); //dom contente loaded
})();

$(function() {
    //alert("funciona");
    //==========================LETTERING NOMBRE DE SITIO==================
    $('.nombre-sitio').lettering();

    //==========================AGREGAR CLASE A MENU==================
    $('body.conferencia .navegacion-principal a:contains("Conferencia")').addClass('activo');
    $('body.calendario .navegacion-principal a:contains("Calendario")').addClass('activo');
    $('body.invitados .navegacion-principal a:contains("Invitados")').addClass('activo');





    //==========================MANTENER LA BARRA EN LA PARET SUPERIOR==================
    var windowHeight = $(window).height();
    //console.log(windowHeight); //da el valor que mide la pag web
    var barraAltura = $('.barra').innerHeight(); //true te da todos los valores y caracteristicas
    //console.log(barraAltura); //da el valor qu emide la barra
    $(window).scroll(function() {
        var scroll = $(window).scrollTop(); //top detecta el scroll
        //console.log(scroll);
        if (scroll > windowHeight) {
            // console.log("ya rebasaste la altura de la pantalla");
            $('.barra').addClass('fixed');
            $('body').css({ 'margin-top': barraAltura + 'px' }); //quita bricno
        } else {
            // console.log("aun no  rebasaste");
            $('.barra').removeClass('fixed');
            $('body').css({ 'margin-top': '0px' }); //quita brinco de abjor arriba
        }
    });

    //==========================MENU RESPONSIVER==================
    $('.menu-movil').on('click', function() {
        $('.navegacion-principal').slideToggle();
    });




    //==========================programa de conferencias flechita que se mueve==================
    $('.programa-evento .info-curso:first').show(); //solo muestra talleres 
    $('.menu-programa a :first').addClass('activo');
    $('.menu-programa a').on('click', function() {
        $('.menu-programa a').removeClass('activo'); //leelimina el activo a todos
        $(this).addClass('activo'); //se la agrega al que di click
        $('.ocultar').hide(); //ocultar
        var enlace = $(this).attr('href');
        //console.log(enlace);//para que me de a cual le pique
        $(enlace).fadeIn(1000); //aparescan lentamente
        return false;
    });
    //==========================animaciones para los numeros==================
    $('.resumen-evento li:nth-child(1) p').animateNumber({ number: 6 }, 3000);
    $('.resumen-evento li:nth-child(2) p').animateNumber({ number: 15 }, 3000);
    $('.resumen-evento li:nth-child(3) p').animateNumber({ number: 3 }, 3000);
    $('.resumen-evento li:nth-child(4) p').animateNumber({ number: 9 }, 3000);

    //==========================animaciones para los numeros cuenta regre==================
    $('.cuenta-regresiva').countdown('2020/09/13 11:00:00', function(event) {
        $('#dias').html(event.strftime('%D'));
        $('#horas').html(event.strftime('%H'));
        $('#minutos').html(event.strftime('%M'));
        $('#segundos').html(event.strftime('%S'));

    });


    //colorbox
    $('.invitado-info').colorbox({ inline: true, width: "50%" });
});
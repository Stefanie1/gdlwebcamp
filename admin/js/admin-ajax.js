$(document).ready(function() {
    $('#guardar-registro').on('submit', function(e) {
        e.preventDefault();
        //console.log("Click!!");

        var datos = $(this).serializeArray();
        //console.log(datos);

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal(
                        'Correcto',
                        'Se guardo correctamente',
                        'success'
                    )
                } else {
                    swal(
                        'Error',
                        'Hubo un error',
                        'error'
                    )
                }
            }

        })

    });


    //se ejecuta cuanos hay un archivo 
    $('#guardar-registro-archivo').on('submit', function(e) {
        e.preventDefault();
        //console.log("Click!!");

        var datos = new FormData(this);
        //console.log(datos);

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            contentType: false,
            processData: false,
            async: true,
            cache: false,
            success: function(data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal(
                        'Correcto',
                        'Se guardo correctamente',
                        'success'
                    )
                } else {
                    swal(
                        'Error',
                        'Hubo un error',
                        'error'
                    )
                }
            }

        })

    });


    //ELIMINAR UN REGISTRO

    $('.borrar_registro').on('click', function(e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: 'Estas SEGURO ?',
            text: "NO es posible revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrar!',
            cancelButtonText: 'Cancelar'
        }).then(function() {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'registro': 'eliminar'
                },
                url: 'modelo-' + tipo + '.php',
                success: function(data) {
                    console.log(data);
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal(
                                'Eliminado!',
                                'El registro se ha sido eliminado.',
                                'success'
                            )
                            //console.log(resultado); --para que se elimine de la parte visual
                        jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'No se puede eliminar!',

                        })

                    }

                }
            })
        });
    });



});
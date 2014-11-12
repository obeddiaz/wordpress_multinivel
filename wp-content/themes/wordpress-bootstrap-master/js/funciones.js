function confirmar(producto)
{
    if (confirm('¿Estas seguro de eliminar este Producto?'))
    {
        window.location = '/index.php/productos/eliminar_producto/' + producto;
    }
    else
    {
        return false;
    }
}
$(document).ready(function () {
    $('#username').focusout(function () {
        if ($("#username").val().length < 4)
        {
            $('#msgusuario').html("<span style='color:#f00'>El nick debe contener 5 caracteres minimo</span>");
        }
        else if ($("#username").val().length > 24)
        {
            $('#msgusuario').html("<span style='color:#f00'>El nick debe contener menos de 24 caracteres</span>");
        }
        else {
            $.ajax({
                type: "POST",
                url: "http://" + GetBaseUrl() + "/index.php/verificacion/comprobar_usuario_ajax",
                data: "username=" + $('#username').val(),
                dataType: "html",
                beforeSend: function () {
                    $('#msgusuario').html('Verificando...');
                },
                success: function (data) {
                    $("#msgusuario").html(data);
                    n();
                }

            });
            return false;
        }
    });
});

/*----------------------------------------------------------------------------------------------------------------------*/
/*funcion ajax para comprobar si el usuario existe en la base de datos*/

$(document).ready(function () {
    var emailreg = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    // aqui va a ir la validacion
    $('#email').focusout(function () {
        if ($("#email").val() == "" || !emailreg.test($("#email").val()))
        {
            $('#msgEmail').html("<span style='color:#f00'>Ingrese un email correcto</span>");
        } else {
            $.ajax({
                type: "POST",
                url: "http://" + GetBaseUrl() + "/index.php/verificacion/comprobar_email_ajax",
                data: "email=" + $('#email').val(),
                dataType: "html",
                beforeSend: function () {
                    $('#msgEmail').html('Verificando...');
                },
                success: function (data) {
                    $('#msgEmail').html(data);
                    n();
                    ;
                }
            });
            return false;
        }
    });
});
$(document).ready(function () {
    $('#password').keyup(function () {
        var emailreg = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
        var RegExPattern = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/;
        if ($("#password").val().length < 6)
        {
            $('#msgpassword').html("<span style='color:red'>La contraseña debe tener 6 o más caracteres.</span>");
        }
        else {
            $('#msgpassword').html("<span style='color:green'>Correcto</span>");
        }

    });
});
$(document).ready(function () {
    $('#password_conf').keyup(function () {
        if ($("#password").val() != $("#password_conf").val())
        {
            $('#msgpassword_conf').html("<span style='color:red'>Las contraseñas no coinsiden</span>");
        }
        else {
            $('#msgpassword_conf').html("<span style='color:green'>Correcto</span>");
        }
    });
});
$(document).ready(function () {
    $('#id_verificar').click(function () {
        $.ajax({
            type: "POST",
            url: "http://" + GetBaseUrl() + "/index.php/verificacion/comprobar_datos_usuario_ajax",
            data: "invitado=" + $('#invitado').val(),
            dataType: "html",
            beforeSend: function () {
                $('#msgInvitado').html('Verificando...');
            },
            success: function (data) {
                $('#myModal').html(data);
                $('#myModal').modal();
            }

        });
        return false;
    });
});
$(document).ready(function () {
    $('#month').change(function () {
        $("#day").empty();
        if ($('#month').val() == '01' || $('#month').val() == '03' || $('#month').val() == '05' || $('#month').val() == '07' || $('#month').val() == '08' || $('#month').val() == '10' || $('#month').val() == '12') {
            $("#day").append('<option value=\'FALSE\'>Dia</option>');
            for (var i = 1; i <= 31; i++)
            {
                $("#day").append('<option value=' + i + '>' + i + '</option>');
            }
        }
        ;
        if ($('#month').val() == '02') {
            $("#day").append('<option value=\'FALSE\'>Dia</option>');
            for (var i = 1; i <= 29; i++)
            {
                $("#day").append('<option value=\'' + i + '\'>' + i + '</option>');
            }
        }
        ;
        if ($('#month').val() == '04' || $('#month').val() == '06' || $('#month').val() == '09' || $('#month').val() == '11') {
            $("#day").append('<option value=\'FALSE\'>Dia</option>');
            for (var i = 1; i <= 30; i++)
            {
                $("#day").append('<option value=\'' + i + '\'>' + i + '</option>');
            }
        }
        ;
    });
});
function GetBaseUrl() {
    try {
        var url = location.href;

        var start = url.indexOf('//');
        if (start < 0)
            start = 0
        else
            start = start + 2;

        var end = url.indexOf('/', start);
        if (end < 0)
            end = url.length - start;

        var baseURL = url.substring(start, end);
        return baseURL;
    }
    catch (arg) {
        return null;
    }
}
function editar_producto(id_produto) {
    $.ajax({
        type: "POST",
        url: "http://" + GetBaseUrl() + "/index.php/verificacion/obtener_producto",
        data: "producto=" + id_produto,
        dataType: "html",
        beforeSend: function () {
            $('#msgInvitado').html('Verificando...');
        },
        success: function (data) {
            //var $this = $(this)
//            console.log(data);
//            var $remote =  data;
//            var $modal = $('<div class="modal" id="ajaxModal"><div class="modal-body"></div></div>');
//            $('body').append($modal);
//            $modal.modal({backdrop: 'static', keyboard: false});
//            $modal.load($remote);
            $('#myModal').html(data);
            $('#myModal').modal();
            //jAlert(data, 'Modificar Datos de Producto');
        }

    });
    return false;
}
function show_producto(id_produto) {
    $.ajax({
        type: "POST",
        url: "http://" + GetBaseUrl() + "/index.php/verificacion/detalles_producto",
        data: "producto=" + id_produto,
        dataType: "html",
        beforeSend: function () {
        },
        success: function (data) {
            //jAlert(data, 'Detalles');
            $('#myModal').html(data);
            $('#myModal').modal();
        }

    });
    return false;
}
function venta(usuario) {
    $.ajax({
        type: "POST",
        url: "http://" + GetBaseUrl() + "/index.php/verificacion/usuario",
        data: "usuario=" + usuario,
        dataType: "html",
        beforeSend: function () {
            $('#msgInvitado').html('Verificando...');
        },
        success: function (data) {
            jAlert(data, 'Venta');
        }

    });
    return false;
}

function confirmar_pago(usuario) {
    if (confirm('¿Estas seguro que deseas confirmar el pago de este usuario?')) {
        window.location = "http://" + GetBaseUrl() + "/index.php/verificacion/comprobar_pago/" + usuario;
    }
}

function ventas(usuario) {
    window.location = "http://" + GetBaseUrl() + "/index.php/show_usuarios/venta/" + usuario;
}

function detalles_usuario(id_usuario) {
    $.ajax({
        type: "POST",
        url: "http://" + GetBaseUrl() + "/index.php/verificacion/detalles_de_usuario",
        data: "id_usuario=" + id_usuario,
        dataType: "html",
        beforeSend: function () {
            $('#msgInvitado').html('Verificando...');
        },
        success: function (data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        }

    });
    return false;
}

function detalles_invitado(id_usuario) {
    $.ajax({
        type: "POST",
        url: "http://" + GetBaseUrl() + "/index.php/verificacion/detalles_de_invitado",
        data: "id_usuario=" + id_usuario,
        dataType: "html",
        beforeSend: function () {
            $('#msgInvitado').html('Verificando...');
        },
        success: function (data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        }

    });
    return false;
}

function cambio_password(id_usuario) {
    $.ajax({
        type: "POST",
        url: "http://" + GetBaseUrl() + "/index.php/verificacion/cambiar_password",
        data: "id_usuario=" + id_usuario,
        dataType: "html",
        success: function (data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        }

    });
    return false;
}



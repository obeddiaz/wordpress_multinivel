jQuery(document).ready(function ($) {


    $('.confirmar_pago').click(function () {
        var user_id = $(this).data('id');
        var user_nivel = $(this).data('nivel');
        var txt;
        var r = confirm("Realmente quiere confirmar el pago de este usuario?");
        if (r == true) {
            var request = $.ajax({
                url: "/wp-admin/admin-ajax.php?action=confirmar_pago_usuario",
                type: "POST",
                data: {
                    id: user_id,
                    nivel: user_nivel
                },
                dataType: "html"
            });

            request.done(function (msg) {
                alert("Haz confirmado correctamente el pago de este usuario");
                location.reload();
            });
            request.fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        }

    });
});
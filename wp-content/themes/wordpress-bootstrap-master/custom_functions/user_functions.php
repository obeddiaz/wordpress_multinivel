<?php
add_action('admin_menu', 'register_my_custom_menu_page');

function register_my_custom_menu_page() {
    //add_menu_page('Mi Red', 'Mi Red', 'manage_options', 'ml_mired', 'mlfunction_mired', plugins_url('myplugin/images/icon.png'), 6);
    add_menu_page('Mi Red', 'Mi Red', 'read', 'mi_red', 'mlfunction_mired');
    //add_menu_page('Mis Invitados', 'Mis Invitados', 'read', 'mis_invitados', 'mlfunction_misinvitados');
    add_menu_page("Nuevo Afiliado", "Nuevo Afiliado", "read", "ml_afiliados", "mlfunction_afiliados");
    add_submenu_page(null, 'Afiliados de', 'Afiliados de', 'manage_options', 'afiliados_de', 'ml_afiliados_de');
}

function mlfunction_mired() {
    require_once(get_template_directory() . '/userfrontend/mi_red.php');
}

function mlfunction_misinvitados() {
    require_once(get_template_directory() . '/userfrontend/mis_invitados.php');
}

function mlfunction_afiliados() {
    $current_user = wp_get_current_user();
    ?>
    <h1>Agregar nuevo Usuario a mi Red</h1>
    <?php
    if (isset($_POST['submit'])) {
        admin_register_function();
    }
    ?>

    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post"  accept-charset="utf-8" class="form-horizontal">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Usuario</label>
            <div class="col-sm-10">
                <input type="text" name="username" value="<?php ( isset($_POST['username']) ? $username : null ) ?>" id="username" placeholder="Nombre de usuario" class="form-control"> 
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Contraseña</label>
            <div class="col-sm-10">
                <input type="password" name="password" value="<?php ( isset($_POST['password']) ? $password : null ) ?>" id="password" placeholder="Password" class="form-control">            <span id="msgpassword"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Nombre(s)</label>
            <div class="col-sm-10">
                <input type="text" name="fname" value="<?php ( isset($_POST['fname']) ? $first_name : null ) ?>" id="nombre" placeholder="Nombre" class="form-control">        </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Apellidos</label>
            <div class="col-sm-10">
                <input type="text" name="lname" value="<?php ( isset($_POST['lname']) ? $last_name : null ) ?>" id="apellido" placeholder="Apellidos" class="form-control">        </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input type="text" name="email" value="<?php ( isset($_POST['email']) ? $email : null ) ?>" id="email" placeholder="Email" class="form-control">            <span id="msgEmail"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Telefono</label>
            <div class="col-sm-10">
                <input type="text" name="ml_datos[telefono]" value="" id="telefono" placeholder="XXX-XXX-XXXX" class="form-control">        </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Celular</label>
            <div class="col-sm-10">
                <input type="text" name="ml_datos[celular]" value="" id="telefono" placeholder="XXX-XXX-XXXX" class="form-control">        </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Datos Bancarios</label>
            <div class="col-sm-10">
                <textarea type="text" name="ml_datos[cuenta_bancaria]" class="form-control" style="resize: none;"></textarea>        </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Persona que Invito</label>
            <div class="col-sm-7">
                <input type="text" readonly="readonly" name="invitado" value="<?= $current_user->ID ?>" id="invitado" placeholder="Ejemplo: 15" class="form-control">     
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="terminos_y_condiciones" value="yes"/>
                <input type="submit" name="submit" value="Inscribirme" id="registro" class="btn btn-primary">  
            </div>
        </div>
    </form>
    <?php
}

function admin_register_function() {
    if (isset($_POST['submit'])) {
        registration_validation(
                $_POST['username'], $_POST['password'], $_POST['email'], $_POST['website'], $_POST['fname'], $_POST['lname'], $_POST['nickname'], $_POST['bio'], $_POST['invitado'], $_POST['terminos_y_condiciones']
        );

        // sanitize user form input
        global $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
        $username = sanitize_user($_POST['username']);
        $password = esc_attr($_POST['password']);
        $email = sanitize_email($_POST['email']);
        $website = esc_url($_POST['website']);
        $first_name = sanitize_text_field($_POST['fname']);
        $last_name = sanitize_text_field($_POST['lname']);
        $nickname = sanitize_text_field($_POST['nickname']);
        $bio = esc_textarea($_POST['bio']);
        $invitado = sanitize_text_field($_POST['invitado']);
        $datos = $_POST['ml_datos'];
        complete_registration($invitado, $datos);
    }
}

function ml_afiliados_de() {
    if (isset($_GET['user_id'])) {
        if (is_numeric($_GET['user_id'])) {
            require_once(get_template_directory() . '/userfrontend/afiliado_de.php');
        }
    }
}
?>
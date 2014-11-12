<?php
add_filter('manage_users_columns', 'pippin_add_user_id_column');

function pippin_add_user_id_column($columns) {
    $columns['user_id'] = '# Ususario';
    $columns['cant_inv'] = '# Invitados';
    $columns['cant_afi'] = '# Afiliados';
    $columns['afiliado_de'] = 'Afiliado de';
    $columns['invitado_de'] = 'Invitado de';
    $columns['ver_red'] = 'ver Red';
    return $columns;
}

add_action('manage_users_custom_column', 'pippin_show_user_id_column_content', 10, 3);

function pippin_show_user_id_column_content($value, $column_name, $user_id) {
    $user = get_userdata($user_id);
    if ('user_id' == $column_name) {
        return $user_id;
    }
    if ('afiliado_de' == $column_name) {
        $afiliado = get_user_meta($user_id, 'afiliado_de');
        $userafi = get_userdata($afiliado[0]);
        return $userafi->user_login;
    }
    if ('invitado_de' == $column_name) {
        $invitado = get_user_meta($user_id, 'invitado_de');
        $userinv = get_userdata($invitado[0]);
        return $userinv->user_login;
    }
    if ('cant_inv' == $column_name) {
        $invitado = count_users_per_meta('invitado_de', $user_id);
        return $invitado;
    }
    if ('cant_afi' == $column_name) {
        $afiliados = count_users_per_meta('afiliado_de', $user_id);
        return $afiliados;
    }
    if ('ver_red' == $column_name) {
        $button = '<a href="/wp-admin/admin.php?page=afiliados_de&user_id=' . $user_id . '">Ver Red</a>';
        //var_dump($user_id);
        return $button;
    }
    return $value;
}

add_action('user_new_form', function( $type ) {
    if ('add-new-user' !== $type) {
        return;
    }
    $blogusers = get_users();
    //var_dump($blogusers);
    ?>
    <table class="form-table">
        <tbody>
            <tr class="form-field form-required">
                <th scope="row"><label for="user_login">Invitado de </label></th>
                <td><select name="invitado_de">
                        <option value="">Seleccionar Usuario</option>
                        <?php
                        foreach ($blogusers as $user) {
                            echo '<option value="' . $user->ID . '">' . $user->user_login . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr class="form-field form-required">
                <th scope="row"><label for="user_login">Afiliado de </label></th>
                <td>
                    <select name="afiliado_de">
                        <option value="">Seleccionar Usuario</option>
                        <?php
                        foreach ($blogusers as $user) {
                            echo '<option value="' . $user->ID . '">' . $user->user_login . '</option>';
                            //var_dump($user->user_login);
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="city"><?php _e("Telefono "); ?></label></th>
                <td>
                    <input name="ml_datos[telefono]" placeholder="Telefono"/>
                </td>
            </tr>
            <tr>
                <th><label for="city"><?php _e("Celular "); ?></label></th>
                <td>
                    <input name="ml_datos[celular]" placeholder="Celular"/>
                </td>
            </tr>
            <tr>
                <th><label for="city"><?php _e("Cuenta Bancaria "); ?></label></th>
                <td>
                    <input name="ml_datos[cuenta_bancaria]" placeholder="Cuenta bancaria"/>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
});

add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');

function extra_user_profile_fields($user) {
    //var_dump($user->ID);
    $blogusers = get_users();

    $invitado = get_user_meta($user->ID, 'invitado_de');
    $afiliado = get_user_meta($user->ID, 'afiliado_de');
    $mis_datos = get_user_meta($user->ID, 'ml_misdatos');
    //var_dump($mis_datos);
    //get_currentuserinfo();
    global $user_level;
    ?>
    <h3><?php _e("Informacion de Afiliado", "blank"); ?></h3>

    <table class="form-table">
        <?php if ($user_level >= 9) { ?>
            <tr>
                <th><label for = "invitado_de"><?php _e("Invitado de");
            ?></label></th>
                <td>
                    <select name="invitado_de">
                        <option value="">Seleccionar Usuario</option>
                        <?php
                        foreach ($blogusers as $userdata) {
                            echo '<option value="' . $userdata->ID . '" ' . selected($invitado[0], $userdata->ID) . '>' . $userdata->user_login . '</option>';
                        }
                        ?>
                    </select>
                    <br />
                    <span class="description"><?php _e("Selecciona la persona que Invito a este usuario"); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="city"><?php _e("Afiliado de "); ?></label></th>
                <td>
                    <select name="afiliado_de">
                        <option value="">Seleccionar Usuario</option>
                        <?php
                        foreach ($blogusers as $userdata) {
                            echo '<option value="' . $userdata->ID . '" ' . selected($afiliado[0], $userdata->ID) . '>' . $userdata->user_login . '</option>';
                            //var_dump($user->user_login);
                        }
                        ?>
                    </select>
                    <br />
                    <span class="description"><?php _e("Selecciona a la persona que se va afiliar a este Usuario"); ?></span>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <th><label for="city"><?php _e("Telefono "); ?></label></th>
            <td>
                <input name="ml_datos[telefono]" placeholder="Telefono" value="<?php
                if ($mis_datos): echo $mis_datos[0]['telefono'];
                endif;
                ?>"/>
            </td>
        </tr>
        <tr>
            <th><label for="city"><?php _e("Celular "); ?></label></th>
            <td>
                <input name="ml_datos[celular]" placeholder="Celular" value="<?php
                if ($mis_datos): echo $mis_datos[0]['celular'];
                endif;
                ?>"/>
            </td>
        </tr>
        <tr>
            <th><label for="city"><?php _e("Datos de Cuenta Bancaria "); ?></label></th>
            <td>
                <textarea name="ml_datos[cuenta_bancaria]" placeholder="Cuenta bancaria" style="width: 100%; height: 150px; resize: none;"><?php
                    if ($mis_datos): echo $mis_datos[0]['cuenta_bancaria'];
                    endif;
                    ?></textarea> <br>
                <span class="description">Por favor Ingresa los datos de la cuenta a la que se depositaran los regalos.</span>
            </td>
        </tr>
    </table>
    <?php
}

add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');

function save_extra_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    global $user_level;
    if ($user_level >= 9) {
        update_user_meta($user_id, 'afiliado_de', $_POST['afiliado_de']);
        update_user_meta($user_id, 'invitado_de', $_POST['invitado_de']);
    }
    //var_dump($_POST);
    update_user_meta($user_id, 'ml_misdatos', $_POST['ml_datos']);
}

add_action('user_register', 'myplugin_user_register');

function myplugin_user_register($user_id) {
    global $user_level;
    if ($user_level >= 9) {
        update_user_meta($user_id, 'afiliado_de', $_POST['afiliado_de']);
        update_user_meta($user_id, 'invitado_de', $_POST['invitado_de']);
    }
    update_user_meta($user_id, 'ml_misdatos', $_POST['ml_datos']);
}

function count_users_per_meta($meta_key, $meta_value) {
    global $wpdb;
    $user_meta_query = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->usermeta WHERE meta_key='$meta_key' AND meta_value='$meta_value'", ''));
    return number_format_i18n($user_meta_query);
}
?>
<?php

function registration_form($username, $password, $email, $website, $first_name, $last_name, $nickname, $bio) {
    session_start();
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
                <?php if (isset($_SESSION['invitado'])) { ?>
                    <input type="text" readonly="readonly" name="invitado" value="<?= $_SESSION['invitado'] ?>" id="invitado" placeholder="Ejemplo: 15" class="form-control">     
                <?php } else { ?>
                    <input type="text" name="invitado" value="" id="invitado" placeholder="Ejemplo: 15" class="form-control">     
                <?php } ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Terminos y condiciones</label>
            <div class="col-sm-10">
                <input type="checkbox" name="terminos_y_condiciones" value="yes"/> Acepto <a target="_blanck" href="/terminos-y-condiciones">terminos y condiciones</a> de uso. <a target="_blank" href="/politica-de-privacidad">Politica de privacidad</a>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" name="submit" value="Inscribirme" id="registro" class="btn btn-primary">  
            </div>
        </div>
    </form>
    <?php
}

function registration_validation($username, $password, $email, $website, $first_name, $last_name, $nickname, $bio, $invitado, $tyc) {

    global $reg_errors;
    $reg_errors = new WP_Error;
    if (empty($username) || empty($password) || empty($email)) {
        $reg_errors->add('field', 'Required form field is missing');
    }
    if (4 > strlen($username)) {
        $reg_errors->add('username_length', 'el usuario es muy corto, se requieres minimo 4 letras');
    }
    if (username_exists($username))
        $reg_errors->add('user_name', 'El usuario ingresado ya existe, intenta con otro');
    if (!validate_username($username)) {
        $reg_errors->add('username_invalid', 'El usuario ingresado no es vvalido');
    }
    if (5 > strlen($password)) {
        $reg_errors->add('password', 'La contraseña debe tener mas de 5 caracteres');
    }
    if (!is_email($email)) {
        $reg_errors->add('email_invalid', 'el email no es un email valido');
    }
    if (email_exists($email)) {
        $reg_errors->add('email', 'Este email ya esta registrado');
    }
    if (!empty($website)) {
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $reg_errors->add('website', 'El sitio web no es una URL Valida');
        }
    }
    if ($invitado && is_numeric($invitado)) {
        $user_exists = get_user_by('id', $invitado);
        if (!$user_exists) {
            $reg_errors->add('invitado_no_existe', 'El Id de la persona que invito no existe');
        }
    }
    if (!$tyc) {
        if (!$user_exists) {
            $reg_errors->add('terminos_y_condiciones', 'Debe de aceptar los terminos y condiciones para registrarse en esta pagina');
        }
    }
    if (is_wp_error($reg_errors)) {

        foreach ($reg_errors->get_error_messages() as $error) {
            ?>
            <div class="alert alert-danger" role="alert">
                <strong>ERROR! </strong> <?= $error ?>
            </div>
            <?php
        }
    }
}

function complete_registration($invitado, $datos) {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
    if (1 > count($reg_errors->get_error_messages())) {
        session_start();
        $userdata = array(
            'user_login' => $username,
            'user_email' => $email,
            'user_pass' => $password,
            'user_url' => $website,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'nickname' => $nickname,
            'description' => $bio,
        );
        $user = wp_insert_user($userdata);
        if ($user) {
            $_SESSION['invitado'] = NULL;
            update_user_meta($user, 'afiliado_de', invitado_check($invitado));
            update_user_meta($user, 'invitado_de', $invitado);
            update_user_meta($user, 'ml_misdatos', $datos);
        }
        ?>
        <div class="alert alert-success" role="alert">
            <strong>Correcto!</strong> Ahora puedes ingresar a tu cuenta con el usuario <?= $username ?> y tu contraseña elegida.
        </div>
        <?php
    }
}

function custom_registration_function() {
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
    registration_form(
            $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio
    );
}

// Register a new shortcode: [cr_custom_registration]
add_shortcode('cr_custom_registration', 'custom_registration_shortcode');

// The callback function that will replace [book]
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}

function invitado_check($id) {
    if (!$id || !is_numeric($id)) {
        $afiliados = check_afiliados(2);
        $id = 2;
    } else {
        $afiliados = check_afiliados($id);
    }
    if ($afiliados) {
        return (int) $id;
    } else {
        $users_afi[] = get_users(array('meta_key' => 'afiliado_de', 'meta_value' => $id));
        $again = TRUE;
        do {
            foreach ($users_afi as $final) {
                $users_afi = NULL;
                foreach ($final as $afi) {
                    $check_user = check_afiliados($afi->ID);
                    if ($check_user) {
                        return $afi->ID;
                    } else {
                        $users_afi[] = get_users(array('meta_key' => 'afiliado_de', 'meta_value' => $afi->ID));
                    }
                }
            }
        } while ($again);
    }
}

function check_afiliados($id) {
    $afiliados = count_users_per_meta('afiliado_de', $id);
    if ($afiliados < 2) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function ver_red_completa($id) {
    $afiliados = get_users(array(
        'meta_key' => 'afiliado_de',
        'meta_value' => $id
    ));
    $users_count = 0;
    foreach ($afiliados as $afi) {
        $users_count++;
        ?>
        <?php
        $afiliados2 = get_users(array(
            'meta_key' => 'afiliado_de',
            'meta_value' => $afi->ID
        ));
        foreach ($afiliados2 as $afi2) {
            $users_count++;
        }
    }
    return $users_count;
}

function red_completa_boton($id, $nivel) {
    $total_pagos = get_user_meta($id, 'pago-' . $nivel);
    //var_dump($total_pagos);
    if (!$total_pagos) {
        return '<button class="btn confirmar_pago" id="confirmar_pago" data-nivel="' . $nivel . '" data-id="' . $id . '">Confirmar Pago de Usuario</button>';
    } else {
        return false;
    }
}

function my_enqueue() {
    // wp_register_script('custom_functions', get_template_directory_uri() . '/library/js/bootstrap.min.js', array('jquery'), '1.2');
    wp_enqueue_script('custom_functions', get_template_directory_uri() . '/js/custom_functions.js');
}

add_action('admin_enqueue_scripts', 'my_enqueue');

add_action('wp_ajax_confirmar_pago_usuario', 'pago_confirm');

function pago_confirm() {
    if ($_POST) {
        $total_pagos = get_user_meta($_POST['id'], 'pago-' . $_POST['nivel']);
        update_user_meta($_POST['id'], 'pago-' . $_POST['nivel'], 'yes');
    }
    die();
}
?>
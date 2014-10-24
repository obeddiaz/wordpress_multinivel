<?php
add_filter('manage_users_columns', 'pippin_add_user_id_column');

function pippin_add_user_id_column($columns) {
    $columns['user_id'] = '# Ususario';
    $columns['cant_inv'] = '# Invitados';
    $columns['cant_afi'] = '# Afiliados';
    $columns['afiliado_de'] = 'Afiliado de';
    $columns['invitado_de'] = 'Invitado de';

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
    //var_dump($afiliado);
    ?>
    <h3><?php _e("Informacion de Afiliado", "blank"); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="invitado_de"><?php _e("Invitado de"); ?></label></th>
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
    </table>
    <?php
}

add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');

function save_extra_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    update_user_meta($user_id, 'afiliado_de', $_POST['afiliado_de']);
    update_user_meta($user_id, 'invitado_de', $_POST['invitado_de']);
}

add_action('user_register', 'myplugin_user_register');

function myplugin_user_register($user_id) {
    var_dump($_POST);
    update_user_meta($user_id, 'afiliado_de', $_POST['afiliado_de']);
    update_user_meta($user_id, 'invitado_de', $_POST['invitado_de']);
}

function count_users_per_meta($meta_key, $meta_value) {
    global $wpdb;
    $user_meta_query = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->usermeta WHERE meta_key='$meta_key' AND meta_value='$meta_value'",''));
    return number_format_i18n($user_meta_query);
}
?>
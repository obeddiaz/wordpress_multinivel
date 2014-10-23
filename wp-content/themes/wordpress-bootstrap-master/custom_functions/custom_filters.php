<?php
add_filter('manage_users_columns', 'pippin_add_user_id_column');

function pippin_add_user_id_column($columns) {
    $columns['user_id'] = 'ID de Usuario';
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
        $afiliado=get_user_meta($user_id, 'afiliado_de');
        $userafi=get_userdata($afiliado[0]);
        return $userafi->user_login;
    }
    if ('invitado_de' == $column_name) {
        $invitado=get_user_meta($user_id, 'invitado_de');
        $userinv=get_userdata($invitado[0]);
        return $userinv->user_login;
    }
    return $value;
}

add_action('user_new_form', function( $type ) {
    if ('add-new-user' !== $type) {
        return;
    }
    $blogusers = get_users();
    var_dump($blogusers);
    ?>
    <table class="form-table">
        <tbody>
            <tr class="form-field form-required">
                <th scope="row"><label for="user_login">Invitado de </label></th>
                <td><select name="invitado_de">
                        <?php
                        foreach ($blogusers as $user) {
                            echo '<option value="' . $user->ID . '">' . $user->user_login . '</option>';
                            //var_dump($user->user_login);
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr class="form-field form-required">
                <th scope="row"><label for="user_login">Afiliado de </label></th>
                <td><select name="afiliado_de">
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

add_action('user_profile_update_errors', function( $data ) {
    if (is_wp_error($data->errors) && !empty($data->errors)) {
        return;
    }
//    $userdata = array(
//        'user_login' => 'login_name',
//        'user_url' => $website,
//        'user_pass' => NULL  // When creating an user, `user_pass` is expected.
//    );

    $user_id = wp_insert_user($_POST);
    if (!is_wp_error($user_id)) {
        update_user_meta( $user_id, 'invitado_de', $_POST['invitado_de'] );
        update_user_meta( $user_id, 'afiliado_de', $_POST['afiliado_de'] );
        echo "Usuario creado : " . $user_id;
    }else{
        echo "Usuario incorrecto";
    }
    # Do your thing with $_POST['custom_user_field'] 
    wp_die(sprintf('<pre>%s</pre>', print_r($_POST, true)));
});
?>
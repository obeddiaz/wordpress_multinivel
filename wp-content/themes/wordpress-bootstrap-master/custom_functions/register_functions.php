<?php

function user_registration_process() {
    session_start();
    if (is_numeric($_GET['userinv']) && !is_user_logged_in()) {
        $_SESSION['invitado'] = $_GET['userinv'];
        wp_redirect(home_url('/register-form'));
        exit();
    }
}

add_action('init', 'user_registration_process');
?>
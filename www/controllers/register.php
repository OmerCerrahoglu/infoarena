<?php

require_once(IA_ROOT_DIR."common/db/user.php");
require_once(IA_ROOT_DIR."common/db/smf.php");
require_once(IA_ROOT_DIR."common/external_libs/recaptchalib.php");
require_once(IA_ROOT_DIR."www/controllers/account_validator.php");

function controller_register() {
    $submit = request_is_post();

    // Initialize view parameters.
    // form data goes in data.
    // form errors go in errors.
    // data and errors use the same names.
    $view = array();
    $data = array();
    $errors = array();

    if ($submit) {
        // user submitted registration form. Process it

        // Get data from form an validate it.
        $data['username'] = trim(request('username'));
        $data['password'] = request('password');
        $data['password2'] = request('password2');
        $data['full_name'] = trim(request('full_name'));
        $data['email'] = trim(request('email'));
        $data['newsletter'] = (request('newsletter') ? 1 : 0);
        $data['tnc'] = (request('tnc') ? 1 : 0);

        if(!IA_DEVELOPMENT_MODE) {
            $data['recaptcha_challenge_field'] = request('recaptcha_challenge_field');
            $data['recaptcha_response_field'] = request('recaptcha_response_field');
        }

        $errors = validate_register_data($data);

        // 2. process
        if (!$errors) {
            // create database entry for user
            $user = user_init();
            $user['username'] = $data['username'];
            $user['password'] = user_hash_password($data['password'], $data['username']);
            $user['full_name'] = $data['full_name'];
            $user['email'] = $data['email'];
            $user['newsletter'] = $data['newsletter'];

            // There are no acceptable errors in user_create.
            user_create($user);
            flash("Felicitari! Contul a fost creat. Acum te poti "
                  ."autentifica.");
            redirect(url_login());
        } else {
            flash_error('Am intalnit probleme. Verifica datele introduse.');
        }
    } else {
        // form is displayed for the first time. Fill in default values.
        $data['newsletter'] = 1;
        $data['tnc'] = 1;
    }
    
    if(!IA_DEVELOPMENT_MODE) {
        $view['captcha'] = recaptcha_get_html(IA_CAPTCHA_PUBLIC_KEY);
    }

    // attach form is displayed for the first time or a validation error occured
    $view['title'] = 'Inregistreaza-te!';
    $view['page_name'] = 'register';
    $view['form_errors'] = $errors;
    $view['form_values'] = $data;
    $view['topnav_select'] = 'register';
    $view['action'] = 'register';
    $view['no_sidebar_login'] = true;
    execute_view_die('views/register.php', $view);
}

?>

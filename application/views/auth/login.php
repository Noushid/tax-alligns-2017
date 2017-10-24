<!doctype html>
<html lang="en" ng-app="myApp" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>login - Accounts & TaxAlliance</title>
    <style>

        /* 'Open Sans' font from Google Fonts */
        @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);

        body {
            background: #456;
            font-family: 'Open Sans', sans-serif;
        }

        .login {
            width: 400px;
            margin: 16px auto;
            font-size: 16px;
        }

        /* Reset top and bottom margins from certain elements */
        .login-header,
        .login p {
            margin-top: 0;
            margin-bottom: 0;
        }

        /* The triangle form is achieved by a CSS hack */
        .login-triangle {
            width: 0;
            margin-right: auto;
            margin-left: auto;
            border: 12px solid transparent;
            border-bottom-color: #28d;
        }

        .login-header {
            background: #28d;
            padding: 20px;
            font-size: 1.4em;
            font-weight: normal;
            text-align: center;
            text-transform: uppercase;
            color: #fff;
        }

        .login-container {
            background: #ebebeb;
            padding: 12px;
        }

        /* Every row inside .login-container is defined with p tags */
        .login p {
            padding: 12px;
        }

        .login input {
            box-sizing: border-box;
            display: block;
            width: 100%;
            border-width: 1px;
            border-style: solid;
            padding: 16px;
            outline: 0;
            font-family: inherit;
            font-size: 0.95em;
        }

        .login input[type="email"],
        .login input[type="password"] {
            background: #fff;
            border-color: #bbb;
            color: #555;
        }

        /* Text fields' focus effect */
        .login input[type="email"]:focus,
        .login input[type="password"]:focus {
            border-color: #888;
        }

        .login input[type="submit"] {
            background: #28d;
            border-color: transparent;
            color: #fff;
            cursor: pointer;
        }

        .login input[type="submit"]:hover {
            background: #17c;
        }

        /* Buttons' focus effect */
        .login input[type="submit"]:focus {
            border-color: #05a;
        }
    </style>
</head>
<!--<body ng-controller="adminController">-->
<body>

<div class="login">
    <div class="login-triangle"></div>

    <h2 class="login-header"><?php echo lang('login_heading');?></h2>
    <!--    <p>--><?php //echo lang('login_subheading');?><!--</p>-->


    <?php echo form_open("auth/login",['class' => 'login-container']);?>
    <div id="infoMessage"><?php echo $message;?></div>

    <p>
        <!--        --><?php //echo lang('login_identity_label', 'identity');?>
        <?php echo form_input($identity);?>
    </p>

    <p>
        <!--        --><?php //echo lang('login_password_label', 'password');?>
        <?php echo form_input($password);?>
    </p>

    <p>
        <?php echo lang('login_remember_label', 'remember');?>
        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
    </p>


    <p><?php echo form_submit('submit', lang('login_submit_btn'));?></p>

    <?php echo form_close();?>

    <p><a href="<?php echo base_url('forgot-password')?>"><?php echo lang('login_forgot_password');?></a></p>
</div>

</body>
</html>
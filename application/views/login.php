<!doctype html>
<html lang="en" ng-app="myApp">
<head>
    <meta charset="UTF-8">
    <title>Accounts & TaxAlliance -login</title>
    <script src="<?php echo public_url() . 'adm/assets/js/angular-bootstrap.min.js' ?>"></script>
    <script src="<?php echo public_url() . 'adm/assets/js/angularApp.min.js' ?>"></script>
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
<body ng-controller="adminController">

<div class="login">
    <div class="login-triangle"></div>

    <h2 class="login-header">Log in</h2>

    <form class="login-container" name="loginform" method="POST" ng-submit="login()">
        <p><input type="text" placeholder="Username" name="username" ng-model="user.username"></p>
        <p><input type="password" placeholder="Password" name="password" ng-model="user.password"></p>
        <p><input type="submit" value="Log in"></p>
        <div class="error" ng-show="showerror">
            {{error.error}}
        </div>
    </form>
</div>

</body>
</html>
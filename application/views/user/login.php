<!-- <div class="row">
    <h1>Login</h1>
    <div class="col-lg-4 col-lg-offset-4">
        <div class="login-message"></div>
        <?php echo form_open('user/login',array('class'=>'login-form form-horizontal'));?>
        <div id="infoMessage"><?php echo $message;?></div>
        <div class="form-group">
            <?php echo form_label('Email','Email');?>
            <div class="username_error"></div>
            <?php echo form_input('email','','class="form-control" id="email"');?>
        </div>
        <div class="form-group">
            <?php echo form_label('Password','password');?>
            <div class="password_error"></div>
            <?php echo form_password('password','','class="form-control" id="password"');?>
        </div>
        <div class="form-group">
            <label>
                <?php echo form_checkbox('remember','1',FALSE);?> Remember me
            </label>
        </div>
        <?php echo form_submit('submit', 'Log in', 'class="btn btn-primary btn-lg btn-block" id="login-button"');?>
        <?php echo form_close();?>
    </div>
</div> -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <meta name="description" content="ACCOUNTS AND TAX ALLIANCE (A&T) is a growing accounts and tax service firm. We are aimed to assist business man in setting and maintaining a venture with strong accounting and taxation department. A&T is ready for GST accounting and filing, because we are skilled and flexible to adopt any big changes in statutory and government rules and policies. We are simplifying the areas of complication. Our services are highly professional at an affordable cost. ">
    <meta name="keywords" content="gst return filing, gst news, gst updates, gst rates, ACCOUNTS AND TAX ALLIANCE, kerala gst services">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title><?php echo ucfirst($current)?> | Accounts & TaxAlliance</title>
    <meta name="author" content="psybotechnologies.com">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Bootstrap  -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>stylesheets/bootstrap.css" >
    <!-- Theme Style -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>stylesheets/style.css">
    <!-- Responsive -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>stylesheets/responsive.css">
    <!-- REVOLUTION LAYERS STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>revolution/css/layers.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>revolution/css/settings.css">
    <!-- Animation Style -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>stylesheets/animate.css">
    <!-- Favicon and touch icons  -->
    <link href="<?php echo base_url();?>images/icon/favicon.png" rel="shortcut icon">

</head>  

<body class="header-sticky">

    <div class="boxed">
        <div class="loader">
            <span class="loader1 block-loader"></span>
            <span class="loader2 block-loader"></span>
            <span class="loader3 block-loader"></span>
        </div>

        <section class="flat-row">
            <div class="flat-choose-us flat-news v1">
                <div class="flat-silder">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="company-news v1">
                                    <div class="title-section">
                                        <h4 class="title">Register Now</h4>
                                    </div>
                                    <div class="post-list">
                                        <ul class="list-us">
                                            <li class="style-1">
                                                <div class="num-list">
                                                    <p>1</p>
                                                </div>
                                                <div class="text-list">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                                </div>
                                            </li>

                                            <li class="style-2">
                                                <div class="num-list v2">
                                                    <p>2</p>
                                                </div>
                                                <div class="text-list">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                                </div>
                                            </li>

                                            <li class="style-3">
                                                <div class="num-list v3">
                                                    <p>3</p>
                                                </div>
                                                <div class="text-list">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="form-box">
                                        <form action="#" method="post" id="commentform-footer" class="comment-form" novalidate="">
                                            <fieldset class="style name-container">
                                                <label>Email or user ID</label>
                                                <input type="text" id="author-footer" class="tb-my-input" name="first_name" tabindex="1" value="" size="32" aria-required="true">
                                            </fieldset>

                                            <fieldset class="style name-container">
                                                <label>Password</label>
                                                <input type="password" id="author-footer" class="tb-my-input" name="last_name" tabindex="2" value="" size="32" aria-required="true">
                                            </fieldset>

                                            <fieldset class="style name-container">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" id="" class="tb-my-input" value="" tabindex="2">Remember me
                                                </label>
                                            </fieldset>

                                            <fieldset class="style name-container">
                                                <p class="">
                                                    <a href="#">I forgot my user ID or password</a><br />
                                                    New to Intuit? <a href="#">Create an account.</a>
                                                </p>
                                            </fieldset>

                                            <div class="submit-wrap">
                                                <button class="flat-button button-style ml-183"><i class="fa fa-lock" style="padding-right: 17px;"></i> Sign In</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Javascript -->
        <!-- Javascript -->
        <script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>javascript/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.easing.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.isotope.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>javascript/imagesloaded.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>javascript/jquery-waypoints.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>javascript/parallax.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>javascript/smoothscroll.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>javascript/jquery-countTo.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>javascript/owl.carousel.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.easypiechart.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.bxslider.js"></script>

         
        <script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.cookie.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>javascript/main.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.tweet.min.js"></script>

        <!-- Revolution Slider -->
        <script type="text/javascript" src="<?php echo base_url();?>revolution/js/jquery.themepunch.tools.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>revolution/js/jquery.themepunch.revolution.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>revolution/js/slider.js"></script>

        <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->    
        <script type="text/javascript" src="<?php echo base_url();?>revolution/js/extensions/revolution.extension.actions.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>revolution/js/extensions/revolution.extension.carousel.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>revolution/js/extensions/revolution.extension.migration.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>revolution/js/extensions/revolution.extension.navigation.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>revolution/js/extensions/revolution.extension.parallax.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>revolution/js/extensions/revolution.extension.video.min.js"></script>

        <script type="text/javascript">
            var myDiv = $('#tag');
            myDiv.text(myDiv.text().substring(0,280))
        </script>
        <script type="text/javascript">
            $(window).scroll(function() {

                var scroll = $(window).scrollTop();

                if (scroll >= 50) {
                    $(".portfolio-filter").addClass("fixed-msgbar");
                }
                if (scroll < 50) {
                    $(".portfolio-filter").removeClass("fixed-msgbar");
                }
            });
        </script>
    </div>
</body>
</html>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
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
    
        <div class="header-inner-pages">
            <div class="top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="flat-information">
                                <li class="phone">
                                    <a href="<?php echo base_url();?>#" title="Phone number"><i>Call us:  (+91) 9446 5000 44</i></a>
                                </li>
                                <li class="email">
                                    <a href="<?php echo base_url();?>#" title="Email address"><i>Email: info@accountsandtax.in</i></a>
                                </li>
                            </ul>
                            <div class="style-box text-right">
                                <ul class="flat-socials v1">
                                    <li class="facebook">
                                        <a href="<?php echo base_url();?>#"><i class="fa fa-facebook-f"></i></a>
                                    </li>
                                    <li class="twitter">
                                        <a href="<?php echo base_url();?>#"><i class="fa fa-twitter"></i></a>
                                    </li>
                                    <li class="instagram">
                                        <a href="<?php echo base_url();?>#"><i class="fa fa-instagram"></i></a>
                                    </li>
                                    <li class="wifi">
                                        <a href="<?php echo base_url();?>#"><i class="fa fa-wifi"></i></a>
                                    </li>
                                </ul>
                                <div onclick="document.location='contact'" class="question">
                                    <div>
                                        <i class="fa fa-question-circle-o"></i><p class="text">Have any questions</p>
                                    </div>
                                </div>
                                <div onclick="document.location='home#call'" class="box-text text-right">
                                    <p>Get An Appointment</p>
                                </div>   
                            </div>
                        </div><!-- col-md-12 -->
                    </div><!-- row -->
                </div><!-- container -->
            </div><!-- Top -->    
        </div><!-- header-inner-pages -->

        <!-- Wrap-slide -->
        <div class="wrap-slider">
            <!-- Header -->            
            <header id="header" class="header style-color clearfix">
                <div class="container">
                    <div class="header-wrap clearfix">
                        <div id="logo" class="logo">
                            <a href="<?php echo base_url();?>index.html" rel="home">
                                <img src="<?php echo base_url();?>images/logo.png" alt="image">
                            </a>
                        </div><!-- /.logo -->

                        <div class="nav-wrap">
                            <div class="btn-menu">
                                <span></span>
                            </div><!-- //mobile menu button -->

                            <nav id="mainnav" class="mainnav">
                                <ul class="menu"> 
                                    <li class="<?php echo ($current == 'Home' ? 'home' : '') ?>"><a href="<?php echo base_url();?>home">Home</a></li>
                                    <li class="<?php echo ($current == 'About Us' ? 'home' : '') ?>"><a href="<?php echo base_url();?>about">About Us</a></li>
                                    <li class="<?php echo ($current == 'Our Services' ? 'home' : '') ?>"><a href="<?php echo base_url();?>services">Our Services</a></li>
                                    <li class="<?php echo ($current == 'GST' ? 'home' : '') ?>"><a href="<?php echo base_url();?>GST">GST</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo base_url();?>WhatIsGST">What is GST</a></li>
                                            <li><a href="<?php echo base_url();?>GSTfiling">GST Filing</a></li>
                                            <li><a href="<?php echo base_url();?>GSTaccounting">GST Accounting</a>
                                                <ul class="submenu">
                                                    <li><a href="<?php echo base_url();?>GSTaccounting#tally">In Tally ERP</a></li>
                                                    <li><a href="<?php echo base_url();?>GSTaccounting#mallu">In Malayalam</a></li>
                                                    <li><a href="<?php echo base_url();?>GSTaccounting#council">GST Council</a></li>
                                                </ul><!-- /.submenu -->
                                            </li>
                                            <li><a href="<?php echo base_url();?>GSTinvoice">GST Invoice</a></li>
                                        </ul><!-- /.submenu -->
                                    </li>
                                    <li class="<?php echo ($current == 'IT' ? 'home' : '') ?>"><a href="<?php echo base_url();?>#">Income Tax</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo base_url();?>ITreturns">IT Returns</a></li>
                                            <li><a href="<?php echo base_url();?>TDS">TDS</a></li>
                                        </ul><!-- /.submenu -->
                                    </li>
                                    <li class="<?php echo ($current == 'Our Blog' ? 'home' : '') ?>"><a href="<?php echo base_url();?>blog">latest updates</a></li>
                                    <li class="<?php echo ($current == 'Contact Us' ? 'home' : '') ?>"><a href="<?php echo base_url();?>contact">Contact Us</a></li>
                                </ul><!-- /.menu -->
                            </nav><!-- /.mainnav -->
                        </div><!-- /.nav-wrap -->
                    </div><!-- /.header-wrap --> 
                </div>
            </header><!-- /.header -->
        </div> <!-- /.wrap-slider -->
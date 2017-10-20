<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <meta name="keywords" content="Internal auditing, Accounting services, GST filing, Income Tax filing, accounting outsourcing, business consulting, ERP and billing systems, project reports" />
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
    <script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.min.js"></script>

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
                                        <a href="https://www.facebook.com/AccountsAndTaxServices" target="_blank"><i class="fa fa-facebook-f"></i></a>
                                    </li>
                                </ul>
                                <?php 
                                if (!$this->ion_auth->logged_in() and !$this->ion_auth->is_admin()) {
                                    ?>
                                    <div onclick="document.location='<?php echo base_url('login'); ?>'"
                                         class="question">
                                        <div class="thumb">
                                            <i class="fa fa-sign-in"></i>

                                            <p class="text">Login Now</p>
                                        </div>
                                    </div>
                                <?php
                                }elseif($this->ion_auth->logged_in() and $this->ion_auth->is_admin()){ ?>
                                <div onclick="document.location='<?php echo base_url('login'); ?>'"
                                         class="question">
                                        <div class="thumb">
                                            <i class="fa fa-sign-in"></i>

                                            <p class="text">Login Now</p>
                                        </div>
                                    </div>
                                <?php } ?>
                               <?php if ($this->ion_auth->logged_in() and !$this->ion_auth->is_admin($this->session->userdata('user_id'))) {
                                   $user = $this->user->where('id', $this->session->userdata('user_id'))->get();
                                   ?>
                                   <div type="button" data-toggle="dropdown" class="box-text text-right">
                                       <p><i class="fa fa-user mr10"></i> <?php echo $user->first_name . ' ' . $user->last_name;?></p>
                                   </div>
                                   <ul class="dropdown-menu">
                                       <li><a href="<?php echo base_url('practice')?>"><i class="fa fa-envelope-o mr10"></i>Message Box</a></li>
                                       <li><a href="#"><i class="fa fa-cog mr10"></i>Settings</a></li>
                                       <li><a href="<?php echo base_url('logout')?>"><i class="fa fa-sign-out mr10"></i>Logout</a></li>
                                   </ul>
                               <?php
                               }
                                ?>
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
                            <a href="<?php echo base_url();?>home" rel="home">
                                <img src="<?php echo base_url();?>images/logo.png" alt="image">
                            </a>
                        </div><!-- /.logo -->

                        <div class="nav-wrap">
                            <div class="btn-menu">
                                <span></span>
                            </div><!-- //mobile menu button -->

                            <nav id="mainnav" class="mainnav">
                                <ul class="menu"> 
                                    <li class="<?php echo ($current == 'ABOUT US' ? 'home' : '') ?>"><a href="<?php echo base_url();?>about">About Us</a></li>
                                    <li class="<?php echo ($current == 'GST' ? 'home' : '') ?>"><a href="#">gst</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo base_url();?>gstbasics">GST BASICS</a></li>
                                            <li><a href="<?php echo base_url();?>invoiceBillofSupply">INVOICE & BILL OF SUPPLY</a></li>
                                            <li><a href="<?php echo base_url();?>compositionScheme">COMPOSITION SCHEME</a></li>
                                            <li><a href="<?php echo base_url();?>reverseChargeMechanism">REVERSE CHARGE MECHANISM</a></li>
                                            <li><a href="<?php echo base_url();?>worksContract">WORKS CONTRACT</a></li>
                                            <li><a href="<?php echo base_url();?>exportUnderGst">EXPORT UNDER GST</a></li>
                                            <li><a href="<?php echo base_url();?>eWayBill">E WAY BILL</a></li>
                                            <li><a href="<?php echo base_url();?>gstReturnFiling">GST RETURN FILING</a></li>
                                        </ul>
                                    </li>
                                    <li class="<?php echo ($current == 'ACCOUNTING' ? 'home' : '') ?>"><a href="#">ACCOUNTING</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo base_url();?>accountingOutsourcing">OUTSOURCING</a></li>
                                            <li><a>ACCOUTING SERVICES</a>
                                                <ul class="submenu mym">
                                                    <li><a href="<?php echo base_url();?>runningAndStartupBusiness">RUNNING AND STARTUP BUSINESS</a></li>
                                                    <li><a href="<?php echo base_url();?>onsiteAndOnlineAccounting">ON-SITE AND ONLINE ACCOUNTING</a></li>
                                                    <li><a href="<?php echo base_url();?>systemImplimentationInAccounting">SYSTEM IMPLEMENTATION IN ACCOUNTING</a></li>
                                                    <li><a href="<?php echo base_url();?>manualToComputerisedAccounting">MANUAL TO COMPUTERISED ACCOUNTING</a></li>
                                                    <li><a href="<?php echo base_url();?>accountFromIncompleteData">ACCOUNTS FROM INCOMPLETE DATA</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>                                
                                    <li class="<?php echo ($current == 'INCOME TAX' ? 'home' : '') ?>"><a href="#">income tax</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo base_url();?>itBasics">IT BASICS</a></li>
                                            <li><a href="<?php echo base_url();?>itRates">INCOME TAX RATES</a></li>
                                            <li><a href="<?php echo base_url();?>compulsoryaudit">COMPULSORY AUDIT</a></li>
                                            <li><a href="<?php echo base_url();?>presuptiveTaxation">PRESUMPTIVE TAXATION</a></li>
                                            <li><a href="<?php echo base_url();?>itReturnsFiling">IT RETURNS-FILING</a></li>
                                            <li><a href="<?php echo base_url();?>cashTransaction">CASH TRANSACTION</a></li>
                                            <li><a href="<?php echo base_url();?>tdsFiling">TDS-FILING</a></li>
                                            <li><a href="<?php echo base_url();?>tcs">TCS</a></li>
                                        </ul>
                                    </li>  
                                    <li class="<?php echo ($current == 'SERVICES' ? 'home' : '') ?>"><a href="#">SERVICES</a>
                                        <ul class="submenu"> 
                                            <li><a>START A BUSINESS</a>
                                                <ul class="submenu"> 
                                                    <li><a href="<?php echo base_url();?>propretorship">PROPRIETORSHIP</a></li>
                                                    <li><a href="<?php echo base_url();?>partnership">PARTNERSHIP</a></li>
                                                    <li><a href="<?php echo base_url();?>opc">ONE PERSON COMPANY</a></li>
                                                    <li><a href="<?php echo base_url();?>llp">LIMITED LIABILITY PARTNERSHIP</a></li>
                                                    <li><a href="<?php echo base_url();?>pvtLmtd">PRIVATE LIMITED COMPANY</a></li>
                                                    <li><a href="<?php echo base_url();?>ltd">PUBLIC LIMITED COMPANY</a></li>
                                                    <li><a href="<?php echo base_url();?>producerCompany">PRODUCER COMPANY</a></li>
                                                    <li><a href="<?php echo base_url();?>indianSubsidiaryCo">INDIAN SUBSIDIARY COMPANY</a></li>
                                                </ul>
                                            </li>
                                            <li><a>DOCUMENTATION</a>
                                                <ul class="submenu"> 
                                                    <li><a href="<?php echo base_url();?>partnershipDeed">PARTNERSHIP DEED</a></li>
                                                    <li><a href="<?php echo base_url();?>firmRegistration">FIRM REGISTRATION</a></li>
                                                    <li><a href="<?php echo base_url();?>trustRegistration">TRUST REGISTRATION</a></li>
                                                    <li><a href="<?php echo base_url();?>wakfBoardRegistartion">WAKF BOARD REGISTRATION</a></li>
                                                    <li><a href="<?php echo base_url();?>projectReport">PROJECT REPORT</a></li>
                                                    <li><a href="<?php echo base_url();?>iso">ISO</a></li>
                                                    <li><a href="<?php echo base_url();?>trademarkAndLogo">TRADEMARK & LOGO</a></li>
                                                </ul>
                                            </li>
                                            <li><a>MANAGEMENT CONSULTING</a>
                                                <ul class="submenu"> 
                                                    <li><a href="<?php echo base_url();?>motivationalProgram">MOTIVATIONAL PROGRAMMS</a></li>
                                                    <li><a href="<?php echo base_url();?>marketingstrategy">MARKETING STRATEGY</a></li>
                                                    <li><a href="<?php echo base_url();?>hierarchyInManagement">HIERARCHY IN MANAGEMENT</a></li>
                                                    <li><a href="<?php echo base_url();?>staffProgramms">STAFF PROGRAMMS</a></li>
                                                </ul>
                                            </li>
                                            <!-- <li><a href="<?php echo base_url();?>#">REGISTRATION</a>
                                                <ul class="submenu"> 
                                                    <li><a href="<?php echo base_url();?>gstRegisration">GST REGISTRATION</a></li>
                                                    <li><a href="<?php echo base_url();?>tanRegisration">TAN REGISTRATION</a></li>
                                                    <li><a href="<?php echo base_url();?>panCard">PAN CARD</a></li>
                                                    <li><a href="<?php echo base_url();?>dsc">DSC</a></li>
                                                    <li><a href="<?php echo base_url();?>iec">IMPORT EXPORT LICENCE (IEC)</a></li>
                                                </ul>
                                            </li> -->
                                        </ul>
                                    </li>
                                    <li class="<?php echo ($current == 'BLOG' ? 'home' : '') ?>"><a href="<?php echo base_url();?>blog">Blog</a></li>
                                    <li class="<?php echo ($current == 'CONTACT' ? 'home' : '') ?>"><a href="<?php echo base_url();?>contact">Contact</a></li>
                                    <li class="<?php echo ($current == 'GCC CLIENTS' ? 'home' : '') ?>"><a href="#">GCC Clients</a>
                                        <ul class="submenu"> 
                                            <li><a>UAE</a>
                                                <ul class="submenu"> 
                                                    <li><a>SERVICES</a>
                                                        <ul class="submenu"> 
                                                            <li><a href="<?php echo base_url();?>uaeServices">ACCOUNTING SERVICES</a></li>
                                                            <li><a href="<?php echo base_url();?>erp">ERP SERVICES</a></li>
                                                            <li><a href="<?php echo base_url();?>businessFormation">BUSINESS FORMATION-UAE</a></li>
                                                            <li><a href="<?php echo base_url();?>businessLicense">BUSINESS LICENSE-UAE</a></li>
                                                            <li><a href="<?php echo base_url();?>exciseTax">UAE EXCISE TAX</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a>VAT UAE</a>
                                                        <ul class="submenu"> 
                                                            <li><a href="<?php echo base_url();?>uaeVat">WHAT IS VAT</a></li>
                                                            <li><a href="<?php echo base_url();?>vatRegistration">VAT Registration</a></li>
                                                            <li><a href="<?php echo base_url();?>vatExemption">VAT EXEMPTION & ZERO RATE</a></li>
                                                            <li><a href="<?php echo base_url();?>vatFiling">VAT FILING & INPUT VAT</a></li>
                                                            <li><a href="<?php echo base_url();?>vatDocumentation">VAT DOCUMENTATION</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a>KSA</a>
                                                <ul class="submenu"> 
                                                    <li><a>SERVICES</a>
                                                        <ul class="submenu"> 
                                                            <li><a href="<?php echo base_url();?>ksaServices">ACCOUNTING SERVICES</a></li>
                                                            <li><a href="<?php echo base_url();?>ksaErp">ERP SERVICES</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="<?php echo base_url();?>ksaVat">KSA VAT</a></li>
                                                    <li><a href="<?php echo base_url();?>ksaIncomeTax">KSA-INCOME TAX & ZAKAT</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="<?php echo base_url();?>gccAbout">ABOUT US</a></li>
                                            <li><a href="<?php echo base_url();?>gccVat">WHY VAT IN GCC</a></li>
                                        </ul>
                                    </li>
                                     <?php
                                    if ($this->ion_auth->logged_in() and !$this->ion_auth->is_admin($this->session->userdata('user_id'))) {
                                        ?>
                                        <li class="<?php echo($current == 'practice' ? 'home' : '') ?>"><a
                                                href="<?php echo base_url(); ?>practice">PRACTICE</a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </nav>


                        </div>
                    </div> 
                </div>
            </header>
        </div>

<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<section class="flat-row my-pad">
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

<!--                            <div class="form-box">-->
<!--                                --><?php
//                                echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
//                                ?>
<!--                                <h1>Register</h1>-->
<!--                                --><?php
//                                echo form_open('User/create_user');
//                                echo form_label('First name:','first_name').'<br />';
//                                echo form_error('first_name');
//                                echo form_input('first_name',set_value('first_name')).'<br />';
//                                echo form_label('Last name:','last_name').'<br />';
//                                echo form_error('last_name');
//                                echo form_input('last_name',set_value('last_name')).'<br />';
//                                //    echo form_label('Username:','username').'<br />';
//                                //    echo form_error('username');
//                                //    echo form_input('username',set_value('username')).'<br />';
//                                echo form_label('Email:','email').'<br />';
//                                echo form_error('email');
//                                echo form_input('email',set_value('email')).'<br />';
//                                echo form_label('Password:', 'password').'<br />';
//                                echo form_error('password');
//                                echo form_password('password').'<br />';
//                                echo form_label('Confirm password:', 'confirm_password').'<br />';
//                                echo form_error('confirm_password');
//                                echo form_password('confirm_password').'<br /><br />';
//                                echo form_submit('register','Register');
//                                echo form_close();
//                                ?>
<!--                            </div>-->
                            <?php
                            echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
                            ?>
                            <div class="form-box">
                                <?php echo form_open(base_url('register'), ['id' => 'commentform-footer', 'class' => 'comment-form', 'nonvalidate' => '"']);?>
                                    <fieldset class="style name-container">
                                        <input type="text" id="author-footer" required placeholder="First name*" class="tb-my-input" name="first_name" tabindex="1" size="32" aria-required="true" value="<?php echo set_value('first_name')?>">
                                        <?php echo form_error('first_name');?>
                                    </fieldset>

                                    <fieldset class="style name-container">
                                        <input type="text" id="author-footer" placeholder="Last name*" class="tb-my-input" name="last_name" tabindex="2" size="32" aria-required="true" value="<?php echo set_value('last_name')?>">
                                        <?php echo form_error('last_name');?>
                                    </fieldset>

                                    <fieldset class="style email-container">
                                        <input type="email" id="email-footer" required placeholder="Your Email" class="tb-my-input" name="email" tabindex="3" size="32" aria-required="true" value="<?php echo set_value('email')?>">
                                        <?php echo form_error('email');?>
                                    </fieldset>

                                    <fieldset class="style phone-container">
                                        <input type="text" id="phone-footer" required placeholder="You phone number*" class="tb-my-input" name="phone" tabindex="4" size="32" aria-required="true" value="<?php echo set_value('phone')?>" pattern='^\+?\d{0,13}'>
                                        <?php echo form_error('phone');?>
                                    </fieldset>

                                    <fieldset class="style phone-container">
                                        <input type="password" id="phone-footer" required placeholder="Password*" class="tb-my-input" name="password" tabindex="5" size="32" aria-required="true">
                                        <?php echo form_error('password');?>
                                    </fieldset>
                                    <fieldset class="style phone-container">
                                        <input type="password" id="phone-footer" required placeholder="Confirm Password*" class="tb-my-input" name="confirm_password" tabindex="6" size="32" aria-required="true">
                                        <?php echo form_error('confirm_password');?>
                                    </fieldset>
                                    <div class="submit-wrap">
                                        <button class="flat-button button-style ml-183" type="submit">Register <i class="fa fa-chevron-right"></i></button>
                                    </div>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

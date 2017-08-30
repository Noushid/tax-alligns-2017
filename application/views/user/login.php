<div class="row">
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
</div>
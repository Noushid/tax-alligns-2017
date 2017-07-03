<div class="header">
    <h1 class="page-header">
        User Profile
    </h1>
    <ol class="breadcrumb">
        <li><a href="#dashboard">Home</a></li>
        <li><a href="#user-profile">user profile</a></li>
    </ol>
</div>

<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    User Profile
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <form class="form-horizontal" method="POST" ng-submit="changeProfile()">
                                <div class="form-group">
                                    <label for="" class="control-label col-lg-2">Username</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="username" ng-model="newuser.username" placeholder="New Username" required=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label col-lg-2">Current Password</label>
                                    <div class="col-lg-4">
                                        <!--For disable auto complete--><input type="text" style="display: none"/>
                                        <input type="password" class="form-control" name="curPassword" ng-model="newuser.curpassword" placeholder="Current Password" required="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label col-lg-2">New Password</label>
                                    <div class="col-lg-4">
                                        <input type="password" class="form-control" name="password" ng-model="newuser.password" placeholder="New Password" required="" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label col-lg-2">Confirm Password</label>
                                    <div class="col-lg-4">
                                        <input type="password" class="form-control" name="confirmPassword" ng-model="newuser.confirmpassword" ng-match="newuser.password" placeholder="Re-Type Password" required="" autocomplete="off"/>
                                    </div>
                                    <span ng-show="newuser.password != newuser.confirmpassword">Password do not match</span>
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary" ng-disabled="newuser.password != newuser.confirmpassword" type="submit">Save</button>
                                    <a href="#dashboard" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loading" ng-show="loading">
    <div id="loading-image">
        <img src="<?php echo public_url() . 'adm/assets/img/loading.gif' ?>" alt=""/>
        <h4>Please wait...</h4>
    </div>
</div>
<script type="text/ng-template" id="myModalContent.html">
    <div class="modal-header bg-success" style="border-radius: 5px">
        <h3 class="modal-title text-center" id="modal-title"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            Attention!</h3>
    </div>
    <div class="modal-body" id="modal-body">
        <div class="row">
            <div class="text-center">
                <p>{{items}}</p>
            </div>
        </div>
    </div>
    <div class="modal-footer text-center">
        <button class="btn btn-primary" type="button" ng-click="ok()">OK</button>
    </div>
</script>
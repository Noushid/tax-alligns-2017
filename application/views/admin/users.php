<div class="header">
    <h1 class="page-header">
        User <a href="" ng-click="newUser()" ng-show="showform != true"><i class="fa fa-plus" aria-hidden="true"></i></a>
        <a href="" ng-click="hideForm()" ng-show="showform != false"><i class="fa fa-minus" aria-hidden="true"></i></a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#dashboard">Home</a></li>
        <li><a href="#user">user</a></li>
    </ol>
</div>

<div id="page-inner">
    <!--ADD Form-->
    <div class="row" ng-show="showform">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add User
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <form class="form-horizontal" method="POST" ng-submit="addUser()">
                                <div class="form-group">
                                    <label for="" class="control-label col-lg-2">First name</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="first_name" class="form-control" ng-model="newuser.first_name" placeholder="First Name" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label col-lg-2">Last name</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="last_name" class="form-control" ng-model="newuser.last_name" placeholder="Last Name" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label col-lg-2">Email</label>
                                    <div class="col-lg-6">
                                        <input type="email" name="email" class="form-control" ng-model="newuser.email" placeholder="Email" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label col-lg-2">Phone</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="phone" class="form-control" ng-model="newuser.phone" placeholder="Phone"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Password</label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" ng-model="newuser.password" name="password" placeholder="Password required">
                                            <span class="input-group-btn">
                                                <button class="btn btn-block" type="button" ng-click="generatePassword()">Generate</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <div class="checkbox col-lg-offset-2">
                                        <label><input type="checkbox" ng-model="newuser.send_mail">Send details to registered email.</label>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <div class="col-lg- text-center">
                                        <button class="btn btn-primary" type="submit">Submit and send mail</button>
                                        <button class="btn btn-danger" type="button" ng-click="hideForm()">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--View User-->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                Result user list
            </div>
            <div class="panel-body">
                <div class="table-responsive" style="overflow-x:visible">
                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <div class="row" style="max-width: 100%;">
                            <div class="col-sm-6">
                                <div class="dataTables_length" id="dataTables-example_length">
                                    <label>
                                        <select name="dataTables-example_length" aria-controls="dataTables-example" class="form-control input-sm" ng-model="numPerPage"
                                                ng-options="num for num in paginations">{{num}}
                                        </select>
                                        records per page
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="dataTables-example_filter" class="dataTables_filter">
                                    <label>
                                        Search:
                                        <input class="form-control input-sm" aria-controls="dataTables-example" type="search" ng-model="search">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr dir-paginate="user in users | filter:search | limitTo:pageSize | itemsPerPage:numPerPage">
                                <td>{{$index+1}}</td>
                                <td>
                                    <a ng-click="open(user)" href="">{{user.first_name + '  ' + user.last_name}}</a>
                                </td>
                                <td>{{user.email}}</td>
                                <td>{{(user.active == 1 ? 'active' : 'Inactive')}}</td>
<!--                                <td>-->
<!--                                    <div  class="btn-group btn-group-xs" role="group">-->
<!--                                        <button type="button" class="btn btn-info" ng-click="editUser(user)">-->
<!--                                            <i class="fa fa-pencil"></i>-->
<!--                                        </button>-->
<!--                                        <button  type="button" class="btn btn-danger" confirmed-click="deleteUser(user)" ng-confirm-click="Would you like to delete this item?!">-->
<!--                                            <i class="fa fa-trash-o"></i>-->
<!--                                        </button>-->
<!--                                    </div>-->
<!--                                </td>-->
                                <td>
                                    <div class="btn-group" uib-dropdown>
                                        <button id="split-button" type="button" class="btn btn-danger">Action</button>
                                        <button type="button" class="btn btn-danger" uib-dropdown-toggle>
                                            <span class="caret"></span>
                                            <span class="sr-only">Split button!</span>
                                        </button>
                                        <ul class="dropdown-menu" uib-dropdown-menu role="menu" aria-labelledby="split-button">
                                            <li role="menuitem" ng-show="user.active == 0"><a confirmed-click="activateUser(user)" ng-confirm-click="Would you like to activate this user?!">active</a></li>
                                            <li role="menuitem" ng-show="user.active == 1"><a confirmed-click="deActivateUser(user)" ng-confirm-click="Would you like to De-Activate this user?!">De-activate</a></li>
                                            <li role="menuitem"><a confirmed-click="deleteUser(user)" ng-confirm-click="Would you like to Delete this user?!">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <dir-pagination-controls
                            max-size="10"
                            direction-links="true"
                            boundary-links="true">
                        </dir-pagination-controls>
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

    <script type="text/ng-template" id="userModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">{{galleryfiles.gallery_name}}</h3>
        </div>
        <div class="modal-body" id="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <tr>
                                <th>First Name</th>
                                <td>{{items.first_name}}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>{{items.last_name}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{items.email}}</td>
                            </tr>
                            <tr>
                                <th>Last login</th>
                                <td>{{items.last_login}}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{items.phone}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="button" ng-click="ok()">OK</button>
            <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
        </div>
    </script>



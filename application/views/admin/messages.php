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
                                <label for="" class="control-label col-lg-2">name</label>
                                <div class="col-lg-6">
                                    <input type="text" name="name" class="form-control" ng-model="newuser.name"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-2">Description</label>
                                <div class="col-lg-6">
                                    <textarea name="heading" class="form-control" ng-model="newuser.description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-2">File</label>
                                <div class="col-md-4">
                                    <button ngf-select="uploadFiles($files, $invalidFiles)"
                                            accept="application/pdf"
                                            ngf-max-size="15MB"
                                            ngf-multiple="true" type="button">
                                        Select Files
                                    </button>
                                    <span class="alert alert-danger" ng-show="fileValidation.status == true">{{fileValidation.msg}}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-12">
                                <div class="row">
                                    <ul class="list-group">
                                        <li ng-repeat="f in files" style="font:smaller" class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="col-sm-2">
                                                        <img ngf-src="f.$ngfBlobUrl" class="thumbnail" width="100px" ngf-no-object-url="true">
                                                        <span>{{f.name}} {{f.$errorParam}}</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <div class="progress progress-striped active" ng-show="f.progress >= 0" ng-class="{cancel: uploadstatus == 1}">
                                                                    <div ng-show="uploadstatus == 1">{{f.progressmsg}}</div>
                                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                                                         aria-valuemin="0" aria-valuemax="100" style="width:{{f.progress}}%" ng-show="uploadstatus != 1">
                                                                        {{f.progress}}% Complete
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--                                                            <div class="col-sm-4">-->
                                                            <!--                                                                <button class="btn btn-danger" type="button" ng-click="abort()">cancel</button>-->
                                                            <!--                                                            </div>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="bg-danger" ng-repeat="f in errFiles" style="font:smaller" class="list-group-item">{{f.name}} {{f.$error}} {{f.$errorParam}}
                                        </li>
                                    </ul>
                                </div>
                                <div class="row" ng-show="errorMsg">
                                    <div class="alert alert-danger">
                                        {{errorMsg}}
                                    </div>
                                </div>
                            </div>
                            <!--                                <span class="alert alert-warning">Image should be 100*100</span>-->

                            <!----for existing image----->
                            <div class="clearfix"></div>
                            <uib-accordion ng-show="item_files">
                                <div uib-accordion-group class="panel-default" is-open="open" >
                                    <uib-accordion-heading>
                                        Images<i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': open, 'glyphicon-chevron-right': !open}"></i>
                                    </uib-accordion-heading>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="thumbnail cus-thumb" ng-mouseover="showcaption=true" ng-mouseleave="showcaption=false" style="max-height: 142px;">
                                                <div class="caption" ng-show="showcaption">
                                                    <div id="content">
                                                        <a href="{{base_url+'uploads/'+item_files.file_name}}" class="label label-warning" rel="tooltip" title="Show">Show</a>
                                                        <!--                                                        <a href="" class="label label-danger" rel="tooltip" title="Delete" confirmed-click="deleteImage(item_files)" ng-confirm-click="Would you like to delete this item?!">Delete</a>-->
                                                    </div>
                                                </div>
                                                <img src="<?php echo base_url()?>adm/assets/img/pdf_icon.png" alt="thumbnails">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </uib-accordion>


                            <div class="clearfix"></div>

                            <div class="form-group">
                                <div class="col-lg-8 text-center">
                                    <button class="btn btn-primary" type="submit">Submit</button>
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

<!--View Messages-->
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            Messages
        </div>
        <div class="panel-body">
            <div class="col-md-3">
                <ul class="list-group">
                    <li class="list-group-item"> <i class="fa fa-fw fa-user"></i> <strong>Users</strong></li>
                    <li class="list-group-item" dir-paginate="user in users | filter:search | limitTo:pageSize | itemsPerPage:numPerPage">
                        <span class="badge">7 minutes ago</span>
                        <a ng-click="getMessages(user.id)" href="">{{user.first_name + '  ' + user.last_name}}</a>
                    </li>
                </ul>
                <dir-pagination-controls
                    max-size="10"
                    direction-links="true"
                    boundary-links="true">
                </dir-pagination-controls>
            </div>
            <div class="col-md-9" ng-show="messages.length">
                <uib-tabset active="activeForm">
                    <uib-tab index="0" heading="Inbox">
                        <div>
                            <ul class="list-group">
                                <uib-accordion close-others="true">
                                    <form action="" class="form-horizontal">
                                        <div class="form-group">
                                            <div class="col-lg-6 pull-right">
                                                <input type="text" class="form-control" placeholder="Type here" ng-model="search"/>
                                            </div>
                                        </div>
                                    </form>
                                    <li class="list-group-item" dir-paginate="message in messages | filter:search | limitTo:pageSize | itemsPerPage:numPerPage" ng-show="message.type == 'received'" style="padding: 0;">
                                        <div uib-accordion-group heading="{{message.subject}}">
                                            <span> {{message.message}}</span>
                                            <a href="{{file.url}}" ng-repeat="file in message.files" target="_blank">
                                                <img src="{{base_url + 'adm/assets/img/pdf_icon.png'}}" alt="" width="25"/>
                                            </a>
                                        </div>
                                    </li>
                                </uib-accordion>
                            </ul>
                        </div>
                    </uib-tab>
                    <uib-tab index="1" heading="Sent">
                        <uib-accordion close-others="true">
                            <form action="" class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-lg-6 pull-right">
                                        <input type="text" class="form-control" placeholder="Type here" ng-model="search"/>
                                    </div>
                                </div>
                            </form>
                            <li class="list-group-item" dir-paginate="message in messages | filter:search | limitTo:pageSize | itemsPerPage:numPerPage" ng-show="message.type == 'sent'" style="padding: 0;">
                                <div uib-accordion-group heading="{{message.subject}}">
                                    <span>{{message.message}}</span>
                                    <a href="{{file.url}}" ng-repeat="file in message.files" target="_blank">
                                        <img src="{{base_url + 'adm/assets/img/pdf_icon.png'}}" alt="" width="25"/>
                                    </a>
                                </div>
                            </li>
                        </uib-accordion>
                    </uib-tab>
                    <uib-tab index="2" heading="Compose">
                        <form method="POST" class="form-horizontal" ng-submit="sendMessage(messages[0].user.id)">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Subject</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" name="subject" ng-model="newmessage.subject" required=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-2">Message</label>
                                <div class="col-lg-8">
                                    <textarea name="message" class="form-control" ng-model="newmessage.message" required=""></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-2">File</label>
                                <div class="col-md-4">
                                    <button ngf-select="uploadFiles($files, $invalidFiles)"
                                            accept="application/pdf"
                                            ngf-max-size="15MB"
                                            ngf-multiple="true" type="button">
                                        Select Files
                                    </button>
                                    <span class="alert alert-danger" ng-show="fileValidation.status == true">{{fileValidation.msg}}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <ul class="list-group">
                                        <li ng-repeat="f in files" style="font:smaller" class="list-group-item">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-4">
                                                        <img src="{{base_url + '/adm/assets/img/pdf_icon.png'}}" width="25">
                                                        <span>{{f.name}} {{f.$errorParam}}</span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="progress progress-striped active" ng-show="f.progress >= 0" ng-class="{cancel: uploadstatus == 1}">
                                                                    <div ng-show="uploadstatus == 1">{{f.progressmsg}}</div>
                                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                                                         aria-valuemin="0" aria-valuemax="100" style="width:{{f.progress}}%" ng-show="uploadstatus != 1">
                                                                        {{f.progress}}% {{f.name}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="bg-danger" ng-repeat="f in errFiles" style="font:smaller" class="list-group-item">{{f.name}} {{f.$error}} {{f.$errorParam}}
                                        </li>
                                    </ul>
                                </div>
                                <div class="row" ng-show="errorMsg">
                                    <div class="alert alert-danger">
                                        {{errorMsg}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-success" type="submit">Send</button>
                                <button class="btn btn-danger" type="button">Cancel</button>
                            </div>
                        </form>
                    </uib-tab>
                </uib-tabset>
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



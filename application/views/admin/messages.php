<div class="header">
    <h1 class="page-header">
        Messages
    </h1>
    <ol class="breadcrumb">
        <li><a href="#dashboard">Home</a></li>
        <li><a href="#user">message</a></li>
    </ol>
</div>

<div id="page-inner">
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
                    <li class="list-group-item" dir-paginate="user in users | filter:search | limitTo:pageSize | itemsPerPage:6" pagination-id="user">
                        <span class="badge" ng-show="user.message">{{user.message[0].counted_rows}} New</span>
                        <a ng-click="getMessages(user)" href="">{{user.first_name + '  ' + user.last_name}}</a>
                    </li>
                </ul>
                <dir-pagination-controls
                    max-size="10"
                    direction-links="true"
                    boundary-links="true"
                    pagination-id="user">
                </dir-pagination-controls>
            </div>
            <div class="col-md-9" ng-show="showMessages">
                <uib-tabset active="activeForm">
                    <uib-tab index="0" heading="Inbox">
                        <ul class="list-group">
                            <uib-accordion close-others="true">
                                <form  class="form-horizontal">
                                    <div class="dataTables_length" id="dataTables-example_length">
                                        <label>
                                            <select name="dataTables-example_length" aria-controls="dataTables-example" class="form-control input-sm" ng-model="receivedPerPage"
                                                    ng-options="num for num in paginations">{{num}}
                                            </select>
                                            records per page
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6 pull-right">
                                            <input type="text" class="form-control" placeholder="Type here" ng-model="search"/>
                                        </div>
                                    </div>
                                </form>
                                <li class="list-group-item" dir-paginate="message in receivedMessages | filter:search | limitTo:pageSize | itemsPerPage:receivedPerPage" ng-show="message.type == 'received'" style="padding: 0;" pagination-id="receivedItem">

                                    <div uib-accordion-group ng-class="{'delivered':message.received == 0}">
                                        <uib-accordion-heading>
                                            <div ng-click="delivered(message)">
                                                <span style="font-weight: 600">{{message.subject}}</span>
                                                <span ng-if="message.reference_id && message.reference_id != '0'">  |   reply from -> {{message.reference.subject}}</span>
                                                <span class="badge badge-inverse pull-right"><time-ago from-time='{{ message.dateago}}'></time-ago></span>
                                                <span class="badge badge-info" style="float: right"></span>
                                            </div>
                                        </uib-accordion-heading>
                                        <span class="help-block"> {{message.message}}</span>
                                        <a href="{{base_url + 'user-files/' + file.file_name}}" ng-repeat="file in message.files" target="_blank" uib-popover="{{file.file_name}}" popover-trigger="'mouseenter'">
                                            <img src="{{base_url + 'adm/assets/img/pdf_icon.png'}}" alt="" width="25"/>
                                        </a>
                                    </div>
                                </li>
                                <dir-pagination-controls
                                    max-size="10"
                                    direction-links="true"
                                    boundary-links="true"
                                    pagination-id="receivedItem">
                                </dir-pagination-controls>
                            </uib-accordion>
                        </ul>
                    </uib-tab>
                    <uib-tab index="1" heading="Sent" ng-click="loadSentItem(user.id)">
                        <uib-accordion close-others="true">
                            <form class="form-horizontal">
                                <div class="dataTables_length" id="dataTables-example_length">
                                    <label>
                                        <select name="dataTables-example_length" aria-controls="dataTables-example" class="form-control input-sm" ng-model="sendPerPage"
                                                ng-options="num for num in paginations">{{num}}
                                        </select>
                                        records per page
                                    </label>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-6 pull-right">
                                        <input type="text" class="form-control" placeholder="Type here" ng-model="search"/>
                                    </div>
                                </div>
                            </form>
                            <li class="list-group-item" dir-paginate="message in sentItem | filter:search | limitTo:pageSize | itemsPerPage:sendPerPage" ng-show="message.type == 'sent'" style="padding: 0;" pagination-id="sentItem">
                                <div uib-accordion-group>
                                    <uib-accordion-heading>
                                        <span style="font-weight: 600">{{message.subject}}</span>
                                        <span ng-if="message.reference_id && message.reference_id != '0'">  |   reply from -> {{message.reference.subject}}</span>
                                        <span class="badge badge-inverse pull-right">
                                            <!--For TIme ago -->
                                            <time-ago from-time='{{ message.dateago}}' format='MM/dd/yyyy'></time-ago>
                                            <i class="fa fa-check" aria-hidden="true" ng-show="message.received == 1"></i>
                                        </span>
                                        <span class="badge badge-info" style="float: right">{{message.length}}</span>
                                    </uib-accordion-heading>
                                    <p>{{message.message}}</p>
                                    <a href="{{file.url}}" ng-repeat="file in message.files" target="_blank">
                                        <img src="{{base_url + 'adm/assets/img/pdf_icon.png'}}" alt="" width="25"/>
                                    </a>
                                </div>
                            </li>
                            <dir-pagination-controls
                                max-size="10"
                                direction-links="true"
                                boundary-links="true"
                                pagination-id="sentItem">
                            </dir-pagination-controls>
                        </uib-accordion>
                    </uib-tab>
                    <uib-tab index="2" heading="Compose">
                        <form method="POST" class="form-horizontal" ng-submit="sendMessage(user.id)">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Reference Message</label>
                                <div class="col-lg-8">
                                    <select class="form-control" name="reference" ng-model="newmessage.reference_id">
                                        <option value="" selected disabled>Select</option>
                                        <option value="{{reference.id}}" ng-repeat="reference in receivedMessages">{{reference.subject}}</option>
                                    </select>
                                </div>
                            </div>
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
                                            accept="application/pdf,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel,text/plain,application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,application/vnd.oasis.opendocument.text"
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
                                <button class="btn btn-danger" type="button" ng-click="newMessage()">Cancel</button>
                            </div>
                        </form>
                        <div class="alert alert-success text-center" ng-show="successMessage">
                            <strong>Alert!</strong> You successfully send message.
                        </div>
                        <div class="alert alert-danger text-center" ng-show="errorMessage">
                            <strong>Warning!</strong> Try again..
                        </div>
                    </uib-tab>
                    <uib-tab index="3" disable="true" style="cursor: default;" class="tab-style">
                        <uib-tab-heading style="cursor: default">
                            <i class="glyphicon glyphicon-user"></i> <span style="cursor: default">{{user.first_name + '   ' + user.last_name}}</span>
                            <span style="margin-left: 21px; cursor: default"><i class="fa fa-envelope" aria-hidden="true"></i>   {{user.email}}</span>
                            <a ng-click="refreshMessage(user)"><i class="fa fa-refresh" aria-hidden="true"></i>                            </a>
                        </uib-tab-heading>
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



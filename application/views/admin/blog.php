<div class="header">
    <h1 class="page-header">
        Blog <a href="" ng-click="newBlog()" ng-show="showform != true"><i class="fa fa-plus" aria-hidden="true"></i></a>
        <a href="" ng-click="hideForm()" ng-show="showform != false"><i class="fa fa-minus" aria-hidden="true"></i></a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#dashboard">Home</a></li>
        <li><a href="#blog">blog</a></li>
    </ol>
</div>

<div id="page-inner">
<!--ADD Form-->
<div class="row" ng-show="showform">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Add Blog
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-10">
                        <form class="form-horizontal" method="POST" ng-submit="addBlog()">
                            <div class="form-group">
                                <label for="" class="control-label col-lg-2">Heading</label>
                                <div class="col-md-8">
                                    <input type="text" name="heading" id="heading" ng-model="newblog.heading" class="form-control" placeholder="Type your heading here" required=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-2">Introduction</label>
                                <div class="col-md-8">
                                    <textarea ng-model="newblog.introduction" class="form-control" placeholder="Type yor introduction here" required=""></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-lg-2">Main Image URL</label>
                                <div class="col-md-8">
                                    <input type="text" name="image_url" id="image_url" ng-model="newblog.image_url" class="form-control" placeholder="Paste your Image URL"/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="" class="control-label col-lg-2">Date</label>
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="date" uib-datepicker-popup="dd-MMMM-yyyy" ng-model="date" is-open="popup2.opened" datepicker-options="dateOptions" ng-required="true" close-text="Close" readonly show-button-bar="false"/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="open2()"><i class="glyphicon glyphicon-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-lg-2">Photo</label>
                                <div class="col-md-4">
                                    <button ngf-select="uploadFiles($files, $invalidFiles)"
                                            accept="image/*"
                                            ngf-max-height="5000"
                                            ngf-max-size="5MB"
                                            ngf-multiple="false" type="button">
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
                                                        <span>{{f.$errorParam}}</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <div class="progress progress-striped active" ng-show="f.progress >= 0" ng-class="{cancel: uploadstatus == 1}">
                                                                    <div ng-show="uploadstatus == 1">{{f.progressmsg}}</div>
                                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                                                         aria-valuemin="0" aria-valuemax="100" style="width:{{f.progress}}%" ng-show="uploadstatus != 1">
                                                                        {{f.progress}}% {{f.name}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <input type="text" readonly ng-model="uploaded[$index].url" class="form-control"/>
                                                                </div>
                                                            </div>
<!--                                                            <div class="col-sm-4">-->
<!--                                                                <button class="btn btn-danger" type="button" ng-click="cancelUpload()">cancel</button>-->
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

                            <!----for existing image----->
                            <div class="clearfix"></div>
                            <uib-accordion ng-show="newblog.id">
                                <div uib-accordion-group class="panel-default" is-open="open" >
                                    <uib-accordion-heading>
                                        Images<i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': open, 'glyphicon-chevron-right': !open}"></i>
                                    </uib-accordion-heading>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="thumbnail cus-thumb" ng-mouseover="showcaption=true" ng-mouseleave="showcaption=false" style="max-height: 142px;">
                                                <div class="caption" ng-show="showcaption">
                                                    <div id="content">
                                                        <a class="example-image-link label label-warning" rel="tooltip" title="Show" href="{{newblog.image_url}}" data-lightbox="example-1" data-title="">
                                                            show
                                                        </a>
                                                        <a href="" class="label label-danger" rel="tooltip" title="Delete" confirmed-click="deleteImage(newblog)" ng-confirm-click="Would you like to delete this item?!">Delete</a>
                                                    </div>
                                                </div>

                                                <img src="{{newblog.image_url}}" alt="thumbnails">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </uib-accordion>

                            <div class="form-group">
                                <textarea ckeditor="options" name="content" ng-model="newblog.content"></textarea>
                            </div>

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


<!--View Blog-->
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            Result blog list
        </div>
        <div class="panel-body">
            <div class="table-responsive">
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

                    <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>id</th>
                            <th>Date</th>
                            <th>Heading</th>
                            <th>Introduction</th>
                            <th>Content</th>
                            <th>Photo</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr dir-paginate="blog in blogs | filter:search | limitTo:pageSize | itemsPerPage:numPerPage">
                            <td>{{$index+1}}</td>
                            <td>{{blog.id}}</td>
                            <td>{{blog.date |date:'dd-MMM-yyyy'}}</td>
                            <td><a uib-popover="{{blog.heading}}">{{blog.heading | limitTo : 20}}{{blog.heading.length > 20 ? '...' : ''}}</a></td>
                            <td> <a uib-popover="{{blog.introduction}}" popover-trigger="'click'">{{blog.introduction | limitTo : 20}}{{blog.introduction.length > 20 ? '...' : ''}}</a></td>
                            <td><a  uib-popover="{{blog.content}}" popover-class="increase-popover-width">{{blog.content | limitTo : 20}}{{blog.content.length > 20 ? '...' : ''}}</a></td>
<!--                            <td><a  uib-popover-html="getPopoverContent(blog.content)"">{{blog.content | limitTo : 20}}{{blog.content.length > 20 ? '...' : ''}}</a></td>-->
                            <td>
                                <a class="example-image-link" href="{{blog.image_url}}" data-lightbox="example-1" data-title="">
                                    <img ng-src="{{blog.image_url}}" alt=""  style="width: 25px; max-height: 25px" id="myImg"/>
                                </a>
                            </td>
                            <td>
                                <div  class="btn-group btn-group-xs" role="group">
                                    <button type="button" class="btn btn-info" ng-click="editBlog(blog)">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button  type="button" class="btn btn-danger" confirmed-click="deleteBlog(blog)" ng-confirm-click="Would you like to delete this item?!">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
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



/**
 * Created by psybo-03 on 1/7/17.
 */

var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap', 'angularUtils.directives.dirPagination', 'ngFileUpload', 'ngCkeditor', 'yaru22.angular-timeago']);
app.config(['$routeProvider', '$locationProvider', 'timeAgoSettings', function ($routeProvider, $locationProvider, timeAgoSettings) {
    timeAgoSettings.allowFuture = true;
    $locationProvider.hashPrefix('');
    $routeProvider
        .when('/', {
        })
        .when('/dashboard', {
            templateUrl: 'dashboard',
            controller: 'dashboardController'
        })
        .when('/testimonial', {
            templateUrl: 'testimonial',
            controller: 'testimonialController'
        })
        .when('/blog', {
            templateUrl: 'blog',
            controller: 'blogController'
        })
        .when('/documents', {
            templateUrl: 'document',
            controller: 'documentController'
        })
        .when('/users', {
            templateUrl: 'user',
            controller: 'userController'
        })
        .when('/messages', {
            templateUrl: 'messages',
            controller: 'messageController'
        })
        .when('/user-profile',{
            templateUrl: 'edit-profile'
        })

}]);

//Pagination filter
app.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});


app.directive('ngConfirmClick', [
    function () {
        return {
            link: function (scope, element, attr) {
                var msg = attr.ngConfirmClick || "Are you sure?";
                var clickAction = attr.confirmedClick;
                element.bind('click', function (event) {
                    if (window.confirm(msg)) {
                        scope.$eval(clickAction)
                    }
                });
            }
        };
    }
]);




/**
 * Created by psybo-03 on 1/7/17.
 */

app.controller('adminController', ['$scope', '$location', '$http', '$rootScope', '$filter', '$window', 'uibDateParser', '$uibModal', '$log', '$document', function ($scope, $location, $http, $rootScope, $filter, $window, uibDateParser, $uibModal, $log, $document) {

    $scope.error = {};
    var base_url = $scope.baseUrl = $location.protocol() + "://" + location.host + '/';
    $rootScope.base_url = base_url;
    $rootScope.public_url = $scope.baseUrl = $location.protocol() + "://" + location.host;


    $scope.paginations = [5, 10, 20, 25];
    $scope.numPerPage = 10;

    $scope.user = {};
    $scope.curuser = {};
    $scope.newuser = {};
    $scope.newuser = {};
    $rootScope.loading = false;
    $scope.formdisable = false;

    $rootScope.loading = false;

    $scope.format = 'yyyy/MM/dd';
    $scope.validationError = {};
    //$scope.date = new Date();

    //check_thumb();

    //load_user();

    // Editor options.
    $scope.options = {
        language: 'en',
        allowedContent: true,
        entities: false
    };

    // Called when the editor is completely ready.
    $scope.onReady = function () {
        console.log('test');
    };

    function load_user() {
        var url = $rootScope.base_url + 'dashboard/user';
        $http.get(url).then(function (response) {
            if (response.data) {
                $scope.curuser = response.data.username;
                $scope.newuser.username = $scope.curuser;
            }
        });
    }

    $scope.login = function () {
        console.log('login');
        var fd = new FormData();
        angular.forEach($scope.user, function (item, key) {
            fd.append(key, item);
        });

        var url = $rootScope.base_url + 'login/verify';
        $http.post(url, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined, 'Process-Data': false}
        })
            .then(function onSuccess(response) {
                $window.location.href = base_url + 'dashboard/#/';
            }, function onError(response) {
                console.log('login error');
                console.log(response.data);
                $scope.error = response.data;
                $scope.showerror = true;
            });
    };

    function check_thumb() {
        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/check-thumb';
        $http.post(url, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined, 'Process-Data': false}
        })
            .then(function nSuccess(response) {
                console.log('success');
                $rootScope.loading = false;
            }, function onError(response) {
                console.log('error');
                $rootScope.loading = false;
            })
    }

    $scope.changeProfile = function () {
        $rootScope.loading = true;
        var fd = new FormData();
        var userid = angular.element(document.getElementsByName('userid')[0]).val();

        angular.forEach($scope.newuser, function (item, key) {
            fd.append(key, item);
        });
        var url = $rootScope.base_url + 'dashboard/edit-profile/submit/' + userid;
        $http.post(url, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined, 'Process-Data': false}
        })
            .then(function onSuccess(response) {
                $rootScope.loading = false;
                console.log('profile changed');
                $scope.showmsg = true;
                $scope.formdisable = true;
                openModal('Updated.', 'sm');
                $scope.newuser = {};
                load_user();
                $scope.newuser.username = $scope.curuser;
                $scope.formdisable = false;
                $scope.validationError = {};
            }, function onError(response) {
                $rootScope.loading = false;
                $scope.showerror = true;
                console.log(response);
                if (response.data.cur_password == 0) {
                    $scope.validationError.curPassword = true;
                }else{
                    openModal('Try again later.', 'sm');
                    $scope.newuser = {};
                    $scope.newuser.username = $scope.curuser;
                    load_user();
                }
                $scope.formdisable = false;
            });
    };

    $scope.cancel = function () {
        $window.location.href = '/#';
    };


    /******DATE Picker start******/
    $scope.today = function () {
        $scope.date = new Date();
    };
    $scope.today();

    $scope.clear = function () {
        $scope.date = null;
    };

    $scope.inlineOptions = {
        customClass: getDayClass,
        minDate: new Date(),
        showWeeks: true
    };

    $scope.dateOptions = {
        formatYear: 'yy',
        maxDate: new Date(2020, 5, 22),
        minDate: new Date(),
        startingDay: 1
    };

    // Disable weekend selection
    function disabled(data) {
        var date = data.date,
            mode = data.mode;
        return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
    }

    $scope.toggleMin = function () {
        $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
        $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
    };

    $scope.toggleMin();

    $scope.open1 = function () {
        $scope.popup1.opened = true;
    };

    $scope.open2 = function () {
        $scope.popup2.opened = true;
    };

    $scope.setDate = function (year, month, day) {
        $scope.date = new Date(year, month, day);
    };

    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];
    $scope.altInputFormats = ['M!/d!/yyyy'];

    $scope.popup1 = {
        opened: false
    };

    $scope.popup2 = {
        opened: false
    };

    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    var afterTomorrow = new Date();
    afterTomorrow.setDate(tomorrow.getDate() + 1);
    $scope.events = [
        {
            date: tomorrow,
            status: 'full'
        },
        {
            date: afterTomorrow,
            status: 'partially'
        }
    ];

    function getDayClass(data) {
        var date = data.date,
            mode = data.mode;
        if (mode === 'day') {
            var dayToCheck = new Date(date).setHours(0, 0, 0, 0);

            for (var i = 0; i < $scope.events.length; i++) {
                var currentDay = new Date($scope.events[i].date).setHours(0, 0, 0, 0);

                if (dayToCheck === currentDay) {
                    return $scope.events[i].status;
                }
            }
        }

        return '';
    }


    /******DATE Picker END******/

    function openModal(content, size, parentSelector) {
        var parentElem = parentSelector ?
            angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;
        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            templateUrl: 'myModalContent.html',
            controller: 'ModalInstanceCtrl',
            controllerAs: '$scope',
            size: size,
            appendTo: parentElem,
            resolve: {
                items: function () {
                    return content;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };

}]);

/**
 * Created by psybo-03 on 3/7/17.
 */

app.controller('blogController', ['$scope', '$http', '$rootScope', '$location', 'Upload', '$timeout', '$filter', '$uibModal', '$log', '$document', function ($scope, $http, $rootScope, $location, Upload, $timeout, $filter, $uibModal, $log, $document) {

    $scope.blogs = [];
    $scope.newblog = {};
    $scope.curblog = {};
    $scope.files = [];
    $scope.files1 = [];
    $scope.errFiles = [];
    $scope.showform = false;
    $scope.message = {};
    $rootScope.url = $location.path().replace('/', '');
    $scope.uploaded = [];
    $scope.uploaded1 = [];
    $scope.fileValidation = {};

    loadBlog();

    function loadBlog() {
        $http.get($rootScope.base_url + 'dashboard/blog/get').then(function (response) {
            console.log(response.data);
            if (response.data) {
                $scope.blogs = response.data;
                $scope.showtable = true;
            } else {
                console.log('No data Found');
                $scope.showtable = false;
                $scope.message = 'No data found';
            }
        });
    }

    $scope.newBlog = function () {
        $scope.newblog = {};
        $scope.files = [];
        $scope.errFiles = [];
        $scope.showform = true;
        $scope.item_files = false;
    };

    $scope.editBlog = function (item) {
        $scope.showform = true;
        $scope.curblog = item;
        $scope.newblog = angular.copy(item);
        $scope.files = [];
    };

    $scope.hideForm = function () {
        $scope.errFiles = '';
        $scope.showform = false;
    };

    $scope.addBlog = function () {
        $rootScope.loading = true;

        $scope.newblog.date = $filter('date')($scope.date, "yyyy-MM-dd");
        var fd = new FormData();

        angular.forEach($scope.newblog, function (item, key) {
            fd.append(key, item);
        });

        if ($scope.newblog['id']) {
            var url = $rootScope.base_url + 'dashboard/blog/edit/' + $scope.newblog.id;
            $http.post(url, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
                .then(function onSuccess(response) {
                    loadBlog();
                    $scope.newblog = {};
                    $scope.showform = false;
                    $rootScope.loading = false;
                    $scope.files = [];
                },function onError(response) {
                    console.log('edit Error :- Status :' + response.status + 'data : ' + response.data);
                    $rootScope.loading = false;
                    $scope.files = [];
                });
        } else {
            var url = $rootScope.base_url + 'dashboard/blog/add';

            $http.post(url, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
                .then(function onSuccess(response) {
                    loadBlog();
                    $scope.newblog = {};
                    $scope.showform = false;
                    $rootScope.loading = false;
                    $scope.files = [];

                }, function onError(response) {
                    console.log('addError :- Status :' + response.status + 'data : ' + response.data);
                    console.log(response.data);
                    $rootScope.loading = false;
                    $scope.files = [];

                    if (response.status == 403) {
                        $scope.fileValidation.status = true;
                        $scope.fileValidation.msg = response.data.validation_error;
                    }
                });
        }
    };

    $scope.deleteBlog = function (item) {
        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/blog/delete/' + item['id'];
        $http.delete(url)
            .then(function onSuccess(response) {
                var index = $scope.blogs.indexOf(item);
                $scope.blogs.splice(index, 1);
                alert(response.data.msg);
                loadBlog();
                $rootScope.loading = false;
            },function onError(response) {
                console.log('Delete Error :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
            });
    };


    $scope.uploadFiles = function (files, errFiles) {
        angular.forEach(errFiles, function (errFile) {
            $scope.errFiles.push(errFile);
        });
        angular.forEach(files, function (file) {
            $scope.files.push(file);
            file.upload = Upload.upload({
                url: $rootScope.base_url + 'dashboard/blog/upload',
                data: {file: file}
            });

            file.upload.then(function (response) {
                $timeout(function () {
                    $scope.uploaded.push(response.data);
                    console.log($scope.uploaded);
                });
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
            }, function (evt) {
                file.progress = Math.min(100, parseInt(100.0 *
                evt.loaded / evt.total));
            });
        });
    };

    $scope.cancelUpload=function() {
        Upload.upload.abort();
    };
    $scope.deleteImage =function(item) {

        $scope.newblog.date = $filter('date')($scope.date, "yyyy-MM-dd");
        var fd = new FormData();
        $scope.newblog.image_url = '';
        angular.forEach($scope.newblog, function (item, key) {
            fd.append(key, item);
        });

        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/blog/edit/' + item.id;
        $http.post(url, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined, 'Process-Data': false}
        })
            .then(function onSuccess(response) {
                console.log('image deleted');
            },function onError(response) {
                console.log('edit Error :- Status :' + response.status + 'data : ' + response.data);
            });
    };

    $scope.showBlogFiles = function (item) {
        console.log(item);
        $scope.blogfiles = item;
    };



    /****Modal***/

    $scope.animationsEnabled = true;

    $scope.open = function (blog,size, parentSelector) {
        var parentElem = parentSelector ?
            angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;
        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'myModalContent.html',
            controller: 'ModalInstanceCtrl',
            controllerAs: '$scope',
            size: size,
            appendTo: parentElem,
            resolve: {
                items: function () {
                    return blog;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };

}]);






/**
 * Created by psybo-03 on 3/7/17.
 */


app.controller('documentController', ['$scope', '$http', '$rootScope', '$location', 'Upload', '$timeout', '$filter', '$uibModal', '$log', '$document', function ($scope, $http, $rootScope, $location, Upload, $timeout, $filter, $uibModal, $log, $document) {

    $scope.documents = [];
    $scope.newdocument = {};
    $scope.curdocument = {};
    $scope.files = [];
    $scope.errFiles = [];
    $scope.showform = false;
    $scope.message = {};
    $rootScope.url = $location.path().replace('/', '');
    $scope.uploaded = [];
    $scope.fileValidation = {};


    loadDocument();

    function loadDocument() {
        $http.get($rootScope.base_url + 'dashboard/document/get').then(function (response) {
            console.log(response.data);
            if (response.data) {
                $scope.documents = response.data;
                $scope.showtable = true;
            } else {
                console.log('No data Found');
                $scope.showtable = false;
                $scope.message = 'No data found';
            }
        });
    }

    $scope.newDocument = function () {
        $scope.newdocument = {};
        $scope.filespre = [];
        $scope.uploaded = [];
        $scope.files = [];
        $scope.errFiles = [];
        $scope.showform = true;
        $scope.item_files = false;
    };

    $scope.editDocument = function (item) {
        console.log(item);
        $scope.showform = true;
        $scope.curdocument = item;
        $scope.newdocument = angular.copy(item);
        $scope.item_files = item.file;
        $scope.files = [];
    };

    $scope.hideForm = function () {
        $scope.errFiles = '';
        $scope.showform = false;
    };

    $scope.addDocument = function () {
        $rootScope.loading = true;

        var fd = new FormData();

        angular.forEach($scope.newdocument, function (item, key) {
            fd.append(key, item);
        });

        fd.append('uploaded', JSON.stringify($scope.uploaded));

        if ($scope.newdocument['id']) {
            var url = $rootScope.base_url + 'dashboard/document/edit/' + $scope.newdocument.id;
            $http.post(url, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
                .then(function onSuccess(response) {
                    loadDocument();
                    $scope.newdocument = {};
                    $scope.showform = false;
                    $rootScope.loading = false;
                    $scope.files = '';
                },function onError(response) {
                    console.log('edit Error :- Status :' + response.status + 'data : ' + response.data);
                    $rootScope.loading = false;
                    $scope.files = '';
                });
        } else {
            var url = $rootScope.base_url + 'dashboard/document/add';

            $http.post(url, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
                .then(function onSuccess(response) {
                    loadDocument();
                    $scope.newdocument = {};
                    $scope.showform = false;
                    $rootScope.loading = false;
                    $scope.files = '';

                }, function onError(response) {
                    console.log('addError :- Status :' + response.status + 'data : ' + response.data);
                    console.log(response.data);
                    $rootScope.loading = false;
                    $scope.files = '';

                    if (response.status == 403) {
                        $scope.fileValidation.status = true;
                        $scope.fileValidation.msg = response.data.validation_error;
                    }
                });
        }
    };

    $scope.deleteDocument = function (item) {
        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/document/delete/' + item['id'];
        $http.delete(url)
            .then(function onSuccess(response) {
                var index = $scope.documents.indexOf(item);
                $scope.documents.splice(index, 1);
                alert(response.data.msg);
                loadDocument();
                $rootScope.loading = false;
            },function onError(response) {
                console.log('Delete Error :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
            });
    };


    $scope.uploadFiles = function (files, errFiles) {
        angular.forEach(errFiles, function (errFile) {
            $scope.errFiles.push(errFile);
        });
        angular.forEach(files, function (file) {
            $scope.files.push(file);
            file.upload = Upload.upload({
                url: $rootScope.base_url + 'dashboard/document/upload',
                data: {file: file}
            });

            file.upload.then(function (response) {
                $timeout(function () {
                    $scope.uploaded.push(response.data);
                    file.result = response.data;
                });
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
            }, function (evt) {
                file.progress = Math.min(100, parseInt(100.0 *
                evt.loaded / evt.total));
            });
        });
    };

    $scope.deleteImage =function(item) {

        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/document/delete-image/' + item['id'];
        $http.delete(url)
            .then(function onSuccess(response) {
                console.log('image deleted');
                $scope.item_files = '';
                $rootScope.loading = false;
            },function onError(response) {
                console.log('Delete Error :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
            });
    };

    $scope.showDocumentFiles = function (item) {
        console.log(item);
        $scope.documentfiles = item;
    };



    /****Modal***/

    $scope.animationsEnabled = true;

    $scope.open = function (document,size, parentSelector) {
        var parentElem = parentSelector ?
            angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;
        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'myModalContent.html',
            controller: 'ModalInstanceCtrl',
            controllerAs: '$scope',
            size: size,
            appendTo: parentElem,
            resolve: {
                items: function () {
                    return document;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };

}]);






/**
 * Created by psybo-03 on 3/7/17.
 */


app.controller('messageController', ['$scope', '$http', '$rootScope', '$location', 'Upload', '$timeout', '$filter', '$uibModal', '$log', '$document', function ($scope, $http, $rootScope, $location, Upload, $timeout, $filter, $uibModal, $log, $document) {

    $scope.messages = [];
    $scope.newmessage = {};
    $scope.files = [];
    $scope.errFiles = [];
    $scope.message = {};
    $rootScope.url = $location.path().replace('/', '');
    $scope.uploaded = [];
    $scope.fileValidation = {};

    $scope.users = [];
    $scope.successMessage = false;
    $scope.errorMessage = false;
    $scope.sentItem = [];
    $scope.receivedMessages = [];
    $scope.user = {};
    $scope.showMessages = false;
    $scope.receivedPerPage = 5;
    $scope.sendPerPage = 5;

    //loadMessage();
    loadUser();

    function loadMessage() {
        $http.get($rootScope.base_url + 'dashboard/message/get').then(function (response) {
            console.log(response.data);
            if (response.data) {
                $scope.messages = response.data;
                $scope.showtable = true;
            } else {
                console.log('No data Found');
                $scope.showtable = false;
                $scope.message = 'No data found';
            }
        });
    }

    function loadUser() {
        $http.get($rootScope.base_url + 'dashboard/user/get').then(function (response) {
            console.log(response.data);
            if (response.data) {
                $scope.users = response.data;
            }
        });
    }

    $scope.newMessage = function () {
        $scope.newmessage = {};
        $scope.filespre = [];
        $scope.uploaded = [];
        $scope.files = [];
        $scope.errFiles = [];
    };

    $scope.sendMessage = function (user_id) {
        $rootScope.loading = true;
        var fd = new FormData();

        angular.forEach($scope.newmessage, function (item, key) {
            fd.append(key, item);
        });

        fd.append('uploaded', JSON.stringify($scope.uploaded));

        var url = $rootScope.base_url + 'dashboard/message/send/' + user_id;
        $http.post(url, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined, 'Process-Data': false}
        })
            .then(function onSuccess(response) {
                $scope.newmessage = {};
                $rootScope.loading = false;
                $scope.files = [];
                $scope.successMessage = true;
                $timeout(function () {
                    $scope.successMessage = false;
                }, 5000);
            }, function onError(response) {
                console.log('Send Error :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
                $scope.files = [];
                $scope.errorMessage = true;
                $timeout(function () {
                    $scope.errorMessage = false;
                }, 5000);
            });
    };

    $scope.deleteMessage = function (item) {
        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/message/delete/' + item.id;
        $http.delete(url)
            .then(function onSuccess(response) {
                var index = $scope.messages.indexOf(item);
                $scope.messages.splice(index, 1);
                $rootScope.loading = false;
            },function onError(response) {
                console.log('Delete Error :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
            });
    };


    $scope.uploadFiles = function (files, errFiles) {
        angular.forEach(errFiles, function (errFile) {
            $scope.errFiles.push(errFile);
        });
        angular.forEach(files, function (file) {
            $scope.files.push(file);
            file.upload = Upload.upload({
                url: $rootScope.base_url + 'dashboard/message/upload',
                data: {file: file}
            });

            file.upload.then(function (response) {
                $timeout(function () {
                    $scope.uploaded.push(response.data);
                    file.result = response.data;
                });
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
            }, function (evt) {
                file.progress = Math.min(100, parseInt(100.0 *
                evt.loaded / evt.total));
            });
        });
    };

    $scope.deleteImage =function(item) {

        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/message/delete-image/' + item['id'];
        $http.delete(url)
            .then(function onSuccess(response) {
                console.log('image deleted');
                $scope.item_files = '';
                $rootScope.loading = false;
            },function onError(response) {
                console.log('Delete Error :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
            });
    };

    $scope.showMessageFiles = function (item) {
        console.log(item);
        $scope.messagefiles = item;
    };

    /****Modal start***/

    $scope.animationsEnabled = true;

    $scope.open = function (document,size, parentSelector) {
        var parentElem = parentSelector ?
            angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;
        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'myModalContent.html',
            controller: 'ModalInstanceCtrl',
            controllerAs: '$scope',
            size: size,
            appendTo: parentElem,
            resolve: {
                items: function () {
                    return document;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };

    /****Modal start***/


    $scope.getMessages = function (item) {
        console.log(item);
        /*$http.get($rootScope.base_url + 'dashboard/message/get/' + item).then(function (response) {
            if (response.data) {
                $scope.messages = response.data;
                angular.forEach($scope.messages, function (item, key) {
                    item.dateago = new Date(item.datetime * 1000).toISOString();
                });
                console.log($scope.messages);
            } else {
                console.log('No data Found');
                $scope.message = 'No data found';
            }
        });*/
        $scope.user = item;
        $scope.loadInbox(item.id);
        $scope.loadSentItem(item.id);
        $scope.showMessages = true;
    };

    $scope.loadSentItem = function (user_id) {
        $http.get($rootScope.base_url + 'dashboard/message/sent-item/' + user_id).then(function (response) {
            console.log(response.data);
            if (response.data) {
                $scope.sentItem = response.data;
                angular.forEach($scope.sentItem, function (item, key) {
                    item.dateago = new Date(item.datetime * 1000).toISOString();
                });
            } else {
                console.log('No data Found');
                $scope.message = 'No data found';
            }
        });
    };

    $scope.loadInbox = function (user_id) {
        $http.get($rootScope.base_url + 'dashboard/message/inbox/' + user_id).then(function (response) {
            if (response.data) {
                $scope.receivedMessages = response.data;
                angular.forEach($scope.receivedMessages, function (item, key) {
                    item.dateago = new Date(item.datetime * 1000).toISOString();
                });
                console.log($scope.receivedMessages);
            } else {
                console.log('No data Found');
                $scope.message = 'No data found';
            }
        });
    };

    $scope.delivered= function (item) {
        console.log(item);
        var url = $rootScope.base_url + 'dashboard/message/delivered/' + item['id'];
        $http.put(url)
            .then(function onSuccess(response) {
                console.log('updated');
                var index = $scope.receivedMessages.indexOf(item);
                $scope.receivedMessages[index].received = 1;
                loadUser();
            },function onError(response) {
                console.log('errorr');
                console.log(response);
            });
    };
}]);






/**
 * Created by psybo-03 on 24/7/17.
 */

app.controller('ModalInstanceCtrl', function ($uibModalInstance, items,$scope) {
    $scope.items = items;
    console.log($scope.items);

    $scope.ok = function () {
        $uibModalInstance.close($scope.items);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

/**
 * Created by psybo-03 on 1/7/17.
 */

app.controller('testimonialController', ['$scope', '$http', '$rootScope', '$location', 'Upload', '$timeout', '$filter', '$uibModal', '$log', '$document', function ($scope, $http, $rootScope, $location, Upload, $timeout, $filter, $uibModal, $log, $document) {

    $scope.testimonials = [];
    $scope.newtestimonial = {};
    $scope.curtestimonial = {};
    $scope.files = [];
    $scope.errFiles = [];
    $scope.showform = false;
    $scope.message = {};
    $rootScope.url = $location.path().replace('/', '');
    $scope.uploaded = [];
    $scope.fileValidation = {};


    loadTestimonial();

    function loadTestimonial() {
        $http.get($rootScope.base_url + 'dashboard/testimonial/get').then(function (response) {
            console.log(response.data);
            if (response.data) {
                $scope.testimonials = response.data;
                $scope.showtable = true;
            } else {
                console.log('No data Found');
                $scope.showtable = false;
                $scope.message = 'No data found';
            }
        });
    }

    $scope.newTestimonial = function () {
        $scope.newtestimonial = {};
        $scope.filespre = [];
        $scope.uploaded = [];
        $scope.files = [];
        $scope.errFiles = [];
        $scope.showform = true;
        $scope.item_files = false;
    };

    $scope.editTestimonial = function (item) {
        console.log(item);
        $scope.showform = true;
        $scope.curtestimonial = item;
        $scope.newtestimonial = angular.copy(item);
        $scope.item_files = item.file;
        $scope.files = [];
    };

    $scope.hideForm = function () {
        $scope.errFiles = '';
        $scope.showform = false;
    };

    $scope.addTestimonial = function () {
        $rootScope.loading = true;

        var fd = new FormData();

        angular.forEach($scope.newtestimonial, function (item, key) {
            fd.append(key, item);
        });

        fd.append('uploaded', JSON.stringify($scope.uploaded));

        if ($scope.newtestimonial['id']) {
            var url = $rootScope.base_url + 'dashboard/testimonial/edit/' + $scope.newtestimonial.id;
            $http.post(url, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
                .then(function onSuccess(response) {
                    loadTestimonial();
                    $scope.newtestimonial = {};
                    $scope.showform = false;
                    $rootScope.loading = false;
                    $scope.files = '';
                },function onError(response) {
                    console.log('edit Error :- Status :' + response.status + 'data : ' + response.data);
                    $rootScope.loading = false;
                    $scope.files = '';
                });
        } else {
            var url = $rootScope.base_url + 'dashboard/testimonial/add';

            $http.post(url, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
                .then(function onSuccess(response) {
                    loadTestimonial();
                    $scope.newtestimonial = {};
                    $scope.showform = false;
                    $rootScope.loading = false;
                    $scope.files = '';

                }, function onError(response) {
                    console.log('addError :- Status :' + response.status + 'data : ' + response.data);
                    console.log(response.data);
                    $rootScope.loading = false;
                    $scope.files = '';

                    if (response.status == 403) {
                        $scope.fileValidation.status = true;
                        $scope.fileValidation.msg = response.data.validation_error;
                    }
                });
        }
    };

    $scope.deleteTestimonial = function (item) {
        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/testimonial/delete/' + item['id'];
        $http.delete(url)
            .then(function onSuccess(response) {
                var index = $scope.testimonials.indexOf(item);
                $scope.testimonials.splice(index, 1);
                alert(response.data.msg);
                loadTestimonial();
                $rootScope.loading = false;
            },function onError(response) {
                console.log('Delete Error :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
            });
    };


    $scope.uploadFiles = function (files, errFiles) {
        angular.forEach(errFiles, function (errFile) {
            $scope.errFiles.push(errFile);
        });
        angular.forEach(files, function (file) {
            $scope.files.push(file);
            file.upload = Upload.upload({
                url: $rootScope.base_url + 'dashboard/testimonial/upload',
                data: {file: file}
            });

            file.upload.then(function (response) {
                $timeout(function () {
                    $scope.uploaded.push(response.data);
                    file.result = response.data;
                });
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
            }, function (evt) {
                file.progress = Math.min(100, parseInt(100.0 *
                evt.loaded / evt.total));
            });
        });
    };

    $scope.deleteImage =function(item) {

        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/testimonial/delete-image/' + item['id'];
        $http.delete(url)
            .then(function onSuccess(response) {
                console.log('image deleted');
                $scope.item_files = '';
                $rootScope.loading = false;
            },function onError(response) {
                console.log('Delete Error :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
            });
    };

    $scope.showTestimonialFiles = function (item) {
        console.log(item);
        $scope.testimonialfiles = item;
    };



    /****Modal***/

    $scope.animationsEnabled = true;

    $scope.open = function (testimonial,size, parentSelector) {
        var parentElem = parentSelector ?
            angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;
        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'myModalContent.html',
            controller: 'ModalInstanceCtrl',
            controllerAs: '$scope',
            size: size,
            appendTo: parentElem,
            resolve: {
                items: function () {
                    return testimonial;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };

}]);






/**
 * Created by psybo-03 on 3/7/17.
 */


app.controller('userController', ['$scope', '$http', '$rootScope', '$location', 'Upload', '$timeout', '$filter', '$uibModal', '$log', '$document', function ($scope, $http, $rootScope, $location, Upload, $timeout, $filter, $uibModal, $log, $document) {

    $scope.users = [];
    $scope.newuser = {};
    $scope.curuser = {};
    $scope.files = [];
    $scope.errFiles = [];
    $scope.showform = false;
    $scope.message = {};
    $rootScope.url = $location.path().replace('/', '');
    $scope.uploaded = [];
    $scope.fileValidation = {};
    $scope.mailData = {};
    $scope.error = {};


    loadUser();

    function loadUser() {
        $http.get($rootScope.base_url + 'dashboard/user/get-all').then(function (response) {
            console.log(response.data);
            if (response.data) {
                $scope.users = response.data;
                $scope.showtable = true;
            } else {
                console.log('No data Found');
                $scope.showtable = false;
                $scope.message = 'No data found';
            }
        });
    }

    $scope.newUser = function () {
        $scope.newuser = {};
        $scope.filespre = [];
        $scope.uploaded = [];
        $scope.files = [];
        $scope.errFiles = [];
        $scope.showform = true;
        $scope.item_files = false;
        $scope.error.mail = false;
    };

    $scope.editUser = function (item) {
        console.log(item);
        $scope.showform = true;
        $scope.curuser = item;
        $scope.newuser = angular.copy(item);
        $scope.item_files = item.file;
        $scope.files = [];
    };

    $scope.hideForm = function () {
        $scope.errFiles = '';
        $scope.showform = false;
    };

    $scope.addUser = function () {
        $rootScope.loading = true;

        var fd = new FormData();

        angular.forEach($scope.newuser, function (item, key) {
            fd.append(key, item);
        });

        fd.append('uploaded', JSON.stringify($scope.uploaded));

        if ($scope.newuser['id']) {
            var url = $rootScope.base_url + 'dashboard/user/edit/' + $scope.newuser.id;
            $http.post(url, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
                .then(function onSuccess(response) {
                    loadUser();
                    $scope.newuser = {};
                    $scope.showform = false;
                    $rootScope.loading = false;
                    $scope.files = '';
                },function onError(response) {
                    console.log('edit Error :- Status :' + response.status + 'data : ' + response.data);
                    $rootScope.loading = false;
                    $scope.files = '';
                });
        } else {
            var url = $rootScope.base_url + 'dashboard/user/add';

            $http.post(url, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
                .then(function onSuccess(response) {
                    loadUser();
                    $scope.newuser = {};
                    $scope.showform = false;
                    $rootScope.loading = false;
                    $scope.files = [];

                }, function onError(response) {
                    console.log('addError :- Status :' + response.status + 'data : ' + response.data);
                    console.log(response);
                    $rootScope.loading = false;
                    if (response.statusText == 'Mail server error') {
                        $scope.error.mail = true;
                    }
                    $rootScope.showform = false;
                    $scope.files = [];

                    if (response.status == 400) {
                        $scope.newuser = {};
                    }
                });
        }
    };

    $scope.deleteUser = function (item) {
        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/user/delete/' + item.id;
        $http.delete(url)
            .then(function onSuccess(response) {
                var index = $scope.users.indexOf(item);
                $scope.users.splice(index, 1);
                $rootScope.loading = false;
            },function onError(response) {
                console.log('Delete Error :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
            });
    };


    $scope.uploadFiles = function (files, errFiles) {
        angular.forEach(errFiles, function (errFile) {
            $scope.errFiles.push(errFile);
        });
        angular.forEach(files, function (file) {
            $scope.files.push(file);
            file.upload = Upload.upload({
                url: $rootScope.base_url + 'dashboard/user/upload',
                data: {file: file}
            });

            file.upload.then(function (response) {
                $timeout(function () {
                    $scope.uploaded.push(response.data);
                    file.result = response.data;
                });
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
            }, function (evt) {
                file.progress = Math.min(100, parseInt(100.0 *
                evt.loaded / evt.total));
            });
        });
    };

    $scope.deleteImage =function(item) {

        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/user/delete-image/' + item['id'];
        $http.delete(url)
            .then(function onSuccess(response) {
                console.log('image deleted');
                $scope.item_files = '';
                $rootScope.loading = false;
            },function onError(response) {
                console.log('Delete Error :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
            });
    };

    $scope.showUserFiles = function (item) {
        console.log(item);
        $scope.userfiles = item;
    };

    /****Modal start***/

    $scope.animationsEnabled = true;

    $scope.open = function (document,size, parentSelector) {
        console.log('test');
        var parentElem = parentSelector ?
            angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;
        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'userModal.html',
            controller: 'ModalInstanceCtrl',
            controllerAs: '$scope',
            size: size,
            appendTo: parentElem,
            resolve: {
                items: function () {
                    return document;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };

    /****Modal start***/


    $scope.activateUser = function (item) {
        $rootScope.loading = true;
        $http.post($rootScope.base_url + 'dashboard/user/activate/' + item.id, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined, 'Process-Data': false}
        })
            .then(function onSuccess(response) {
                loadUser();
                $rootScope.loading = false;
            }, function onError(response) {
                console.log('addError :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
            });
    };

    $scope.deActivateUser = function (item) {
        $rootScope.loading = true;
        $http.post($rootScope.base_url + 'dashboard/user/de-activate/' + item.id, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined, 'Process-Data': false}
        })
            .then(function onSuccess(response) {
                loadUser();
                $rootScope.loading = false;
            }, function onError(response) {
                console.log('addError :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
            });
    };

    $scope.generatePassword= function () {
        $scope.newuser.password = Math.random().toString(36).slice(-8);
    };

}]);




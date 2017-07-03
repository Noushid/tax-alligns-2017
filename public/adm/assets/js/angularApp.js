/**
 * Created by psybo-03 on 1/7/17.
 */

var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap','angularUtils.directives.dirPagination', 'ngFileUpload']);
app.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
    $locationProvider.hashPrefix('');
    $routeProvider
        .when('/', {
        })
        .when('/dashboard', {
            templateUrl: 'dashboard',
            controller: 'dashboardController'
        })
        .when('/gallery', {
            templateUrl: 'gallery',
            controller: 'galleryController'
        })
        .when('/user-profile',{
            templateUrl: 'change'
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
    //$scope.date = new Date();

    //check_thumb();

    //load_user();

    function load_user() {
        var url = $rootScope.base_url + 'admin/user';
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
                $window.location.href = base_url + 'admin/#/';
            }, function onError(response) {
                console.log('login error');
                console.log(response.data);
                $scope.error = response.data;
                $scope.showerror = true;
            });
    };

    function check_thumb() {
        $rootScope.loading = true;
        var url = $rootScope.base_url + 'admin/check-thumb';
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

        angular.forEach($scope.newuser, function (item, key) {
            fd.append(key, item);
        });
        var url = $rootScope.base_url + 'admin/change/submit';
        $http.post(url, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined, 'Process-Data': false}
        })
            .then(function onSuccess(response) {
                $rootScope.loading = false;
                console.log('profile changed');
                $scope.showmsg = true;
                $scope.formdisable = true;
                openModal('Username and Password changed.', 'sm');
                $scope.newuser = {};
                load_user();
                $scope.newuser.username = $scope.curuser;
                $scope.formdisable = false;
            }, function onError(response) {
                $rootScope.loading = false;
                $scope.showerror = true;
                openModal('Try again later.', 'sm');
                $scope.newuser = {};
                load_user();
                $scope.newuser.username = $scope.curuser;
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
 * Created by psybo-03 on 1/7/17.
 */
/**
 * Created by psybo-03 on 15/5/17.
 */

app.controller('galleryController', ['$scope', '$http', '$rootScope', '$location', 'Upload', '$timeout', '$filter', '$uibModal', '$log', '$document', function ($scope, $http, $rootScope, $location, Upload, $timeout, $filter, $uibModal, $log, $document) {

    $scope.galleries = [];
    $scope.newgallery = {};
    $scope.curgallery = {};
    $scope.files = [];
    $scope.errFiles = [];
    $scope.showform = false;
    $scope.message = {};
    $rootScope.url = $location.path().replace('/', '');
    $scope.uploaded = [];
    $scope.fileValidation = {};


    loadGallery();

    function loadGallery() {
        $http.get($rootScope.base_url + 'admin/gallery/get').then(function (response) {
            console.log(response.data);
            if (response.data) {
                $scope.galleries = response.data;
                $scope.showtable = true;
            } else {
                console.log('No data Found');
                $scope.showtable = false;
                $scope.message = 'No data found';
            }
        });
    }


    $scope.newGallery = function () {
        $scope.newgallery = {};
        $scope.filespre = [];
        $scope.uploaded = [];
        $scope.files = [];
        $scope.errFiles = [];
        $scope.showform = true;
        $scope.item_files = false;
    };

    $scope.showForm = function (item) {
        console.log(item);
        $scope.showform = true;
        $scope.curgallery = item;
        $scope.newgallery = angular.copy(item);
        $scope.item_files = item.files;
    };

    $scope.hideForm = function () {
        $scope.errFiles = '';
        $scope.showform = false;
    };

    $scope.addGallery = function () {
        $rootScope.loading = true;

        var fd = new FormData();

        angular.forEach($scope.newgallery, function (item, key) {
            fd.append(key, item);
        });

        fd.append('uploaded', JSON.stringify($scope.uploaded));

        if ($scope.newgallery['id']) {
            var url = $rootScope.base_url + 'admin/gallery/edit/' + $scope.newgallery.id;
            $http.post(url, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
                .then(function onSuccess(response) {
                    //$scope.galleries.push(response.data);
                    //loadGallery();
                    $scope.newgallery = {};
                    $scope.showform = false;
                    $rootScope.loading = false;
                    $scope.files = '';
                },function onError(response) {
                    console.log('edit Error :- Status :' + response.status + 'data : ' + response.data);
                    $rootScope.loading = false;
                    $scope.files = '';
                });
        } else {
            var url = $rootScope.base_url + 'admin/gallery/add';

            $http.post(url, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
                .then(function onSuccess(response) {
                    //$scope.galleries.push(response.data);
                    //loadGallery();
                    $scope.newgallery = {};
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

    $scope.deleteGallery = function (item) {
        $rootScope.loading = true;
        var url = $rootScope.base_url + 'admin/gallery/delete/' + item['id'];
        $http.delete(url)
            .then(function onSuccess(response) {
                var index = $scope.galleries.indexOf(item);
                $scope.galleries.splice(index, 1);
                alert(response.data.msg);
                loadGallery();
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
                url: $rootScope.base_url + 'admin/gallery/upload',
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
        var url = $rootScope.base_url + 'admin/gallery/delete-image/' + item['id'];
        $http.delete(url)
            .then(function onSuccess(response) {
                console.log('image deleted');
                /*remove deleted file from scope variable*/
                var index = $scope.item_files.indexOf(item);
                $scope.item_files.splice(index, 1);

                $rootScope.loading = false;
            },function onError(response) {
                console.log('Delete Error :- Status :' + response.status + 'data : ' + response.data);
                console.log(response.data);
                $rootScope.loading = false;
            });
    };

    $scope.showGalleryFiles = function (item) {
        console.log(item);
        $scope.galleryfiles = item;
    };



    /****Modal***/

    $scope.animationsEnabled = true;

    $scope.open = function (gallery,size, parentSelector) {
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
                    return gallery;
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






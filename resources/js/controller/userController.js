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
    $scope.validationError = {};
    $scope.btnDisabled = false;


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
        $scope.validationError = {};
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
                    if (response.statusText == 'email exist') {
                        console.log('email exist');
                        $scope.validationError.email = true;
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

    $scope.checkEmail= function (item) {
        var fd = new FormData();
        fd.append('email', item);
        var url = $rootScope.base_url + 'dashboard/user/check-email';

        $http.post(url, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined, 'Process-Data': false}
        })
            .then(function onSuccess(response) {

            }, function onError(response) {
                $scope.validationError.email = true;
                $scope.btnDisabled = true;
            });
    };
}]);




/**
 * Created by psybo-03 on 29/9/17.
 */

app.controller('DocTemplateController', ['$scope', '$http', '$rootScope', '$location', 'Upload', '$timeout', '$filter', '$uibModal', '$log', '$document', function ($scope, $http, $rootScope, $location, Upload, $timeout, $filter, $uibModal, $log, $document) {

    $scope.templates = [];
    $scope.newtemplate = {};
    $scope.template = {};
    $scope.files = [];
    $scope.errFiles = [];
    $scope.showform = false;
    $scope.message = {};
    $rootScope.url = $location.path().replace('/', '');
    $scope.uploaded = [];
    $scope.fileValidation = {};


    loadDocTemplate();

    function loadDocTemplate() {
        $http.get($rootScope.base_url + 'dashboard/doc-template/get').then(function (response) {
            console.log(response.data);
            if (response.data) {
                $scope.templates = response.data;
                $scope.showtable = true;
            } else {
                console.log('No data Found');
                $scope.showtable = false;
                $scope.message = 'No data found';
            }
        });
    }

    $scope.newDocTemplate = function () {
        $scope.template = {};
        $scope.filespre = [];
        $scope.uploaded = [];
        $scope.files = [];
        $scope.errFiles = [];
        $scope.showform = true;
        $scope.item_files = false;
    };

    $scope.editDocTemplate = function (item) {
        console.log(item);
        $scope.showform = true;
        $scope.template = item;
        $scope.template = angular.copy(item);
        $scope.item_files = item.file;
        $scope.files = [];
    };

    $scope.hideForm = function () {
        $scope.errFiles = '';
        $scope.showform = false;
    };

    $scope.addDocTemplate = function () {
        $rootScope.loading = true;

        var fd = new FormData();

        angular.forEach($scope.newtemplate, function (item, key) {
            fd.append(key, item);
        });

        fd.append('uploaded', JSON.stringify($scope.uploaded));

        if ($scope.newtemplate['id']) {
            var url = $rootScope.base_url + 'dashboard/doc-template/edit/' + $scope.newtemplate.id;
            $http.post(url, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
                .then(function onSuccess(response) {
                    loadDocTemplate();
                    $scope.newtemplate = {};
                    $scope.showform = false;
                    $rootScope.loading = false;
                    $scope.files = '';
                },function onError(response) {
                    console.log('edit Error :- Status :' + response.status + 'data : ' + response.data);
                    $rootScope.loading = false;
                    $scope.files = '';
                });
        } else {
            var url = $rootScope.base_url + 'dashboard/doc-template/add';

            $http.post(url, fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
                .then(function onSuccess(response) {
                    loadDocTemplate();
                    $scope.newtemplate = {};
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

    $scope.deleteDocTemplate = function (item) {
        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/doc-template/delete/' + item['id'];
        $http.delete(url)
            .then(function onSuccess(response) {
                var index = $scope.templates.indexOf(item);
                $scope.templates.splice(index, 1);
                alert(response.data.msg);
                loadDocTemplate();
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
                url: $rootScope.base_url + 'dashboard/doc-template/upload',
                data: {file: file}
            });

            file.upload.then(function (response) {
                $timeout(function () {
                    $scope.uploaded = response.data;
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
        var url = $rootScope.base_url + 'dashboard/doc-template/delete-image/' + item['id'];
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

    $scope.showDocTemplateFiles = function (item) {
        console.log(item);
        $scope.templatefiles = item;
    };


    $scope.enableDocTemplate= function (item) {
        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/doc-template/enable/' + item['id'];
        $http.put(url)
            .then(function onSuccess(response) {
                loadDocTemplate();
                $rootScope.loading = false;
            },function onError(response) {
                console.log('Delete Error :- Status :' + response.status + 'data : ' + response.data);
                loadDocTemplate();
                $rootScope.loading = false;
            });
    };

    $scope.disableDocTemplate= function (item) {
        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/doc-template/disable/' + item['id'];
        $http.put(url)
            .then(function onSuccess(response) {
                loadDocTemplate();
                $rootScope.loading = false;
            },function onError(response) {
                loadDocTemplate();
                console.log('Delete Error :- Status :' + response.status + 'data : ' + response.data);
                $rootScope.loading = false;
            });
    }

}]);






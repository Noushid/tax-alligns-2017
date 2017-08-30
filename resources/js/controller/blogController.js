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

        $rootScope.loading = true;
        var url = $rootScope.base_url + 'dashboard/blog/delete-image/' + item['id'];
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






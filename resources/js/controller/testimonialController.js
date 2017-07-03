/**
 * Created by psybo-03 on 1/7/17.
 */
/**
 * Created by psybo-03 on 15/5/17.
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
        $http.get($rootScope.base_url + 'admin/testimonial/get').then(function (response) {
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
            var url = $rootScope.base_url + 'admin/testimonial/edit/' + $scope.newtestimonial.id;
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
            var url = $rootScope.base_url + 'admin/testimonial/add';

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
        var url = $rootScope.base_url + 'admin/testimonial/delete/' + item['id'];
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
                url: $rootScope.base_url + 'admin/testimonial/upload',
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
        var url = $rootScope.base_url + 'admin/testimonial/delete-image/' + item['id'];
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






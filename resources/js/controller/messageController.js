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






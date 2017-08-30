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

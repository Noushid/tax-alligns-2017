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
        .when('/testimonial', {
            templateUrl: 'testimonial',
            controller: 'testimonialController'
        })
        .when('/blog', {
            templateUrl: 'blog',
            controller: 'blogController'
        })
        .when('/document', {
            templateUrl: 'document',
            controller: 'documentController'
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




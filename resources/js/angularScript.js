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




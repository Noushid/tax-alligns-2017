/**
 * Created by psybo-03 on 1/7/17.
 */

var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename');

var config = {
    publicDir: 'public/',
    adminJsDir: 'public/adm/assets/js/',
    jsResource: 'resources/js/',
    nodeDir: 'node_modules/'
};

gulp.task('scripts', function () {
    return gulp.src([
        config.jsResource + '*.js',
        config.jsResource + 'controller/*.js'
    ])
        .pipe(concat('angularApp.js'))
        .pipe(gulp.dest(config.adminJsDir))
        .pipe(rename('angularApp.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(config.adminJsDir));
});

gulp.task('mix', function () {
    return gulp.src([
        config.nodeDir + 'angular/angular.js',
        config.nodeDir + 'angular-route/angular-route.js',
        config.nodeDir + 'angular-ui-bootstrap/dist/ui-bootstrap-tpls.js',
        config.nodeDir + 'angular-utils-pagination/dirPagination.js',
        config.nodeDir + 'ng-file-upload/dist/ng-file-upload.js',
        config.nodeDir + 'ng-file-upload/dist/ng-file-upload-shim.js'
    ])
        .pipe(concat('angular-bootstrap.js'))
        .pipe(gulp.dest(config.adminJsDir))
        .pipe(rename('angular-bootstrap.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(config.adminJsDir));
});

gulp.task('default', ['scripts', 'mix']);
/**
 * Created by psybo-03 on 1/7/17.
 */

var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    concateCss = require('gulp-concat-css'),
    cleanCSS = require('gulp-clean-css');


var config = {
    publicDir: 'public/',
    adminJsDir: 'public/adm/assets/js/',
    adminCssDir: 'public/adm/assets/css/',
    adminImgDir: 'public/adm/assets/img/',
    jsResource: 'resources/js/',
    cssResource: 'resources/css/',
    imgResource: 'resources/images/',
    nodeDir: 'node_modules/',
    bowerDir: 'bower_components/'
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
        config.nodeDir + 'ng-file-upload/dist/ng-file-upload-shim.js',
        config.bowerDir + 'ng-ckeditor/ng-ckeditor.js',
        config.bowerDir + 'ng-ckeditor/libs/ckeditor.js',
        config.bowerDir + 'angular-timeago/dist/angular-timeago.js',
        config.bowerDir + 'lightbox2/dist/js/lightbox-plus-jquery.js'
    ])
        .pipe(concat('angular-bootstrap.js'))
        .pipe(gulp.dest(config.adminJsDir))
        .pipe(rename('angular-bootstrap.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(config.adminJsDir));
});

gulp.task('js', function () {
    return gulp.src([
        config.nodeDir + 'lightbox2/dist/js/lightbox-plus-jquery.js'
    ])
        .pipe(concat('lightbox-plus-jquery.js'))
        .pipe(gulp.dest(config.adminJsDir))
        .pipe(rename('lightbox-plus-jquery.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(config.adminJsDir));
});

gulp.task('style', function () {
    return gulp.src([
        config.cssResource + '**.css'
    ])
        .pipe(concateCss('app.css'))
        .pipe(gulp.dest(config.adminCssDir))
        .pipe(rename('app.min.css'))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest(config.adminCssDir));

});


/*Copy images to resources*/
gulp.task('images', function() {
    return gulp.src([
        config.nodeDir + 'lightbox2/dist/images/**.*'
    ])
        .pipe(gulp.dest(config.imgResource));
});

/*Copy css to resources*/
gulp.task('css', function() {
    return gulp.src([
        config.nodeDir + 'lightbox2/dist/css/lightbox.css'
    ])
        .pipe(gulp.dest(config.cssResource));
});

gulp.task('install', ['images', 'css', 'js']);
gulp.task('default', ['scripts', 'mix', 'style']);
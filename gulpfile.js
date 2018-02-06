var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var cssmin = require('gulp-cssmin');
var htmlmin = require('gulp-htmlmin');
var babel = require("gulp-babel");
var gulpif = require('gulp-if');
var notify = require("gulp-notify");
var argv = require('yargs').argv;
var cssFile = [];

console.info('Is production env: ' + (isProduction() ? 'yes' : 'no'));

function isProduction() {
    // if we use gulp --production then "force" environment to prod
    // otherwise check env variable
    return argv.production || process.env.NODE_ENV === 'production';
}

function swallowError (error) {
    console.log(error.toString());
    this.emit('end');
}

gulp.task('vendor-js', function () {
    return gulp.src([
        './node_modules/lodash/lodash.js',
        './node_modules/angular/angular.js',
        './node_modules/angular-animate/angular-animate.js',
        './node_modules/angular-resource/angular-resource.js',
        './node_modules/angular-sanitize/angular-sanitize.js',
        './node_modules/ng-toast/dist/ngToast.js',
        './node_modules/angular-jwt/dist/angular-jwt.js',
        './node_modules/angular-ui-router/release/angular-ui-router.js',
        './node_modules/angular-route/angular-route.js',
        './node_modules/angular-local-storage/dist/angular-local-storage.js',
        './node_modules/summernote/dist/summernote.js',
    ])
        .pipe(concat('vendor.min.js'))
        .pipe(gulpif(isProduction(), uglify({mangle: false, output: {
            max_line_len: 5000000
        }})))
        .pipe(gulp.dest('public/js/vendor/'));
});

gulp.task('vendor-css', function () {
    return gulp.src([
        './node_modules/ng-toast/dist/ngToast.css',
        './node_modules/ng-toast/dist/ngToast-animations.css',
        './node_modules/summernote/dist/summernote.css',
    ])
        .pipe(concat('vendor.min.css'))
        .pipe(gulp.dest('public/css/vendor/'));
});

gulp.task('fonts', function () {
    return gulp.src([
        './node_modules/summernote/dist/font/summernote.woff',
        './node_modules/summernote/dist/font/summernote.ttf',
        './node_modules/summernote/dist/font/summernote.eot',
    ])
        .pipe(gulp.dest('public/css/vendor/font/'));
});

gulp.task('views', function () {
    return gulp.src([
        './resources/assets/frontend/views/**/*.html'
    ])
        .pipe(htmlmin({collapseWhitespace: true}))
        .pipe(gulp.dest('public/frontend/views/'));
});

gulp.task('scripts', function () {
    return gulp.src([
        './resources/assets/frontend/js/**/*.js'
    ])
        .pipe(concat('frontend.min.js'))
        .pipe(gulpif(!isProduction(), babel({ compact: false})))
        .on('error', swallowError)
        .pipe(gulpif(isProduction(), babel({ compact: true})))
        .pipe(gulp.dest('public/js/frontend/'))
        .pipe(notify("Scripts compiled"));
});

gulp.task('styles-backend', function () {
    return gulp.src('./resources/assets/backend/sass/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(cssmin())
        .pipe(concat('backend.min.css'))
        .pipe(gulp.dest('public/css/'))
        .pipe(notify("Styles compiled"));
});

gulp.task('styles-front', function () {
    return gulp.src('./resources/assets/frontend/sass/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(cssmin())
        .pipe(concat('frontend.min.css'))
        .pipe(gulp.dest('public/css/'))
        .pipe(notify("Styles compiled"));
});

gulp.task('watch', function () {
    gulp.watch('./resources/assets/frontend/js/**/*.js', ['scripts']);
    gulp.watch('./resources/assets/js/**/*.js', ['scripts']);
    gulp.watch('./resources/assets/backend/sass/**/*.scss', ['styles-backend']);
    gulp.watch('./resources/assets/frontend/sass/**/*.scss', ['styles-front']);
    gulp.watch('./resources/assets/frontend/views/**/*.html', ['views']);
    gulp.watch(cssFile, ['styles']);
});

gulp.task('vendor', ['vendor-js', 'vendor-css', 'fonts']);
gulp.task('default', ['views', 'scripts', 'styles-backend', 'styles-front']);
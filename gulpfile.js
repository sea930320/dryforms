var gulp = require('gulp');
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

    ])
        .pipe(concat('vendor.min.js'))
        .pipe(gulpif(isProduction(), uglify({mangle: false, output: {
            max_line_len: 5000000
        }})))
        .pipe(gulp.dest('public/assets/'));
});

gulp.task('vendor-css', function () {
    return gulp.src([])
        .pipe(concat('vendor.min.css'))
        .pipe(gulp.dest('public/assets/'));
});

gulp.task('fonts', function () {
    return gulp.src([])
        .pipe(gulp.dest('public/fonts/'));
});

gulp.task('views', function () {
    return gulp.src([
        './resources/assets/views/**/*.html'
    ])
        .pipe(htmlmin({collapseWhitespace: true}))
        .pipe(gulp.dest('public/assets/views/'));
});

gulp.task('scripts', function () {
    return gulp.src([
        './resources/assets/js/**/*.js'
    ])
        .pipe(concat('app.min.js'))
        .pipe(gulpif(!isProduction(), babel({ compact: false})))
        .on('error', swallowError)
        .pipe(gulpif(isProduction(), babel({ compact: true})))
        .pipe(gulp.dest('public/assets/'))
        .pipe(notify("Scripts compiled"));
});

gulp.task('styles', function () {
    return gulp.src(cssFile)
        .pipe(cssmin())
        .pipe(concat('app.min.css'))
        .pipe(gulp.dest('public/assets/css/'))
        .pipe(notify("Styles compiled"));
});

gulp.task('watch', function () {
    gulp.watch('./resources/assets/js/**/*.js', ['scripts']);
    gulp.watch('./resources/assets/views/**/*.html', ['views']);
    gulp.watch(cssFile, ['styles']);
});

gulp.task('vendor', ['vendor-js', 'vendor-css', 'fonts']);
gulp.task('default', ['views', 'scripts', 'styles']);
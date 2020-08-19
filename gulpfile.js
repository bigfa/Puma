var gulp = require("gulp");
var babel = require("gulp-babel");
var uglify = require("gulp-uglifyjs");
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var rev = require('gulp-rev');
var nano = require('gulp-cssnano');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var less = require('gulp-less');

gulp.task('less',function() {
    return gulp.src(['css/app.less'])
        .pipe(less().on('error', function (e){
            console.error(e.message);
            this.emit('end');
        }))
        .pipe(postcss([autoprefixer]))
        .pipe(nano())
        .pipe(gulp.dest('build/css'))
});

gulp.task("uglify", function() {
    return gulp.src(['js/base.js'])
        .pipe(concat('all.js'))
        .pipe(babel({
            presets: ['env']
        }))
        .pipe(uglify('all.js',{
            mangle: true,
            }))
        .pipe(rename('app.js'))
        //.pipe(rev())
        .pipe(gulp.dest("build/js"));
});

gulp.task('watch',function() {
    gulp.watch(['css/app.less','css/less-module/*.less'],['less']);
    gulp.watch(['js/cow.js','js/base.js'], ['uglify']);
});

gulp.task('default', ['less','uglify','watch']);
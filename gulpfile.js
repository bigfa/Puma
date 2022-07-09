'use strict';

const gulp = require('gulp');
const babel = require('gulp-babel');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const plumber = require('gulp-plumber');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');

function css() {
    return gulp
        .src('./scss/app.scss')
        .pipe(plumber())
        .pipe(sass({ outputStyle: 'compressed' }))
        .pipe(rename('misc.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(gulp.dest('./build/css/'));
}

function images() {
    return gulp.src('./images/*.{png,jpg,gif,svg}').pipe(gulp.dest('./build/images/'));
}

function fonts() {
    return gulp.src('./fonts/*').pipe(gulp.dest('./build/fonts/'));
}

// Transpile, concatenate and minify scripts
function scripts() {
    return gulp
        .src(['./js/app.js'])
        .pipe(plumber())
        .pipe(concat('all.bundle.js'))
        .pipe(
            babel({
                presets: ['@babel/preset-env'],
            })
        )
        .pipe(uglify())
        .pipe(gulp.dest('./build/js/'));
}

// Watch files
function watchFiles() {
    gulp.watch(['./js/app.js'], gulp.series(scripts));
    gulp.watch(['./scss/app.scss'], gulp.series(css));
}

// define complex tasks
const js = gulp.series(scripts);
const watch = gulp.parallel(watchFiles);
const build = gulp.parallel(watch, gulp.parallel(css, js, images, fonts));

exports.css = css;
exports.js = js;
exports.build = build;
exports.watch = watch;
exports.default = build;

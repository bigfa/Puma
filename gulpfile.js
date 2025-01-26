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
const ts = require('gulp-typescript');

function settingCss() {
    return gulp
        .src('./scss/setting.scss')
        .pipe(plumber())
        .pipe(sass({ outputStyle: 'compressed' }))
        .pipe(rename({ suffix: '.min' }))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(gulp.dest('./build/css/'));
}

function css() {
    return gulp
        .src('./scss/app.scss')
        .pipe(plumber())
        .pipe(sass({ outputStyle: 'compressed' }))
        .pipe(rename('app.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./build/css/'));
}

function images() {
    return gulp.src('./images/*.{png,jpg,gif,svg}').pipe(gulp.dest('./build/images/'));
}

function fonts() {
    return gulp.src('./fonts/*').pipe(gulp.dest('./build/fonts/'));
}

// Transpile, concatenate and minify scripts
function typescripts() {
    return gulp
        .src(['./ts/extensions/*', './ts/app.ts', './ts/modules/*'])
        .pipe(
            ts({
                noImplicitAny: true,
                outFile: 'app.js',
                target: 'es5',
            })
        )
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./build/js/'));
}

function setting() {
    return gulp
        .src(['./ts/setting.ts'])
        .pipe(plumber())
        .pipe(
            ts({
                noImplicitAny: true,
                outFile: 'setting.js',
                target: 'es5',
            })
        )
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./build/js/'));
}

// Watch files
function watchFiles() {
    gulp.watch(['./ts/ts.js'], gulp.series(typescripts));
    gulp.watch(['./scss/app.scss', './scss/modules/*', './scss/templates/*'], gulp.series(css));
    gulp.watch(['./scss/setting.scss'], gulp.series(settingCss));
    gulp.watch(['./js/setting.ts'], gulp.series(setting));
}

// define complex tasks
const js = gulp.series(typescripts);
const watch = gulp.parallel(watchFiles);
const build = gulp.parallel(watch, gulp.parallel(css, js, images, settingCss, setting, fonts));

exports.css = css;
exports.js = js;
exports.build = build;
exports.watch = watch;
exports.default = build;

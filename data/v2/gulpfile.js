// Require our dependencies
//const babel = require("gulp-babel");
const gulp = require('gulp');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const imagemin = require('gulp-imagemin');
const del = require('del');
const clean = require('gulp-clean');
const rename = require('gulp-rename');
const browserSync = require('browser-sync').create();
const cssnano = require('gulp-cssnano');
const zip = require('gulp-zip');
const unzip = require('gulp-unzip');
const minimatch = require('minimatch');
const mkdirp = require('mkdirp');

var paths = {
  assets: 'assets/',
  home: 'wc-bill-materials.php',
  js: 'assets/',
  css: 'assets/',
  img: 'assets/images/',
  dist: 'dist/',
  logs: 'logs/',
  data: 'assets/data/',
  archive: 'assets/archive/',
  dist_js: 'dist/',
  dist_css: 'dist/',
  dist_img: 'dist/images/',
  includes: 'includes/',
  classes: 'classes/*.php',
};

// Not all tasks need to use streams
// A gulpfile is just another node program and you can use any package available on npm
gulp.task('purge', function() {
  gulp.src(paths.dist_img + '*').pipe(clean());
  gulp.src(paths.dist + '*.css').pipe(clean());
  gulp.src(paths.dist + '*.js').pipe(clean());
});

// Copy all static images
gulp.task('imagemin', function() {
  gulp.src(paths.img).pipe(imagemin()).pipe(gulp.dest(paths.dist_img));
});

gulp.task('cssnano', function() {
  gulp.src(paths.css + '*.css').
      pipe(cssnano()).
      pipe(rename({suffix: '.min'})).
      pipe(gulp.dest(paths.dist_css));
});

gulp.task('scripts', function() {
  return gulp.src(paths.data).pipe(concat('*')).pipe(gulp.dest('archive'));
});

/**
 * Minify compiled JavaScript.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task('uglify', function() {

  gulp.src(paths.js + '*.js').
      pipe(uglify()).
      pipe(rename({suffix: '.min'})).
      pipe(gulp.dest(paths.dist_js));
});

gulp.task('zip', function() {
  gulp.src('assets/data/*').
      pipe(zip('archive.zip')).
      pipe(gulp.dest('assets/'));
});

gulp.task('unzip', function() {
  gulp.src('archive/*').pipe(unzip()).pipe(gulp.dest('dist'));
});

// Static Server + watching scss/html files
gulp.task('serve', function() {

  browserSync.init({
    proxy: 'http://localhost/wp/wp-admin/',
  });

});

// Rerun the task when a file changes
gulp.task('watch', function() {
  //gulp.watch(paths.scripts, ["scripts"]);
  gulp.watch(paths.home).on('change', browserSync.reload);
  gulp.watch('gulpfile.js').on('change', browserSync.reload);
  gulp.watch(paths.assets + '*').on('change', browserSync.reload);
  //gulp.watch(paths.assets).on("", browserSync.reload);
  gulp.watch(paths.classes).on('change', browserSync.reload);
  gulp.watch(paths.includes).on('add', browserSync.reload);
});

gulp.task('default',
    ['purge', 'imagemin', 'cssnano', 'uglify', 'serve', 'watch']);
gulp.task('clean', ['purge', 'imagemin', 'cssnano', 'uglify', 'zip']);
gulp.task('live', ['serve', 'watch']);


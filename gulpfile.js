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
	acf: 'acf/',
	app: 'app/',
	assets: 'assets/',
	classes: 'classes/',
	data: 'data/',
	dist: 'dist/',
	logs: 'logs/',
	includes: 'includes/',
	images: 'images/',
	js: 'js/',
	css: 'css/',
	export: 'export/',
	endpoint: 'Endpoint/',
	classes: 'classes/*.php',
	assets: 'assets/',
	home: 'wc-bom.php',
	js: 'assets/',
	css: 'assets/',
	img: 'assets/images/*',
	dist: 'dist/',
	logs: 'logs/',
	data: 'assets/data/',
	archive: 'assets/archive/',
	dist_js: 'dist/',
	dist_css: 'dist/',
	dist_img: 'dist/images/',
	includes: 'includes/*',
	classes: 'classes/*.php',
	host: 'http://localhost/wordpress/wp-admin',
	php: '*.php',
	wpb: 'wp-bom.php',
};

// Not all tasks need to use streams
// A gulpfile is just another node program and you can use any package available on npm
gulp.task('purge', function () {
	gulp.src(paths.dist + '*').pipe(clean());
});

// Copy all static images
gulp.task('imagemin', function () {
	gulp.src(paths.assets + 'images/*').pipe(imagemin()).pipe(gulp.dest(paths.images));
});

gulp.task('cssnano', function () {
	gulp.src(paths.dist + '*.css').pipe(cssnano()).pipe(rename({suffix: '.min'})).pipe(gulp.dest(paths.dist + 'css/'));
});
//
//gulp.task('scripts', function() {
//  return gulp.src(paths.data).pipe(concat('*')).pipe(gulp.dest('archive'));
//});

/**
 * Minify compiled JavaScript.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task('uglify', function () {

	gulp.src(paths.dist + '*.js').pipe(uglify()).pipe(rename({suffix: '.min'})).pipe(gulp.dest(paths.dist + 'js/'));
});
//
//gulp.task('zip', function() {
//  gulp.src('assets/data/*').
//      pipe(zip('archive.zip')).
//      pipe(gulp.dest('assets/'));
//});

//gulp.task('unzip', function() {
//  gulp.src('archive/*').pipe(unzip()).pipe(gulp.dest('dist'));
//});

// Static Server + watching scss/html files
gulp.task('serve', function () {

	browserSync.init({
		proxy: paths.host
	});

});

// Rerun the task when a file changes
gulp.task('watch', function () {
	//gulp.watch(paths.scripts, ["scripts"]);
	gulp.watch(paths.wpb).on('change', browserSync.reload);
	gulp.watch(paths.includes + '*').on('change', browserSync.reload);
	gulp.watch(paths.classes + '*').on('change', browserSync.reload);
	gulp.watch(paths.assets + '*').on('change', browserSync.reload);
	gulp.watch(paths.dist + '*').on('change', browserSync.reload);
});


gulp.task('clean', ['purge', 'imagemin', 'cssnano', 'uglify']);
gulp.task('run', ['imagemin', 'cssnano', 'uglify', 'serve', 'watch']);
gulp.task('live', ['serve', 'watch']);


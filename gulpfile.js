// Gulpfile.js running on stratumui, 
// a css framework available on npmjs.com
var gulp 	        = require('gulp'),
  	sass 	        = require('gulp-sass'),
  	concat 	        = require('gulp-concat'),
  	uglify 	        = require('gulp-uglify'),
    rename 	        = require('gulp-rename');
    postcss         = require('gulp-postcss');
    autoprefixer    = require('autoprefixer');
    cssnano         = require('cssnano');
    sourcemaps      = require('gulp-sourcemaps');  

var paths = {
  styles: {
    src: './sass/*.scss',
    dest: './dist/'
  },
  scripts: {
    src: './js/*.js',
    dest: './dist/'
  }
};

function styles() {
  return gulp
  	.src(paths.styles.src)
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(sourcemaps.write())
	.pipe(rename({
	  basename: 'style',
	  suffix: '.min'
	}))
    .pipe(gulp.dest(paths.styles.dest));
}

function scripts() {
  return gulp
    .src(paths.scripts.src)
    .pipe(sourcemaps.init())
	.pipe(uglify())
	.pipe(concat('main.min.js'))
	.pipe(gulp.dest(paths.scripts.dest));
}

function watch() {
  gulp
	  .watch(paths.scripts.src, scripts);
  gulp
  	.watch(paths.styles.src, styles);
}

var build = gulp.parallel(styles, scripts, watch);

gulp
  .task(build);
gulp
  .task('default', build);
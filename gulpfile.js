'use strict';

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    watch = require('gulp-watch'),
    livereload = require('gulp-livereload'),
    autoprefixer = require('gulp-autoprefixer'),
    cssnano = require('gulp-cssnano'),
    rename = require('gulp-rename'),
    notify = require('gulp-notify'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    cache = require('gulp-cache');


gulp.task('sass', function(){
  return gulp.src('./assets/stylesheets/style.scss')
    .pipe(sourcemaps.init())
    .pipe(autoprefixer({
      browsers: ['last 2 version', '> 5%', 'ie 8', 'ie 9'],
      cascade: false
    }))
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./build/'))
    .pipe(rename({suffix: '.min'}))
    .pipe(cssnano())
    .pipe(gulp.dest('./build/'))
    .pipe(notify({message: 'Sass done'}));
});

gulp.task('compress', function(){
  gulp.src([
    'assets/js/navigation.js',
    'assets/js/skip-link-focus-fix.js',
    'assets/js/app.js'
  ])
  .pipe(concat('production.js'))
  .on('error', notify.onError("Error: <%= error.message %>"))
  .pipe(gulp.dest('./build/'))
  .pipe(uglify())
  .on('error', notify.onError("Error: <%= error.message %>"))
  .pipe(rename({
      extname: ".min.js"
   }))
   .pipe(gulp.dest('./build/'))
   .pipe(notify({message: 'JS done'}));
});


gulp.task('images', function(){
  return gulp.src('assets/img/**/*.+(png|jpg|jpeg|gif|svg)')
  // Caching images that ran through imagemin
  .pipe(cache(imagemin({
      interlaced: true
    })))
  .pipe(gulp.dest('img'))
  .pipe(notify({message: 'Images done'}));
});



gulp.task('watch', function(){

  gulp.watch('assets/stylesheets/**/*.scss', ['sass']);

  gulp.watch('assets/js/**/*.js', ['compress']);

  gulp.watch('assets/img/**/*.+(png|jpg|jpeg|gif|svg)', ['images']);

  livereload.listen();
  // Other watchers
  gulp.watch(['build/**']).on('change', livereload.changed);
  gulp.watch('**/*.php').on('change', livereload.reload);
});

gulp.task('default',['compress', 'sass', 'images']);

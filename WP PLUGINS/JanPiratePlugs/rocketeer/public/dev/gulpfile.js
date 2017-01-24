/**
 * Created by jaskokoyn on 1/28/2016.
 */
'use strict';

var gulp                                =   require('gulp');
var rename                              =   require('gulp-rename');
var uglify                              =   require('gulp-uglify');

var DEST                                =   '../components/core/js/';
var SRC                                 =   '../components/core/js/*.js';

gulp.task('default', function() {
    return gulp.src(SRC)
        .pipe(uglify()) // Minify
        .pipe(rename({ extname: '.min.js' }))// Rename with .min
        .pipe(gulp.dest(DEST)); // Output
});
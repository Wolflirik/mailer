var gulp = require('gulp'),
    prefixer = require('gulp-autoprefixer'),
    watch = require('gulp-watch'),
    sass = require('gulp-sass'),
    cssmin = require('gulp-minify-css');


gulp.task('css-build', function(){
    gulp.src('style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(prefixer({browsers: ['last 10 versions'],}))
        .pipe(cssmin())
        .pipe(gulp.dest('style/'));
});



gulp.task('build', [
    'css-build'
]);

gulp.task('watch', ['css-build'], function(){
    gulp.watch(['style.scss'], ['css-build']);
});


gulp.task('default', ['build', 'watch']);
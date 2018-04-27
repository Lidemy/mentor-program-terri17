var gulp = require('gulp');
var sass = require('gulp-sass');    // 把 scss 編譯成 css
var babel = require ('gulp-babel');  // 把 js 用 babel 轉成 ES5 語法
var uglifyjs = require ('gulp-uglify'); // 把 css  壓縮
var uglifycss = require ('gulp-uglifycss'); // 把 js 壓縮
var clean = require('gulp-clean');      // 把之前生產的檔案刪除
var rename = require('gulp-rename');    //重新命名
var runSequence = require('run-sequence');  //管理流程

gulp.task('css',function(){
    return gulp.src('src/css/*.scss')
    .pipe(sass())
    .pipe(gulp.dest('dist/css'))
    .pipe(uglifycss())
    .pipe(rename({
        suffix:'-mini'
    }))
    .pipe(gulp.dest('dist/css'))
})

gulp.task('babel', function(){
    return gulp.src('src/js/*.js')
    .pipe(babel({
        presets:['env']
    }))
    .pipe(gulp.dest('dist/js'))
    .pipe(uglifyjs())
    .pipe(rename({
        suffix:'-mini'
    }))
    .pipe(gulp.dest('dist/js'))
});

gulp.task('clean',function(){
    return gulp.src('dist',{read:false})
            .pipe(clean());
})

gulp.task('default',function(callback){
    runSequence ('clean',
                ['css','babel'], 
                callback)   // 先跑clean，css與babel同時進行
})

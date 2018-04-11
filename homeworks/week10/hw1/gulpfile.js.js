const gulp = require('gulp');
const sass = require('gulp-sass');
const babel = require('gulp-babel');
const uglifycss = require('gulp-uglifycss');
const uglify = require('gulp-uglify');
const pump = require('pump');

//把 scss 編譯成 css
gulp.task('sass',function(){
	return gulp.src('.scss/**/*.scss')
	.pipe(sass().on('error',sass.logError))
	.pipe(gulp.dest('css'));
})

//把 js 用 babel 轉成 ES5 語法
gulp.task('default',function(){
	gulp.src('src/app.js')
		.pipe(babel({
			presets:['env']
		}))
		.pipe(gulp.dest('dist'))
});

//把 css 壓縮
gulp.task('css',function(){
	gulp.src('./style/**/*css')
		.pipe(uglifycss({
			"maxLineLen":80,
			"uglyComments":true
		}))
		.pipe(gulp.dest('./dist/'));
});


//把 js 壓縮
gulp.task('compress',function(cb){
	pump([
		gulp.src('lib/*js'),
		uglify(),
		gulp.dest('dist')
		],
		cb
	);
});

gulp.task('default',['sass','default','css','compress']);


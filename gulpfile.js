import pkg from 'gulp';
import babel from 'gulp-babel';
import beeper from 'beeper';
import browserSync from 'browser-sync';
import concat from 'gulp-concat';
import del from 'del';
import log from 'fancy-log';
import fs from 'fs';
import imagemin from 'gulp-imagemin';
import partialimport from 'postcss-easy-import';
import plumber from 'gulp-plumber';
import postcss from 'gulp-postcss';
import postCSSMixins from 'postcss-mixins';
import autoprefixer from 'autoprefixer';
import postcssPresetEnv from 'postcss-preset-env';
import sourcemaps from 'gulp-sourcemaps';
import uglify from 'gulp-uglify';
import zip from 'gulp-vinyl-zip';
import dotenv from 'dotenv';
import cssnano from 'cssnano';

const { series, dest, src, watch } = pkg;

dotenv.config();

/* -------------------------------------------------------------------------------------------------
Theme Name
-------------------------------------------------------------------------------------------------- */
const themeName = 'wordpressify';

/* -------------------------------------------------------------------------------------------------
PostCSS Plugins
-------------------------------------------------------------------------------------------------- */
const pluginsListDev = [
	partialimport,
	postcssPresetEnv({
		stage: 0,
		features: {
			'nesting-rules': true,
			'color-function': true,
			'custom-media-queries': true,
		},
	}),
	postCSSMixins,
	autoprefixer,
];

const pluginsListProd = [
	partialimport,
	postcssPresetEnv({
		stage: 0,
		features: {
			'nesting-rules': true,
			'color-function': true,
			'custom-media-queries': true,
		},
	}),
	postCSSMixins,
	autoprefixer,
	cssnano({
		preset: [
			'default',
			{
				discardComments: false,
			},
		],
	}),
];

/* -------------------------------------------------------------------------------------------------
Header & Footer JavaScript Boundles
-------------------------------------------------------------------------------------------------- */
const headerJS = ['./node_modules/jquery/dist/jquery.js'];
const footerJS = ['./src/assets/js/**'];

/* -------------------------------------------------------------------------------------------------
Environment Tasks
-------------------------------------------------------------------------------------------------- */

function registerCleanup(done) {
	process.on('SIGINT', () => {
		process.exit(0);
	});
	done();
}

async function envRebuild(done) {
	await del(['build', 'xdebug', 'config/php.ini', '.env']);
	done();
}
envRebuild.displayName = 'env:rebuild';
export { envRebuild };

/* -------------------------------------------------------------------------------------------------
Development Tasks
-------------------------------------------------------------------------------------------------- */
function devServer() {
	browserSync({
		logPrefix: '🐳 WordPressify',
		proxy: {
			target: `webserver:8080`,
		},
		host: 'localhost',
		port: parseInt(process.env.PROXY_PORT),
		notify: false,
		open: false,
		logConnections: true,
		socket: {
			domain: `localhost:${parseInt(process.env.PROXY_PORT)}`,
		}
	});

	watch('./src/assets/css/**/*.css', stylesDev);
	watch('./src/assets/js/**', series(footerScriptsDev, Reload));
	watch('./src/assets/img/**', series(copyImagesDev, Reload));
	watch('./src/assets/fonts/**', series(copyFontsDev, Reload));
	watch('./src/theme/**', series(copyThemeDev, stylesDev, Reload));
	watch('./src/plugins/**', series(pluginsDev, Reload));
}

function Reload(done) {
	browserSync.reload();
	done();
}

function copyWelcomeIndex() {
	return src('./installer/welcome.html').pipe(dest('./build/wordpress'));
}

function copyThemeDev() {
	if (!fs.existsSync('./build')) {
		log(buildNotFound);
		process.exit(1);
	} else {
		return src('./src/theme/**').pipe(
			dest('./build/wordpress/wp-content/themes/' + themeName)
		);
	}
}

function copyImagesDev() {
	return src('./src/assets/img/**').pipe(
		dest('./build/wordpress/wp-content/themes/' + themeName + '/img')
	);
}

function copyFontsDev() {
	return src('./src/assets/fonts/**').pipe(
		dest('./build/wordpress/wp-content/themes/' + themeName + '/fonts')
	);
}

function stylesDev() {
	return src('./src/assets/css/style.css')
		.pipe(plumber({ errorHandler: onError }))
		.pipe(sourcemaps.init())
		.pipe(postcss(pluginsListDev))
		.pipe(sourcemaps.write('.'))
		.pipe(dest('./build/wordpress/wp-content/themes/' + themeName))
		.pipe(browserSync.stream({ match: '**/*.css' }));
}

function headerScriptsDev() {
	return src(headerJS)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(sourcemaps.init())
		.pipe(concat('header-bundle.js'))
		.pipe(sourcemaps.write('.'))
		.pipe(dest('./build/wordpress/wp-content/themes/' + themeName + '/js'));
}

function footerScriptsDev() {
	return src(footerJS)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(sourcemaps.init())
		.pipe(
			babel({
				presets: ['@babel/preset-env'],
			})
		)
		.pipe(concat('footer-bundle.js'))
		.pipe(sourcemaps.write('.'))
		.pipe(dest('./build/wordpress/wp-content/themes/' + themeName + '/js'));
}

function pluginsDev() {
	return src(['./src/plugins/**', '!./src/plugins/README.md']).pipe(
		dest('./build/wordpress/wp-content/plugins')
	);
}

const dev = series(
	registerCleanup,
	copyWelcomeIndex,
	copyThemeDev,
	copyImagesDev,
	copyFontsDev,
	stylesDev,
	headerScriptsDev,
	footerScriptsDev,
	pluginsDev,
	devServer
);
dev.displayName = 'dev';

export { dev };

/* -------------------------------------------------------------------------------------------------
Production Tasks
-------------------------------------------------------------------------------------------------- */
async function cleanProd() {
	await del(['./dist']);
}

function copyThemeProd() {
	return src(['./src/theme/**', '!./src/theme/**/node_modules/**']).pipe(
		dest('./dist/themes/' + themeName)
	);
}

function copyFontsProd() {
	return src('./src/assets/fonts/**').pipe(
		dest('./dist/themes/' + themeName + '/fonts')
	);
}

function stylesProd() {
	return src('./src/assets/css/style.css')
		.pipe(plumber({ errorHandler: onError }))
		.pipe(postcss(pluginsListProd))
		.pipe(dest('./dist/themes/' + themeName));
}

function headerScriptsProd() {
	return src(headerJS)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(concat('header-bundle.js'))
		.pipe(uglify())
		.pipe(dest('./dist/themes/' + themeName + '/js'));
}

function footerScriptsProd() {
	return src(footerJS)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(
			babel({
				presets: ['@babel/preset-env'],
			})
		)
		.pipe(concat('footer-bundle.js'))
		.pipe(uglify())
		.pipe(dest('./dist/themes/' + themeName + '/js'));
}

function pluginsProd() {
	return src(['./src/plugins/**', '!./src/plugins/**/*.md']).pipe(
		dest('./dist/plugins')
	);
}

function processImages() {
	return src('./src/assets/img/**')
		.pipe(plumber({ errorHandler: onError }))
		.pipe(imagemin())
		.pipe(dest('./dist/themes/' + themeName + '/img'));
}

function zipProd() {
	return src('./dist/themes/' + themeName + '/**/*')
		.pipe(zip.dest('./dist/' + themeName + '.zip'))
		.on('end', () => {
			beeper();
			log(pluginsGenerated);
			log(filesGenerated);
			log(thankYou);
		});
}

const prod = series(
	cleanProd,
	copyThemeProd,
	copyFontsProd,
	stylesProd,
	headerScriptsProd,
	footerScriptsProd,
	pluginsProd,
	processImages,
	zipProd
);
prod.displayName = 'prod';
export { prod };

/* -------------------------------------------------------------------------------------------------
Utility Tasks
-------------------------------------------------------------------------------------------------- */
const onError = (err) => {
	beeper();
	log(wpFy + ' - ' + errorMsg + ' ' + err.toString());
	this.emit('end');
};

function Backup() {
	if (!fs.existsSync('./build')) {
		log(buildNotFound);
		process.exit(1);
	} else {
		return src('./build/**/*')
			.pipe(zip.dest('./backups/' + date + '.zip'))
			.on('end', () => {
				beeper();
				log(backupsGenerated);
				log(thankYou);
			});
	}
}

Backup.displayName = 'backup';
export { Backup };

/* -------------------------------------------------------------------------------------------------
Messages
-------------------------------------------------------------------------------------------------- */
const date = new Date().toLocaleDateString('en-GB').replace(/\//g, '.');
const errorMsg = '\x1b[41mError\x1b[0m';
const warning = '\x1b[43mWarning\x1b[0m';
const devServerReady =
	'Your development server is ready, start the workflow with the command: $ \x1b[1mnpm run dev\x1b[0m';
const buildNotFound =
	errorMsg +
	' ⚠️　- You need to build the project first. Run the command: $ \x1b[1mnpm run env:start\x1b[0m';
const filesGenerated =
	'Your ZIP template file was generated in: \x1b[1m' +
	'/dist/' +
	themeName +
	'.zip\x1b[0m - ✅';
const pluginsGenerated =
	'Plugins are generated in: \x1b[1m' + '/dist/plugins/\x1b[0m - ✅';
const backupsGenerated =
	'Your backup was generated in: \x1b[1m' +
	'/backups/' +
	date +
	'.zip\x1b[0m - ✅';
const wpFy = '\x1b[42m\x1b[1mWordPressify\x1b[0m';
const wpFyUrl = '\x1b[2m - https://www.wordpressify.co/\x1b[0m';
const thankYou = 'Thank you for using ' + wpFy + wpFyUrl;

/* -------------------------------------------------------------------------------------------------
End of all Tasks
-------------------------------------------------------------------------------------------------- */

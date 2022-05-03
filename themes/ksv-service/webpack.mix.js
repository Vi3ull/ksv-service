const mix = require('laravel-mix');

const glob = require('glob');
const nodePath = require('path');

const CopyWebpackPlugin = require('copy-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const partytown = require('@builder.io/partytown/utils');

require('dotenv').config({ path: '../../.env' });
require('laravel-mix-webp');
require('laravel-mix-polyfill');

const publicFolder = 'assets';

const copyDirectories = [
	{
		from	: './src/assets/img',
		to		: `${ publicFolder }/img`,
	},
];

const jsArr = glob
			.sync( 'src/components/*.js' )
			.filter( file => nodePath.basename( file ).substr(0, 1) !== '_' );

const cssArr = glob
			.sync( 'src/components/*.scss' )
			.filter( file => nodePath.basename( file ).substr(0, 1) !== '_' );


mix
	.babelConfig({
		plugins: ['@babel/plugin-syntax-dynamic-import'],
	})
	.copy(partytown.libDirPath(), 'assets/js/~partytown')
	.options({
		processCssUrls: false, // Отключаем автоматическое обновление URL в CSS
		postCss: [
				require('autoprefixer')({
						cascade: false,
				}),
				require('postcss-sort-media-queries'),
		],
	})
	.setPublicPath( 'assets' )
	.alias({
		'@c': nodePath.join(__dirname, './src/components')
	})
	.polyfill({
			enabled: true,
			useBuiltIns: "usage",
			targets: false,
			debug: true,
			corejs: '3.8',
	})
	.webpackConfig({
		output: {
			publicPath: '/themes/ksv-service/assets',
		},
		plugins: [
				new CopyWebpackPlugin({
						patterns: [
								{
										from: './src/assets/img', 
										to: 'img', 
										globOptions: {
												ignore: ["**/icons/**"],
										},
								},
						],
				}),
				new CleanWebpackPlugin({
					cleanOnceBeforeBuildPatterns: [ `${ publicFolder }/**/*` ],
				})
		],
	})

	copyDirectories.forEach( item => mix.copyDirectory( item.from, item.to ) );
	jsArr.forEach( item => mix.js( item, `${ publicFolder }/js`) );
	cssArr.forEach( item => mix.sass( item, `${ publicFolder }/css`) );

	if (mix.inProduction()) {
			mix
				.version()
				.sourceMaps()
	} else {
		mix.browserSync({
				proxy: process.env.APP_URL,
				host: process.env.APP_URL,   
				// port: process.env.BROWSER_SYNC_PORT || 8080,
				open: false,
				browser: 'google chrome',
				// notify: {
				// 		styles: {
				// 				top: '0',
				// 		}
				// },
				files: [
						`./${ publicFolder }/**/*`,
						'./**/*.htm'
				]
		});
	}
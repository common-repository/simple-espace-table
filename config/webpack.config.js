const webpack = require('webpack');
const path = require('path');

// init babel loader
const babelLoader = {
	loader: 'babel-loader',
	options: {
		comments: false,
		presets: [
			[
				'env',
				{
					targets: {
						browsers: ['last 3 versions']
					}
				}
			],
			'vue'
		]
	}
};

module.exports = {
	context: __dirname + '../js',
	entry: path.resolve(__dirname, '../dist', '../js/main.js'),
	output: {
		filename: '../dist/bundle.js'
	},
	resolve: {
		alias: {
			'vue$': 'vue/dist/vue.esm.js'
		}
	},
	module: {
		rules: [
			// Process JS files through Babel.
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: [babelLoader]
			}
		],
		noParse: [/raty-js/]
	},
}
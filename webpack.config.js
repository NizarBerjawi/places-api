const path = require('path');
const webpack = require('webpack');
const AssetsPlugin = require('assets-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

module.exports = {
    entry: {
        app: path.resolve('./resources/src/app'),
        vendor: path.resolve('./resources/src/vendor'),
        documentation: path.resolve('./resources/src/docs')
    },
    output: {
        path: path.resolve(__dirname, 'public/dist'),
        filename: '[name].[chunkhash].js',
    },
    optimization: {
        minimize: true
    },
    module: {
        rules: [
            {
                test: /\.(css)$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                ],
            },
        ]
    },
    resolve: {
        extensions: ['.js', '.jsx']
    },
    plugins: [
        new MiniCssExtractPlugin(),
        new CssMinimizerPlugin(),
        new AssetsPlugin({
            filename: 'manifest.json',
            path: path.resolve(__dirname, 'public/dist'),
            prettyPrint: true,
            removeFullPathAutoPrefix: true
        })
    ],
};

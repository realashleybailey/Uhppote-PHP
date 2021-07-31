const path = require('path');
const webpack = require('webpack');

module.exports = {
    entry: [
        './src/js/index.js'
    ],
    mode: 'development',
    output: {
        path: path.resolve(__dirname, 'js'),
        filename: 'main.js',
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.$': 'jquery',
            'window.jQuery': 'jquery',
            mdb: './../../js/mdb.min.js'
        })
    ],
    devtool: 'source-map',
    target: 'web',
    devServer: {
        contentBase: path.join(__dirname, 'js'),
        compress: true,
        port: 9000,
        allowedHosts: ['.vhx.cloud'],
    },
};
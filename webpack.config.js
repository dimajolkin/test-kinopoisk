var ExtractTextPlugin = require('extract-text-webpack-plugin');
const webpack = require('webpack');

module.exports = {
    entry:  {
        app : __dirname + '/assets/public/app.js',
    },
    output: {
        path: __dirname + '/web/assets',
        filename: '[name].js',
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: 'css-loader',
                    publicPath: '../',
                }),
            },
            {
                test: /\.less$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [
                        {
                            loader: 'css-loader',
                        },
                        {
                            loader: 'less-loader',
                        },
                    ],
                    publicPath: '../',
                }),
            },
            {
                test: /\.twig$/,
                use: [
                    'twig-loader',
                ],
            },
            {
                test: /\.png$/,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            limit: '30000',
                            name: 'images/[name]-[hash].[ext]',
                        },
                    },
                ],
            },
            {
                test: /\.jpg$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: 'images/[name]-[hash].[ext]',
                        },
                    },
                ],
            },
            {
                test: /\.gif$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: 'images/[name]-[hash].[ext]',
                        },
                    },
                ],
            },
            {
                test: /\.ttf(\?[a-z0-9=\.]+)?$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            mimetype: 'application/font-ttf',
                            name: 'fonts/[name]-[hash].[ext]',
                        },
                    },
                ],
            },
            {
                test: /\.svg(\?[a-z0-9=\.]+)?$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            mimetype: 'image/svg+xml',
                            name: 'fonts/[name]-[hash].[ext]',
                        },
                    },
                ],
            },
            {
                test: /\.woff(\?[a-z0-9=\.]+)?$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            mimetype: 'application/font-woff',
                            name: 'fonts/[name]-[hash].[ext]',
                        },
                    },
                ],
            },
            {
                test: /\.woff2(\?[a-z0-9=\.]+)?$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            mimetype: 'application/font-woff2',
                            name: 'fonts/[name]-[hash].[ext]',
                        },
                    },
                ],
            },
            {
                test: /\.eot(\?[a-z0-9=\.]+)?$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            mimetype: 'application/vnd.ms-fontobject',
                            name: 'fonts/[name]-[hash].[ext]',
                        },
                    },
                ],
            },
        ],
    },
    plugins: [
        new ExtractTextPlugin("[name].css"),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            'window.$': 'jquery',
        }),
    ]
};
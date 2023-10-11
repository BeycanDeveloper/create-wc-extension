#!/usr/bin/env node

const fs = require( 'fs-extra' );
const path = require( 'path' );
const chalk = require( 'chalk' );

const files = [
	'._gitignore',
	'_README.md',
	'_webpack.config.js',
	'_package.json',
	'._eslintrc.js',
	'._prettierrc.json',
];
const maybeThrowError = ( error ) => {
	if ( error ) throw error;
};

( async () => {
	console.log( '\n' );
	console.log(
		chalk.yellow(
			'🎉 Welcome to WooCommerce Admin Extension Starter Pack 🎉'
		)
	);
	const extensionName = process.argv[2];
	const extensionType = process.argv[3] || 'plugin';
	const extensionFile = extensionType === 'plugin' ? '_main-plugin.php' : '_main-theme.php';
	
	files.push( extensionFile );

    if (!extensionName) {
        console.log(
            chalk.red(
                'Please provide a name for your extension. For example: "create-wc-extension my-extension-name"'
            )
        );
        process.exit(1);
    }

	const extensionSlug = extensionName.replace( / /g, '-' ).toLowerCase();
	const folder = path.join( process.cwd(), extensionSlug );

	fs.mkdir( folder, maybeThrowError );

	files.forEach( ( file ) => {
		const from = path.join( __dirname, 'skeleton' ,file );
		const to = path.join(
			folder,
			extensionFile === file
				? `${ extensionSlug }.php`
				: file.replace( '_', '' )
		);

		fs.readFile( from, 'utf8', ( error, data ) => {
			maybeThrowError( error );

			const addSlugs = data.replace(
				/{{extension_slug}}/g,
				extensionSlug
			);
			const result = addSlugs.replace(
				/{{extension_name}}/g,
				extensionName
			);

			fs.writeFile( to, result, 'utf8', maybeThrowError );
		} );
	} );

	fs.copy(
		path.join( __dirname, 'skeleton', 'src' ),
		path.join( folder, 'src' ),
		maybeThrowError
	);

	process.stdout.write( '\n' );
	console.log(
		chalk.green(
			'Wonderful, your extension has been scaffolded and placed as a sibling directory to this one.'
		)
	);
	process.stdout.write( '\n' );
	console.log(
		chalk.green(
			'Run the following commands from the root of the extension and activate the plugin.'
		)
	);
	process.stdout.write( '\n' );
	console.log( 'npm install' );
	console.log( 'npm start' );
	process.stdout.write( '\n' );
} )();
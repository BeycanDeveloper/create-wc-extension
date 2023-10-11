# Create Extension

Scaffold a modern JavaScript WordPress plugin with WooCommerce tooling.

## Includes

-   [wp-scripts](https://github.com/WordPress/gutenberg/tree/master/packages/scripts)
-   [WooCommerce Dependency Extraction Webpack Plugin](https://github.com/woocommerce/woocommerce-admin/tree/main/packages/dependency-extraction-webpack-plugin)
-   [WooCommerce ESLint Plugin with WordPress Prettier](https://github.com/woocommerce/woocommerce-admin/tree/main/packages/eslint-plugin)

### Usage

At the root of a [WooCommerce Admin](https://github.com/woocommerce/woocommerce-admin) installation, run the create extension command.

```
npm i create-wc-extension
create-wc-extension my-extension

// opsional
create-wc-extension my-extension extension-type

// extension-type: If you are going to create a direct WordPress plugin, you can leave it blank. However, if you are going to use it under a theme, you will need to write "theme". Thus, it will be designed to work under the theme.
```

The script will create a sibling directory by a name of your choosing. Once you change directories into the new folder, install dependencies and start a development build.

```
npm install
npm start
```
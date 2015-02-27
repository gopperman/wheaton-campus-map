# [Wheaton Map](http://wheatoncollege.edu)

The Wheaton Map is a single-page application delivered via Wordpress for interactive campus tours.

# ToC

* [Getting Started](#getting-started)
	*  [Requirements](#requirements)
	* [Frameworks and Tools](#frameworks-and-tools)
* [Installation/Usage](#installationusage)
* [Documentation](#documentation)
	* [Configuration Files](#configuration-files)
	* [Environment Variables](#environment-variables)
		* [Plugins](#plugins) 
		* [Updating WP and Plugins](#updating-wp-and-plugin-versions) 
		* [Themes](#themes)

## Getting Started

The Wheaton Map is built on [Roots](https://roots.io/), using the Bedrock Wordpress stack and the Roots/Sage boilerplate. You can optionally implement the Wheaton Map using your own Wordpress stack (or the default). 

### Requirements

* Git
* PHP >= 5.4
* Ruby >= 1.9 (optional - for Capistrano)

### Frameworks and Tools
* [Wordpress](http://codex.wordpress.org/Developer_Documentation)
	* [Using Bedrock with Wordpress for the First Time](http://efeqdev.com/tutorial/using-bedrock-for-wordpress-for-the-first-time/)
	* [Bedrock Documentation](https://roots.io/bedrock/docs/)
	* [Sage Documentation](https://roots.io/sage/docs/)
	* [Advanced Custom Fields](http://www.advancedcustomfields.com/resources)
* Javascript
	* [Grunt](http://gruntjs.com/getting-started)
	* [jQuery](http://api.jquery.com/)
* CSS 
	* [LESS](http://lesscss.org/)
	* [Bootstrap](http://getbootstrap.com/)

## Installation/Usage

See [Documentation](#documentation) for more details on the steps below.

1. Clone/Fork repo
2. Run `composer install`
3. Copy `.env.example` to `.env` and update environment variables:
  * `DB_NAME` - Database name
  * `DB_USER` - Database user
  * `DB_PASSWORD` - Database password
  * `DB_HOST` - Database host (defaults to `localhost`)
  * `WP_ENV` - Set to environment (`development`, `staging`, `production`, etc)
  * `WP_HOME` - Full URL to WordPress home (http://example.com)
  * `WP_SITEURL` - Full URL to WordPress including subdirectory (http://example.com/wp)
4. Add theme(s)
4. Set your Nginx or Apache vhost to `/path/to/site/web/` (`/path/to/site/current/web/` if using Capistrano)
5. Access WP Admin at `http://example.com/wp/wp-admin`

### Wordpress Setup
1. Complete the normal Wordpress installation process.
2. Activate the 'Wheaton Map' Theme
3. Install and Activate Advanced Custom fields with your developer key

## Documentation

### Folder Structure

```
├── Capfile
├── composer.json
├── config
│   ├── application.php
│   ├── deploy
│   │   ├── staging.rb
│   │   └── production.rb
│   ├── deploy.rb
│   └── environments
│       ├── development.php
│       ├── staging.php
│       └── production.php
├── Gemfile
├── vendor
└── web
    ├── app
    │   ├── mu-plugins
    │   ├── plugins
    │   └── themes
    ├── wp-config.php
    ├── index.php
    └── wp
```

* In order not to expose sensitive files in the webroot, Bedrock moves what's required into a `web/` directory including the vendor'd `wp/` source, and the `wp-content` source.
* `wp-content` (or maybe just `content`) has been named `app` to better reflect its contents. It contains application code and not just "static content". It also matches up with other frameworks such as Symfony and Rails.
* `wp-config.php` remains in the `web/` because it's required by WP, but it only acts as a loader. The actual configuration files have been moved to `config/` for better separation.
* Capistrano configs are also located in `config/` to make it consistent.
* `vendor/` is where the Composer managed dependencies are installed to.
* `wp/` is where the WordPress core lives. It's also managed by Composer but can't be put under `vendor` due to WP limitations.


### Configuration Files

The root `web/wp-config.php` is required by WordPress and is only used to load the other main configs. Nothing else should be added to it.

`config/application.php` is the main config file that contains what `wp-config.php` usually would. Base options should be set in there.

For environment specific configuration, use the files under `config/environments`. By default there's is `development`, `staging`, and `production` but these can be whatever you require.

The environment configs are required **before** the main `application` config so anything in an environment config takes precedence over `application`.

Note: You can't re-define constants in PHP. So if you have a base setting in `application.php` and want to override it in `production.php` for example, you have a few options:

* Remove the base option and be sure to define it in every environment it's needed
* Only define the constant in `application.php` if it isn't already defined.

### Environment Variables

Bedrock tries to separate config from code as much as possible and environment variables are used to achieve this. The benefit is there's a single place (`.env`) to keep settings like database or other 3rd party credentials that isn't committed to your repository.

[PHP dotenv](https://github.com/vlucas/phpdotenv) is used to load the `.env` file. All variables are then available in your app by `getenv`, `$_SERVER`, or `$_ENV`.

Currently, the following env vars are required:

* `DB_USER`
* `DB_NAME`
* `DB_PASSWORD`
* `WP_HOME`
* `WP_SITEURL`

#### Plugins

[WordPress Packagist](http://wpackagist.org/) is already registered in the `composer.json` file so any plugins from the [WordPress Plugin Directory](http://wordpress.org/plugins/) can easily be required.

To add a plugin, add it under the `require` directive or use `composer require <namespace>/<packagename>` from the command line. If it's from WordPress Packagist then the namespace is always `wpackagist-plugin`.

Example: `"wpackagist-plugin/akismet": "dev-trunk"`

Whenever you add a new plugin or update the WP version, run `composer update` to install your new packages.

`plugins`, and `mu-plugins` are Git ignored by default since Composer manages them. If you want to add something to those folders that *isn't* managed by Composer, you need to update `.gitignore` to whitelist them:

`!web/app/plugins/plugin-name`

Note: Some plugins may create files or folders outside of their given scope, or even make modifications to `wp-config.php` and other files in the `app` directory. These files should be added to your `.gitignore` file as they are managed by the plugins themselves, which are managed via Composer. Any modifications to `wp-config.php` that are needed should be moved into `config/application.php`.

#### Updating WP and plugin versions

Updating your WordPress version (or any plugin) is just a matter of changing the version number in the `composer.json` file.

Then running `composer update` will pull down the new version.

#### Themes

Themes can also be managed by Composer but should only be done so under two conditions:

1. You're using a parent theme that won't be modified at all
2. You want to separate out your main theme and use that as a standalone package

Under most circumstances we recommend NOT doing #2 and instead keeping your main theme as part of your app's repository.

Just like plugins, WPackagist maintains a Composer mirror of the WP theme directory. To require a theme, just use the `wpackagist-theme` namespace.

#### Don't want it?

Composer integration is the biggest part of Bedrock, so if you were going to remove it there isn't much point in using Bedrock.

### Capistrano

[Capistrano](http://www.capistranorb.com/) is a remote server automation and deployment tool. It will let you deploy or rollback your application in one command:

* Deploy: `cap production deploy`
* Rollback: `cap production deploy:rollback`

Composer support is built-in so when you run a deploy, `composer install` is automatically run. Capistrano has a great [deploy flow](http://www.capistranorb.com/documentation/getting-started/flow/) that you can hook into and extend it.

It's written in Ruby so it's needed *locally* if you want to use it. Capistrano was recently rewritten to be completely language agnostic, so if you previously wrote it off for being too Rails-centric, take another look at it.

#### Don't want it?

You will lose the one-command deploys and built-in integration with Composer. Another deploy method will be needed as well.

* Remove `Capfile`, `Gemfile`, and `Gemfile.lock`
* Remove `config/deploy.rb`
* Remove `config/deploy/` directory

### wp-cron

Bedrock disables the internal WP Cron via `define('DISABLE_WP_CRON', true);`. If you keep this setting, you'll need to manually set a cron job like the following in your crontab file:

`*/5 * * * * curl http://example.com/wp/wp-cron.php`

## WP-CLI

Bedrock works with [WP-CLI](http://wp-cli.org/) just like any other WordPress project would. Previously we required WP-CLI in our `composer.json` file as a dependency. This has been removed since WP-CLI now recommends installing it globally with a `phar` file. It also caused conflicts if you tried using a global install.

The `wp` command will automatically pick up Bedrock's subdirectory install as long as you run commands from within the project's directory (or deeper). Bedrock includes a `wp-cli.yml` file that sets the `path` option to `web/wp`. Use this config file for any further [configuration](http://wp-cli.org/config/).

## mu-plugins autoloader

Bedrock includes an autoloader that enables standard plugins to be required just like must-use plugins.
The autoloaded plugins are included after all mu-plugins and standard plugins have been loaded.
An asterisk (*) next to the name of the plugin designates the plugins that have been autoloaded.
To remove this functionality, just delete `web/app/mu-plugins/bedrock-autoloader.php`.

This enables the use of mu-plugins through Composer if their package type is `wordpress-muplugin`. You can also override a plugin's type like the following example:

```json
"installer-paths": {
  "web/app/mu-plugins/{$name}/": ["type:wordpress-muplugin", "roots/soil"],
  "web/app/plugins/{$name}/": ["type:wordpress-plugin"],
  "web/app/themes/{$name}/": ["type:wordpress-theme"]
},
```

[Soil](https://github.com/roots/soil) is a package with its type set to `wordpress-plugin`. Since it implements `composer/installers` we can override its type.

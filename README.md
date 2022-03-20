CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Recommended modules
 * Installation
 * Configuration
 * Commercial support
 * Maintainers

INTRODUCTION
------------

Commerce Kickstart is the fastest way to start building on Drupal Commerce. It
includes an installation profile for installing Drupal 9, Commerce Core, and
the Centarro Commerce contributed modules and themes.

The installer includes an additional step where you can install either a full
demo store for evaluation purposes or enable the individual features you need
to start building and launch your store today!

 * For a full description of the distribution, visit the project page:
   https://www.drupal.org/project/commerce_kickstart

 * To submit bug reports or track changes, use the official issue tracker:
   https://www.drupal.org/project/issues/commerce_kickstart

 * This project is still in active development pursuant to a full release.
   Follow the development plan and release milestones in the following issue:
   https://www.drupal.org/project/commerce_kickstart/issues/3230155

REQUIREMENTS
------------

Your development and hosting environments must be capable of running Drupal 9:

https://www.drupal.org/docs/system-requirements

We strongly recommend using DDEV-Local for local development and a Drupal
optimized Platform-as-a-Service (e.g. Acquia, Pantheon, or Platform.sh) for
hosting your site. Centarro offers consulting, development, and managed
services if you need help deciding how to build, launch, or run your store.

Commerce Kickstart must be installed and updated via Composer to properly build
the codebase and fetch new versions of Drupal and third-party dependencies.

RECOMMENDED MODULES
-------------------

Commerce Kickstart includes all of the Centarro Commerce contributed modules.
These are maintained by Centarro, the company behind Drupal Commerce, to
conform to the same development and documentation standards as Commerce Core.

Additional Drupal modules and themes may be installed via Composer to add new
features to your store. Search for modules compatible with Drupal 9 on
drupal.org to see what's available, and filter your search results to those in
the Commerce Core ecosystem to find modules that extend Drupal Commerce.

INSTALLATION
------------

We recommend installing with our Composer project template, but you can also
add Commerce Kickstart as a requirement to any Drupal 9.x project template. For
full instructions, please refer to [centarro/commerce-kickstart-project](https://github.com/centarro/kickstart-project).

```shell
composer create-project centarro/commerce-kickstart-project kickstart
```

If creating a project of a pre-release or development version, use the -s flag
to set the appropriate stability level:

```shell
composer create-project -s dev centarro/commerce-kickstart-project kickstart
```

If you expect to install the full demo store, you will need to add the Commerce
Demo module to your codebase. To do so, issue the two following commands:

```shell
cd kickstart
composer require drupal/commerce_demo:^3.0
```

(Note: this only works when `commerce_demo` is installed using the `vcs` type
repository definition provided by the project template or installation profile
`composer.json` file. Attempting to install it from the Drupal package will
result in dependency conflicts, as it interprets the `commerce_kickstart:*`
dependencies in `commerce_kickstart.info.yml` as `drupal/commerce_kickstart`
even though drupal.org does not currently support installation profiles.)

We recommend and support [DDEV-Local](https://github.com/drud/ddev) for local development.
Change into the newly created directory and use the following commands to
launch the site:

```shell
ddev config
ddev start
```

Just want a quick look? We partnered with SimplyTest.me to create a one-click
installer in a temporary web environment for more casual evaluation. Browse to
https://simplytest.me and click *Drupal Commerce Demo*. After installation, you
can log in as user 1 using `admin` as the username and password. These
environments will be deleted after a short period of time, so do not build
anything here you expect to use again!

CONFIGURATION
-------------

Configuration occurs in the installer and then as needed throughout the Drupal
administrative interface. This distribution includes the Commerce Store Wizard
module and a go-live checklist provided by the Centarro Toolbox module to guide
you through various aspects of Drupal Commerce configuration.

Commerce Kickstart includes the Config Splits module to support different
configurations per environment. The default config directory created in the
root project folder includes a splits subdirectory with a directory and config
split specific to DDEV environments. After installing your site, if you are
developing on DDEV, you can either import the DDEV specific configuration via
the user interface at /admin/config/development/configuration/config-split or
import via drush:

```shell
ddev drush config-split:import ddev
```

COMMERCIAL SUPPORT
------------------

Centarro offers a full range of consulting and support services for merchants
doing business on Drupal Commerce, includiung managed hosting, maintenance,
and support for Commerce Kickstart sites. For more information, contact
Centarro at info@centarro.io or via contact form on https://www.centarro.io.

MAINTAINERS
-----------

Current maintainers:
 * Ryan Szrama (rszrama) - https://www.drupal.org/u/rszrama
 * Jonathan Sacksick (jsacksick) - https://www.drupal.org/u/jsacksick

This project has been sponsored by:
 * Centarro (https://www.drupal.org/centarro) - Centarro is building the future
   of commerce without compromise. As the creators and maintainers of Drupal
   Commerce, our products and services are designed to help you build with
   confidence on our platform.

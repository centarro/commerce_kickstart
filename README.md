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

Commerce Kickstart 3.x is the quickest way to get started with Drupal Commerce
on Drupal 9. It provides an installation profile for installing Drupal 9,
Commerce Core, and the Centarro Commerce contributed modules and themes.

The installer includes optional steps where you have the choice to install
either the full Commerce Demo store or to install specific store configuration
modules provided by the profile. The Commerce Demo store should *not* be used
for building a live site.

 * For a full description of the distribution, visit the project page:
   https://www.drupal.org/project/commerce_kickstart

 * To submit bug reports or track changes, use the official issue tracker:
   https://www.drupal.org/project/issues/commerce_kickstart

 * This project is still in active development pursuant to a full release.
   Follow the development plan and release milestones in the following issue:
   https://www.drupal.org/project/commerce_kickstart/issues/3230155

REQUIREMENTS
------------

Your development and hosting environments must be capable of running Drupal 9.

Commerce Kickstart 3.x must be installed via Composer in order to pull in a
wide variety of contributed modules and other dependencies.

RECOMMENDED MODULES
-------------------

Commerce Kickstart 3.x includes all of the Centarro Commerce contributed
modules. These are maintained by Centarro, the company behind Drupal Commerce,
to conform to the same code, test, and documentation standards applied to
Commerce Core itself.

Additional contributed Commerce modules and themes may be added as needed to
build out your store. Search for modules on drupal.org in the Commerce Core
ecosystem that are compatible with Drupal 9.

INSTALLATION
------------

As drupal.org does not fully support distribution or installation profile
installation via Composer, we recommend the following installation process in
a local development environment with git, Composer 2, and ddev:

 1. `git clone --branch '3.x' https://git.drupalcode.org/project/commerce_kickstart.git`
 2. `cd commerce_kickstart`
 3. `composer install` (note that this will symlink the installation profile
    files into the `web/profiles/commerce_kickstart` directory per instructions
    in the `composer.json` file)
 4. `ddev config` (using `commerce-kickstart` as the project name, `web` as the
    docroot location, and `drupal9` as the project type)
 5. `ddev start`

You can now test Commerce Kickstart by opening the link ddev provides! Consider
starting with the full Commerce Demo store to see everything the distribution
provides. We include drush in the project, so when you're ready to delete the
database and try a different installation path, use `ddev exec drush sql-drop`.

Any of that confusing? We partnered with SimplyTest.me to create a one-click
installer in a temporary web environment for more casual evaluation. Just
open https://simplytest.me in your browser and click *Drupal Commerce Demo*.
After installation, you can log in as user 1 using `admin` as the username and
password. These environments will be deleted after a short period of time, so
do not build anything here you expect to use again!

CONFIGURATION
-------------

Configuration occurs in the installer and then as needed throughout the Drupal
administrative interface. This distribution includes the Commerce Store Wizard
module and a go-live checklist provided by the Centarro Toolbox module to guide
you through various aspects of Drupal Commerce configuration.

COMMERCIAL SUPPORT
------------------

Centarro offers a full range of consulting and support services for merchants
doing business on Drupal Commerce, includiung managed hosting, maintenance,
and support for Commerce Kickstart sites. For more information, contact
Centarro at info@centarro.io or via contact form on https://www.centarro.io.

MAINTAINERS
-----------

Current maintainers:
 * David Kitchen (dwkitchen) - https://www.drupal.org/u/dwkitchen
 * Ryan Szrama (rszrama) - https://www.drupal.org/u/rszrama
 * Jonathan Sacksick (jsacksick) - https://www.drupal.org/u/jsacksick

This project has been sponsored by:
 * Centarro (https://www.drupal.org/centarro) - Centarro is building the future
   of commerce without compromise. As the creators and maintainers of Drupal
   Commerce, our products and services are designed to help you build with
   confidence on our platform.

# Contributing to Commerce Kickstart

## Contents

* Introduction
* Requirements
* Getting started
* Using DDEV-Local

## Introduction

We tend to prefer reviewing contributions in the form of patches posted to the
Commerce Kickstart issue queue. However, drupal.org does support GitLab based
merge requests if desired: [Creating Issue forks and merge requests](https://www.drupal.org/docs/develop/git/using-git-to-contribute-to-drupal/creating-issue-forks-and-merge-requests)

## Requirements

We recommend using [DDEV-Local](https://github.com/drud/ddev) for local development,
but any local development environment that meets Drupal 9 system requirements
and has Composer installed will do. While not a requirement, we strongly
recommend using DDEV-Local with mutagen enabled, which can be done per project
or globally for all of your projects via:

```shell
ddev config global --mutagen-enabled
```

## Getting started

```shell
git clone git@git.drupal.org:project/commerce_kickstart.git
cd commerce_kickstart
composer install
ddev config
ddev start
```

## Using DDEV-Local

DDEV-Local dramatically simplifies construction of a fully capable development
environment. It uses Docker to provide you with a router, web server, database,
and other services as desired. It supports XDebug for PHP debugging in a
compatible IDE and Mutagen for file synchronization, dramatically improving the
performance of Drupal in local environments.

It offers phpMyAdmin for browser based database inspection / administration or
integration with Sequel Pro if you prefer a native application. It traps email
sent via SMTP 127.0.0.1:1025, using MailHog to provide a browser based UI for
reviewing the email your site sends.

Read more about all of the above and more at: https://ddev.readthedocs.io/

## Maintaining Commerce Kickstart

In order to support installation of Commerce Kickstart via:

```shell
composer require centarro/commerce_kickstart:^3.0
```

All commits to the primary project repository on drupal.org must be mirrored
to GitHub. If you have access to the project on GitHub, ensure that you have
added it as a remote and push all commits to it in addition to drupal.org.

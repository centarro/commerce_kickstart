# Contributing to Commerce Kickstart

## Contents

* Introduction
* Requirements
* Getting Started
* Dev with Lando

## Introduction

[Creating Issue forks and merge requests](https://www.drupal.org/docs/develop/git/using-git-to-contribute-to-drupal/creating-issue-forks-and-merge-requests)

## Requirements

We recommend using [Lando](https://docs.lando.dev/) for local development

## Getting Started

```shell
git clone git@git.drupal.org:project/commerce_kickstart.git
cd commerce_kickstart
lando start
lando install
lando demo
```

## Dev with Lando

Lando vastly simplifies local development and DevOps, so you can focus on what's important.

### Lando Services

#### XDebug

XDebug is included, find out how to [set up Lando + XDebug with PhpStorm](https://docs.lando.dev/guides/lando-phpstorm.html#lando-phpstorm-xdebug)

#### Mailhog

Mailhog is preconfigured to catch all emails. When you run `lando start` the URL for Mailhog will be displayed.

### Lando Tooling

#### Standard Lando Tooling

You get all the usual Lando commands to start, stop and rebuild your local environment.
Simple run `lando` to see all available commands

```shell
lando start
lando stop
lando rebuild
ladno poweroff
```

#### Drupal Tooling

```shell
lando drush <command>
lando composer <command>
```

#### Commerce Kickstart Tooling

```shell
lando install
```

Installs a fresh Commerce Kickstart site

| Username | Roles         | Password |
|----------|---------------|----------|
| system   | User 1        | system   |
| admin    | administrator | admin    |

```shell
lando devel
```

Installs Devel and UI Modules for Drupal

```shell
lando demo
```

Installs Commerce Demo module

```shell
lando update
```

Runs `composer update` and `drush updb`

```shell
lando phpunit
lando phpstan
lando phpcs
```

Run tests, static code analysis and code sniffer.

```shell
lando soften
```

Soften the Drupal installation, i.e. revert the hardening done by the Drupal installer.

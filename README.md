# Composer template for Drupal projects

[![pipeline status](https://gitlab.com/mog33/drupal-composer-advanced-template/badges/8.x-dev/pipeline.svg)](https://gitlab.com/mog33/drupal-composer-advanced-template/commits/8.x-dev)
[![Build Status](https://travis-ci.org/Mogtofu33/drupal-composer-advanced-template.svg?branch=8.x-dev)](https://travis-ci.org/Mogtofu33/drupal-composer-advanced-template)

Based on [Composer template for Drupal projects](https://github.com/drupal-composer/drupal-project).

- [What's included / added](#whats-included--added)
- [Install](#install)
  - [Requirements](#requirements)
  - [Grab code and libraries](#grab-code-and-libraries)
  - [Drupal installation](#drupal-installation)
    - [Server / remote installation](#server--remote-installation)
    - [Local setup with ddev](#local-setup-with-ddev)
- [Project metrics](#project-metrics)
- [Tips](#tips)
  - [Using Sass with a Docker image](#using-sass-with-a-docker-image)

## What's included / added

- A bunch of interesting [contrib modules](./composer.json#L47), some [patches for core / contrib](./composer.json#L271)
- Third party libraries download with [Asset packagist](https://asset-packagist.org)
- [Bootstrap Sass](https://www.drupal.org/project/bootstrap) sub theme with sass + Sass compiler with Php
- Drupal basic configuration with Dev / Prod environment, see [Workflow readme](config/README.md)
- A Full [Gitlab-CI support](https://gitlab.com/mog33/gitlab-ci-drupal) for build, tests, code quality, linting, metrics and deploy, see [Gitlab-CI for Drupal8](https://gitlab.com/mog33/gitlab-ci-drupal)

## Install

### Requirements

Require [Composer 1.8+](https://getcomposer.org) with [Php 7+](http://php.net/) and Php modules needed for composer.

Compiling the Sass file is done through [http://leafo.github.io/scssphp](http://leafo.github.io/scssphp) but you can install [Sass](https://sass-lang.com/install) if you prefer a more advanced feature (like watch) or use a [Docker image](#using-sass-with-a-docker-image).

Recommended:

- [Composer prestissimo](https://github.com/hirak/prestissimo)

```bash
composer global require "hirak/prestissimo:^0.3"
```

### Grab code and libraries

Get and install this project

```bash
composer create-project mog33/drupal-composer-advanced-template:dev-8.x-dev drupal --stability dev --no-interaction
```

_Note_: A sub theme for Bootstrap Sass will be created and compiled during the
installation. When developing a theme and editing the scss file you can compile
with command:

```bash
composer run-script sass-compile
```

Set **/web** as root of your host (Apache).

Other folders (eg: vendor) should be accessible by Webserver user and not from HTTP.

### Drupal installation

#### Server / remote installation

- Create a database and a user access to this database.

- Fix files and folder permissions of **/web** folder regardless of [Securing file permissions and ownership](https://www.drupal.org/node/244924)

- Edit `.env` and select `SETTINGS_ENVIRONMENT` value, _dev_ will enable development modules and settings

- Install Drupal and choose profile **Use existing configuration**

#### Local setup with ddev

This project include a simple **Docker** stack based on great project [Ddev](https://ddev.readthedocs.io/en/latest/).

Install [Ddev](https://ddev.readthedocs.io/en/latest/#installation)

Then launch the ddev stack:

```bash
ddev start
```

- Edit `.env` and select `SETTINGS_ENVIRONMENT` value, _dev_ will enable development modules and settings

- Install Drupal and choose profile **Use existing configuration**

- **OR**

- **EXPERIMENTAL Drush 10.x, CURRENTLY FAILING** use Drush command installation to run from **web** folder

```bash
ddev exec drush -y si --existing-config --account-name=admin --account-pass=password
```

_Note_: If you have a permission denied, ensure permissions on `web/sites/default` is 750.

Composer install script already Include `settings.local.php`, at the end of `web/sites/default/settings.php`, `settings.dev.php` and `settings.prod.php`, adapt if you need.

- Login to your new website with user admin / password OR using _drush_:

```bash
../vendor/bin/drush uli
```

## Project metrics

You want an idea of what's in this project ?

Just take a peek at [Phpmetrics for this project](https://mog33.gitlab.io/-/drupal-composer-advanced-template/-/jobs/265433512/artifacts/reports/phpmetrics/index.html)

## Tips

### Using Sass with a Docker image

If you don't want to install Sass and the provided Php script in this project do not please you, an other solution is to use a Docker image with [node-sass](https://github.com/sass/node-sass).

Create the _Dockerfile_

```dockerfile
FROM node:dubnium-alpine
RUN apk update && apk add --no-cache git shadow
RUN npm install -g node-sass bootstrap-sass postcss-cli autoprefixer watch --unsafe-perm
WORKDIR /app
RUN chown -R node:node /app
CMD [ "sass", "node-sass", "compile", "watch", "npm" ]
```

One time image build

```bash
docker build -t sass .
```

Run from your theme folder

```bash
cd web/themes/custom/bootstrap_sass
docker run --rm -v $(pwd):/app sass node-sass scss/style.scss > css/style.css
# Set format compressed.
docker run --rm -v $(pwd):/app sass node-sass --output-style compressed scss/style.scss > css/style.css
# Add comments for dev.
docker run --rm -v $(pwd):/app sass node-sass --source-comments scss/style.scss > css/style.css
# Add comments for dev.
docker run --rm sass node-sass --help
```

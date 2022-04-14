<?php

// Default Drupal settings.
//
// These are already explained with detailed comments in Drupal's
// default.settings.php file.
$databases = [];
$config_directories = [];
$settings['update_free_access'] = FALSE;
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];
$settings['entity_update_batch_size'] = 50;
$settings['entity_update_backup'] = TRUE;
$settings['migrate_node_migrate_type_classic'] = FALSE;

// The hash_salt should be a unique random value for each application.
// If left unset, the settings.platformsh.php file will attempt to provide one.
// You can also provide a specific value here if you prefer and it will be used
// instead. In most cases it's best to leave this blank on Platform.sh. You
// can configure a separate hash_salt in your settings.local.php file for
// local development.
// $settings['hash_salt'] = 'change_me';

// Set a default private files directory outside of the docroot.
$settings['file_private_path'] = '../private';

// Set a default config sync directory outside of the docroot.
// This is defined inside the read-only "config" directory, deployed via Git.
$settings['config_sync_directory'] = '../config/sync';

// Use Centarro Claro for update.php; should be unset if the site does not
// keep the Centarro Claro admin theme installed.
// @see https://github.com/centarro/centarro_claro
$settings['maintenance_theme'] = 'centarro_claro';

// Enable DDEV-Local specific configuration if running in that environment.
if (getenv('IS_DDEV_PROJECT') == 'true') {
  $config['config_split.config_split.ddev']['status'] = TRUE;
}
else {
  $config['config_split.config_split.ddev']['status'] = FALSE;
}

// Automatic Platform.sh settings.
if (file_exists($app_root . '/' . $site_path . '/settings.platformsh.php')) {
  include $app_root . '/' . $site_path . '/settings.platformsh.php';
}

// Lando Settings
if (file_exists($app_root . '/' . $site_path . '/settings.lando.php')) {
  include $app_root . '/' . $site_path . '/settings.lando.php';
}

// Local settings. These come last so that they can override anything.
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}

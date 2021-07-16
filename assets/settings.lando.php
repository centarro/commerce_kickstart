<?php

/* Working in local with Lando */

if (getenv('LANDO') !== 'ON') {
  return;
}

$lando_info = json_decode(getenv('LANDO_INFO'), TRUE);
$settings['trusted_host_patterns'] = ['.*'];
$settings['hash_salt'] = 'lTXdkpuxcwCgV7ibpN-6SRG9Hb6bpz6wvLMuFco-Qi7CnJ4tcSlIz-tfPGQFsajRSjY2nOnT-Q';

$databases['default']['default'] = [
  'driver' => 'mysql',
  'database' => $lando_info['database']['creds']['database'],
  'username' => $lando_info['database']['creds']['user'],
  'password' => $lando_info['database']['creds']['password'],
  'host' => $lando_info['database']['internal_connection']['host'],
  'port' => $lando_info['database']['internal_connection']['port'],
];

$config['environment_indicator.indicator']['bg_color'] = '#008F00';
$config['environment_indicator.indicator']['fg_color'] = '#FFFFFF';
$config['environment_indicator.indicator']['name'] = 'Lando';

$settings['file_private_path'] = '../private';

$class_loader->addPsr4('Drupal\\webprofiler\\', ['modules/contrib/devel/webprofiler/src']);
$settings['container_base_class'] = '\Drupal\webprofiler\DependencyInjection\TraceableContainer';

// Enable Redis caching.
if (isset($lando_info['redis']) && !\Drupal\Core\Installer\InstallerKernel::installationAttempted() && extension_loaded('redis') && class_exists('Drupal\redis\ClientFactory')) {
  // Set Redis as the default backend for any cache bin not otherwise specified.
  $settings['cache']['default'] = 'cache.backend.redis';
  $settings['redis.connection']['interface'] = 'PhpRedis';
  $settings['redis.connection']['host'] = $lando_info['redis']['internal_connection']['host'];

  // Apply changes to the container configuration to better leverage Redis.
  // This includes using Redis for the lock and flood control systems, as well
  // as the cache tag checksum. Alternatively, copy the contents of that file
  // to your project-specific services.yml file, modify as appropriate, and
  // remove this line.
  $settings['container_yamls'][] = 'modules/contrib/redis/example.services.yml';

  // Allow the services to work before the Redis module itself is enabled.
  $settings['container_yamls'][] = 'modules/contrib/redis/redis.services.yml';

  // Manually add the classloader path, this is required for the container cache bin definition below
  // and allows to use it without the redis module being enabled.
  $class_loader->addPsr4('Drupal\\redis\\', 'modules/contrib/redis/src');

  // Use redis for container cache.
  // The container cache is used to load the container definition itself, and
  // thus any configuration stored in the container itself is not available
  // yet. These lines force the container cache to use Redis rather than the
  // default SQL cache.
  $settings['bootstrap_container_definition'] = [
    'parameters' => [],
    'services' => [
      'redis.factory' => [
        'class' => 'Drupal\redis\ClientFactory',
      ],
      'cache.backend.redis' => [
        'class' => 'Drupal\redis\Cache\CacheBackendFactory',
        'arguments' => ['@redis.factory', '@cache_tags_provider.container', '@serialization.phpserialize'],
      ],
      'cache.container' => [
        'class' => '\Drupal\redis\Cache\PhpRedis',
        'factory' => ['@cache.backend.redis', 'get'],
        'arguments' => ['container'],
      ],
      'cache_tags_provider.container' => [
        'class' => 'Drupal\redis\Cache\RedisCacheTagsChecksum',
        'arguments' => ['@redis.factory'],
      ],
      'serialization.phpserialize' => [
        'class' => 'Drupal\Component\Serialization\PhpSerialize',
      ],
    ],
  ];
}

$config['raven.settings']['environment'] = 'lando';

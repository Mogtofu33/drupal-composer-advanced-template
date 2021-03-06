<?php

/**
 * @file
 * Local development override configuration feature for DEV.
 */

// Config split compatibility, set FALSE for Prod.
$config['config_split.config_split.config_dev']['status'] = TRUE;

// Local settings.
$settings['file_private_path'] = 'sites/default/files/private';
$settings['simple_environment_indicator'] = 'DarkGreen Dev';
$settings['simple_environment_anonymous'] = TRUE;

// Trusted host patterns settings.
// $settings['trusted_host_patterns'][] = '^MY_ENV_IP_OR_DOMAIN$';

// Drupal default dev settings from example.settings.local.php.

// Assertions
// assert_options(ASSERT_ACTIVE, TRUE);
// \Drupal\Component\Assertion\Handle::register();

// Drupal no cache from example.settings.local.php.
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';
$settings['cache']['bins']['render'] = 'cache.backend.null';
$settings['cache']['bins']['discovery_migration'] = 'cache.backend.memory';
$settings['cache']['bins']['page'] = 'cache.backend.null';
$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';
// $settings['extension_discovery_scan_tests'] = TRUE;
$settings['rebuild_access'] = TRUE;
$settings['skip_permissions_hardening'] = TRUE;

// Webprofiler specific settings
// $class_loader->addPsr4('Drupal\\webprofiler\\', [ __DIR__ . '/../../modules/contrib/devel/webprofiler/src']);
// $settings['container_base_class'] = '\Drupal\webprofiler\DependencyInjection\TraceableContainer';

<?php

/**
 * @file
 * Local development override configuration feature for PROD.
 */

// Config split compatibility, set FALSE for Prod.
$config['config_split.config_split.config_dev']['status'] = FALSE;

// Local settings.
$settings['file_private_path'] = 'sites/default/files/private';
$settings['simple_environment_indicator'] = 'DarkRed PROD';

// Trusted host patterns settings.
// $settings['trusted_host_patterns'][] = '^MY_ENV_IP_OR_DOMAIN$';

<?php

// choose the environment, and add the additional configuration for that environment as well
// This file is usually something like typo3conf/AdditionalConfiguration.Preview.php
// the context is set via .htaccess or web server configuration like 
// SetEnv TYPO3_ENVIRONMENT preview
if (isset($_SERVER['TYPO3_ENVIRONMENT'])) {
	$environment = strtolower($_SERVER['TYPO3_ENVIRONMENT']);
}

// @todo: check for command line parameter --environment


if (strlen($environment) > 0) {
	define('TYPO3_ENVIRONMENT', $environment);
	$additionalEnvironmentConfiguration = PATH_site . '/typo3conf/AdditionalConfiguration.' . ucfirst($environment) . '.php';
	if (file_exists($additionalEnvironmentConfiguration)) {
		require_once($additionalEnvironmentConfiguration);
	}
} else {
	// what if there is no environment variable is found? Then quit, otherwise the
	// request is called with no specific configuration and might have ugly side-effects
	die('EXT:environment: No environment variable TYPO3_ENVIRONMENT set.');
}

<?php

defined('TYPO3_MODE') or die();

// extract the extension configuration
$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['environment']);


// choose the context, and add the additional configuration for that context as well
// This file is usually something like typo3conf/AdditionalConfiguration.Development.php
// the context is set via .htaccess or web server configuration like
// SetEnv TYPO3_CONTEXT Development
if (isset($_SERVER['TYPO3_CONTEXT'])) {
	$context = $_SERVER['TYPO3_CONTEXT'];

// for web servers with CGI
} elseif ($_SERVER['REDIRECT_TYPO3_CONTEXT']) {
	$context = $_SERVER['REDIRECT_TYPO3_CONTEXT'];

} elseif (getenv('TYPO3_CONTEXT')) {
	$context = getenv('TYPO3_CONTEXT');

// check for command line parameter --context=Production
} elseif ($_SERVER['argc'] > 0) {
	// find --context=Production from the command line
	foreach ($_SERVER['argv'] as $argumentValue) {
		if (substr($argumentValue, 0, 10)  === '--context=') {
			$context = substr($argumentValue, 10);
			break;
		}
	}
}

// check if there is a file, outside of the htdocs/ directory
// it is outside the htdocs/ directory so it is not attached to the rest
// of the application
if (empty($context) && is_file(PATH_site . '../TYPO3_CONTEXT')) {
	$context = trim(file_get_contents(PATH_site . '../TYPO3_CONTEXT'));
}



// possibility to override the context (via extension configuration)
if (!empty($extensionConfiguration['forceContext'])) {
	$context = $extensionConfiguration['forceContext'];
}

// fallback to a certain context (like Production)
// useful for legacy projects that don't fully encorporate the Context principles yet
if (empty($context) && !empty($extensionConfiguration['fallbackContext'])) {
	$context = $extensionConfiguration['fallbackContext'];
}


if (!empty($context)) {

	// define a constant, and define the $_SERVER['TYPO3_CONTEXT'] for typoscript condition
	define('TYPO3_CONTEXT', $context);
	$_SERVER['TYPO3_CONTEXT'] = $context;
	putenv('TYPO3_CONTEXT=' . $context);

	// check for "Production/Live/Server1" etc
	list($contextMainPart, $contextSubPart1, $contextSubPart2)  = explode('/', $context);

	// include the most general file e.g. "AdditionalConfiguration.Staging.php"
	$additionalContextConfiguration = PATH_site . '/typo3conf/AdditionalConfiguration.' . $contextMainPart . '.php';
	if (file_exists($additionalContextConfiguration)) {
		require_once($additionalContextConfiguration);
	}

	// check for a more specific configuration as well e.g. "AdditionalConfiguration.Development.Profiling.php"
	$additionalContextConfiguration = PATH_site . '/typo3conf/AdditionalConfiguration.' . $contextMainPart . '.' . $contextSubPart1 . '.php';
	if (file_exists($additionalContextConfiguration)) {
		require_once($additionalContextConfiguration);
	}

	// check for a more specific configuration as well, e.g. "AdditionalConfiguration.Production.Live.Server4.php"
	$additionalContextConfiguration = PATH_site . '/typo3conf/AdditionalConfiguration.' . $contextMainPart . '.' . $contextSubPart1 . '.' . $contextSubPart2 . '.php';
	if (file_exists($additionalContextConfiguration)) {
		require_once($additionalContextConfiguration);
	}

	// add the context information to the site name
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] .= ' - ' . $context;

	// since there is no unified hook available for 4.5 and 6.0 during bootstrap,
	// all necessary handlers are set up at this point

} else {

	// no context variable is found Then quit, otherwise the
	// request is called with no specific configuration and might have ugly side-effects
	die('EXT:environment: No context variable TYPO3_CONTEXT set.');
}

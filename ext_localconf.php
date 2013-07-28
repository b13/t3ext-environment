<?php

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// register XLASS for TYPO3 4.x installations
//  - if 5.2.x is in use => 4.5 max (= no namespaces)
//  - if the namespaced GeneralUtility is not found => 4.x
if (version_compare(PHP_VERSION, '5.3.0') < 0 || !class_exists('\\TYPO3\\CMS\\Core\\Utility\\GeneralUtility')) {
	$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['t3lib/class.t3lib_mail_mailer.php'] = t3lib_extMgm::extPath('environment', 'Classes/)
}

<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

// check if a swiftmailer plugins needs to be added to redirect all emails to a separate email address,
// due to uncool implementation in TYPO3 Core, this needs to be done via XCLASS currently
// the XCLASS for 4.x is registered in ext_localconf.php
if (isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['environment']['redirectEmails'])) {

	// register XLASS for TYPO3 4.x installations
	//  - if 5.2.x is in use => 4.5 max (= no namespaces)
	//  - if the namespaced GeneralUtility is not found => 4.x
	if (version_compare(PHP_VERSION, '5.3.0') < 0 || !class_exists('\\TYPO3\\CMS\\Core\\Utility\\GeneralUtility')) {
		$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['t3lib/class.t3lib_mail_mailer.php'] = t3lib_extMgm::extPath('environment', 'Classes/Mail/LegacySwiftMailer.php');
	} else {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\Mail\\Mailer'] = array(
			'className' => 'B13\\Environment\\Mail\\SwiftMailer'
		);
	}
}

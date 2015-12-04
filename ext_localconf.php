<?php

defined('TYPO3_MODE') or die();

// check if a swiftmailer plugins needs to be added to redirect all emails to a separate email address,
// due to uncool implementation in TYPO3 Core, this needs to be done via XCLASS currently
if (isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['environment']['redirectEmails'])) {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\Mail\\Mailer'] = array(
		'className' => 'B13\\Environment\\Mail\\SwiftMailer'
	);
}

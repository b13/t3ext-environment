<?php
$GLOBALS['TYPO3_CONF_VARS']['DB']['database'] = 'production_db';
$GLOBALS['TYPO3_CONF_VARS']['DB']['host'] = 'production_db.host';
$GLOBALS['TYPO3_CONF_VARS']['DB']['password'] = 'production_db.password';
$GLOBALS['TYPO3_CONF_VARS']['DB']['username'] = 'production_db.user';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['cookieDomain'] = '.production.host.tld';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['curlUse'] = '1';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] = 'yourIpHere';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = '2';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['sqlDebug'] = '0';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] = '';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pages']['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\ApcBackend';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pages']['options'] = array();
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pagesection']['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\ApcBackend';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pagesection']['options'] = array();
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_hash']['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\ApcBackend';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_hash']['options'] = array();
?>

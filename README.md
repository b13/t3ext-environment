TYPO3 Extension Environment
===========================

Created by Benjamin Mack, b:dreizehn GmbH, in 2013.
Published under the MIT license.

What does it do?
----------------

The TYPO3 extension "Environment", compatible with TYPO3 CMS 4.5 until
TYPO3 CMS 7.99.99, allows for context-specific settings, so the TYPO3
installation has different options for each context. This means that all
logging and debugging settings can be turned on for the development
environment.

Of course, this extension makes most sense if you have multiple server scenarios and a local development environment.


Installation
------------

1) Install the extension.

2) Add the following Rewrite statements to your .htaccess file after the RewriteBase
statement or to your Apache webserver configuration.

    # Make sure the context variable is set with every http request
    RewriteCond %{HTTP_HOST} ^(.*)staging-system\.org$
    RewriteRule .? - [E=TYPO3_CONTEXT:Production/Staging]

    RewriteCond %{HTTP_HOST} ^(.*)development-system\.org$
    RewriteRule .? - [E=TYPO3_CONTEXT:Development]


3) Add the following code to your typo3conf/AdditionalConfiguration.php for
TYPO3 CMS >= 6.0

	// load the environment / context configuration for this installation
	if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('environment')) {
		include('ext/environment/Includes/Bootstrap/InitializeContext.php');
	}

3a) For installations prior to 6.0, please include this at the bottom of the localconf.php

	// load the environment / context configuration for this installation
	if (t3lib_extMgm::isLoaded('environment')) {
		include('ext/environment/Includes/Bootstrap/InitializeContext.php');
	}

3b) For installations using TYPO3 CMS 6.2+, just add this to your typo3conf/AdditionalConfiguration.php

	// load the environment / context configuration for this installation
	include('ext/environment/Includes/Bootstrap/InitializeContext.php');

After that, you have a PHP constant named "TYPO3_CONTEXT" that
is set to the environment variable placed in your server settings.

4) You can now define context-specific configurations, and create files like

 * typo3conf/AdditionalConfiguration.Development.php
 * typo3conf/AdditionalConfiguration.Production.php

and add configuration options like different DB settings and debugging
settings, that get included depending on what context you have set in your
server settings. Examples are provided in 
[Resources/Public/Examples](https://github.com/b13/t3ext-environment/tree/master/Resources/Public/Examples).

Please make sure that the PHP files always start with the following lines

	<?php
	
	if (!defined('TYPO3_MODE')) {
		die('Access denied.');
	}


Best practices
--------------

Development Environment

 * mails should only be sent locally
 * all debug modes are set to full logging
 * caching is disabled by default

Integration Environment

 * testing environment for unit tests etc.

Production/Staging Environment

 * Clone of the "Live" server for (customer) acceptance testing

Production Environment
 * "Live" server


Of course any other environment name can be chosen.


Setting the environment for scheduler tasks
-------------------------------------------

Usually the TYPO3 scheduler is called like this:

/usr/bin/php5 /path/to/my/typo3/installation/typo3/cli_dispatch.phpsh scheduler

this should be modified at all times to set the environment variable

/usr/bin/php5 /path/to/my/typo3/installation/typo3/cli_dispatch.phpsh scheduler --context=Production


Environment-dependent TypoScript
--------------------------------
You can check the environment with the following TypoScript condition.

	# disable tracking for Production/Staging environment
	[globalString = ENV:TYPO3_CONTEXT = Production/Staging]
		page.20 >
	[GLOBAL]

With TYPO3 CMS 6.2, you can use the newly defined "applicationContext" TypoScript condition.


Environment-dependent email redirection
---------------------------------------
You can redirect any outgoing email to a specific email address by setting the
following TYPO3_CONF_VARS option:

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['environment']['redirectEmails'] = 'benni@typo3.org';

You can add multiple addresses separated via comma, or in a simple array.

It makes most sense if you put this in a environment-dependent installation like
typo3conf/AdditionalConfiguration.Development.php and remove it in the
Production environment settings.


Thanks
------

Big thanks goes to:

 * the b13 specialists for braining and finding the optimal out-of-the-box solutions,
 * Jesus Christ who saved my life.

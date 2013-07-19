Installation
============


Add this to your .htaccess file

	# Make sure the environment variable is set
	SetEnv TYPO3_ENVIRONMENT preview


Add this to your typo3conf/AdditionalConfiguration.php

	// load the environment / contexts for this installation
	include('ext/environment/Includes/Bootstrap/LoadEnvironment.php');


Create Environment specific configurations, files like

 * typo3conf/AdditionalConfiguration.Integration.php
 * typo3conf/AdditionalConfiguration.Development.php
 * typo3conf/AdditionalConfiguration.Preview.php
 * typo3conf/AdditionalConfiguration.Production.php

and add configuration options like different DB settings
and debugging settings.

After that, you have a PHP constant named "TYPO3_ENVIRONMENT" that
is set to the environment variable placed in your server settings.


Best practices
--------------

Development Environment
 * mails should only be sent locally
 * all debug modes are set to full logging
 * caching is disabled by default

Integration Environment
 * testing environment for unit tests

Preview Environment
 * instance for clients to test the site

Production Environment
 * "Live" server


Of course any other environment name can be chosen.


Setting the environment for scheduler tasks 
-------------------------------------------

Usually the TYPO3 scheduler is called like this:

/usr/bin/php5 /path/to/my/typo3/installation/typo3/cli_dispatch.phpsh scheduler

this should be modified at all times to set the environment variable

/usr/bin/php5 /path/to/my/typo3/installation/typo3/cli_dispatch.phpsh scheduler --environment=preview



Environment-dependent TypoScript
--------------------------------
You can check the environment with the following TypoScript condition.

# disable tracking for preview machine
[globalString = IENV:TYPO3_ENVIRONMENT = preview]
	page.20 >
[GLOBAL]

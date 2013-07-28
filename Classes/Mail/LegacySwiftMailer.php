<?php
/***************************************************************
 *
 *  The MIT License (MIT)
 *
 *  Copyright (c) 2013 b:dreizehn GmbH, Stuttgart
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy of
 *  this software and associated documentation files (the "Software"), to deal in
 *  the Software without restriction, including without limitation the rights to
 *  use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 *  the Software, and to permit persons to whom the Software is furnished to do so,
 *  subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 *  FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 *  COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 *  IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 *  CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 ***************************************************************/

/**
 * Adapter for Swift_Mailer to add a plugin
 * for each Mailer instance, used for 4.x installations
 *
 * @author Benjamin Mack <benjamin.mack@b13.de>
 */
class ux_t3lib_mail_Mailer extends t3lib_mail_Mailer {

	/**
	 * When constructing, add the redirector plugin
	 *
	 * @param null|Swift_Transport $transport optionally pass a transport to the constructor.
	 * @throws t3lib_exception
	 */
	public function __construct(Swift_Transport $transport = NULL) {
		parent::__construct($this->transport);

		// get the email address that should be redirected
		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['environment']);
		if (!empty($extensionConfiguration['redirectEmails'])) {
			$this->registerPlugin(
				new Swift_Plugins_RedirectingPlugin($extensionConfiguration['redirectEmails'], array('#^' . $extensionConfiguration['redirectEmails'] . '$#'))
			);
		}
	}

}
<?php
// load the environment / context configuration for this installation
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('environment')) {
    include('ext/environment/Includes/Bootstrap/InitializeContext.php');
}
?>

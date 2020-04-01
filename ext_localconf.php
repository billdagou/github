<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('@import "EXT:github/Configuration/TypoScript/setup.typoscript"');

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['github'] = \Dagou\Github\Controller\EidController::class.'::processRequest';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['github'] = [
    'Dagou\\Github\\ViewHelpers',
];
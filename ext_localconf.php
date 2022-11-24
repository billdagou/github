<?php
defined('TYPO3_MODE') || die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['be'] = [
    'TYPO3\\CMS\\Backend\\ViewHelpers',
];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['c'] = [
    'TYPO3\\CMS\\Core\\ViewHelpers',
];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['github'] = [
    'Dagou\\Github\\ViewHelpers',
];
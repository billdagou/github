<?php
namespace Dagou\Github\UserFunction\TCA;

use TYPO3\CMS\Core\Crypto\Random;

class Slug {
    /**
     * @return string
     */
    public function appearancePrefix(): string {
        return '';
    }

    /**
     * @return string
     */
    public function postModifier(): string {
        return (new Random())->generateRandomHexString(16);
    }
}
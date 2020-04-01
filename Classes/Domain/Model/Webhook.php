<?php
namespace Dagou\Github\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Webhook extends AbstractEntity {
    /**
     * @var bool
     */
    protected $disabled;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $secret;

    /**
     * @return bool
     */
    public function getDisabled(): bool {
        return $this->disabled ?? FALSE;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title ?? '';
    }

    /**
     * @return string
     */
    public function getSecret(): string {
        return $this->secret ?? '';
    }
}
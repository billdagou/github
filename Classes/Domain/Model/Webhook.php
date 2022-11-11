<?php
namespace Dagou\Github\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Webhook extends AbstractEntity {
    protected bool $disabled = FALSE;
    protected string $title = '';
    protected string $secret = '';

    /**
     * @return bool
     */
    public function getDisabled(): bool {
        return $this->disabled;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSecret(): string {
        return $this->secret;
    }
}
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
    protected $contentType;
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
    public function getContentType(): string {
        $contentTypes = [
            \Dagou\Github\Interfaces\Webhook::CONTENT_TYPE_FORM => 'application/x-www-form-urlencoded',
            \Dagou\Github\Interfaces\Webhook::CONTENT_TYPE_JSON => 'application/json',
        ];

        return $contentTypes[$this->contentType] ?? '';
    }

    /**
     * @return string
     */
    public function getSecret(): string {
        return $this->secret ?? '';
    }
}
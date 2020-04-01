<?php
namespace Dagou\Github\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class WebhookRepository extends Repository {
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'uid' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\QueryInterface
     */
    public function createQuery(): QueryInterface {
        $query = parent::createQuery();

        $query->getQuerySettings()
            ->setIgnoreEnableFields(TRUE);

        return $query;
    }
}
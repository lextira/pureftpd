<?php

namespace App\Data\Criteria;

use App\Data\Models\Account;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class DomainIdCriteria.
 *
 * @package namespace App\Data\Criteria;
 */
class DomainIDCriteria implements CriteriaInterface
{
    protected $domainID;

    public function __construct($domainID)
    {
        $this->domainID = $domainID;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Account             $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('domain_id', $this->domainID);
    }

    public function getDomainID()
    {
        return $this->domainID;
    }
}

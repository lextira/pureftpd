<?php

namespace App\Data\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class IDCriteria.
 *
 * @package namespace App\Data\Criteria;
 */
class IDCriteria implements CriteriaInterface
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('id', $this->id);
    }

    public function getID()
    {
        return $this->id;
    }
}

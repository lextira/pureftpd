<?php

namespace App\Data\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use App\Data\Repositories\Interfaces\DomainRepository;
use App\Data\Models\Domain;

/**
 * Class DomainRepositoryEloquent.
 *
 * @package namespace App\Data\Repositories;
 */
class DomainRepositoryEloquent extends BaseRepositoryEloquent implements DomainRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Domain::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

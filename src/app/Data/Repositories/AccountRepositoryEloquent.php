<?php

namespace App\Data\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use App\Data\Repositories\Interfaces\AccountRepository;
use App\Data\Models\Account;

/**
 * Class AccountRepositoryEloquent.
 *
 * @package namespace App\Data\Repositories;
 */
class AccountRepositoryEloquent extends BaseRepositoryEloquent implements AccountRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Account::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

<?php

namespace App\Data\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use App\Data\Repositories\Interfaces\UserRepository;
use App\Data\Models\User;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Data\Repositories;
 */
class UserRepositoryEloquent extends BaseRepositoryEloquent implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

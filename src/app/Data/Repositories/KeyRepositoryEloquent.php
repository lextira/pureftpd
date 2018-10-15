<?php

namespace App\Data\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Data\Repositories\Interfaces\KeyRepository;
use App\Data\Models\Key;

/**
 * Class KeyRepositoryEloquent.
 *
 * @package namespace App\Data\Repositories;
 */
class KeyRepositoryEloquent extends BaseRepository implements KeyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Key::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

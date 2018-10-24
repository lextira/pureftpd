<?php

namespace App\Data\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;

/**
 * Class AccountRepositoryEloquent.
 *
 * @package namespace App\Data\Repositories;
 */
abstract class BaseRepositoryEloquent extends BaseRepository
{
    /**
     * Updates model but filters model by criterias first
     *
     * @param $data
     * @param $id
     * @return mixed
     */
    public function updateWithCriteria($data, $id)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = $this->find($id);

        $this->skipPresenter($temporarySkipPresenter);

        $model->fill($data);

        event(new RepositoryEntityUpdated($this, $model));

        $model->save();
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function firstByFieldOrFail($field, $value = null, $columns = ['*'])
    {
        $result = $this->findByField($field, $value, $columns)->first();

        if (!$result) {
            throw (new ModelNotFoundException())->setModel(get_class($this->model));
        }

        return $result;
    }
}

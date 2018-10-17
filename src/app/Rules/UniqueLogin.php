<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Prettus\Repository\Contracts\RepositoryInterface;

class UniqueLogin implements Rule
{
    protected $repository;
    protected $domainID;
    protected $exceptID;

    /**
     * Create a new rule instance.
     *
     * @param RepositoryInterface $repository
     * @param int $domainID
     * @param string $divider
     * @param null|int $exceptID
     */
    public function __construct(RepositoryInterface $repository, $domainID, $exceptID=null)
    {
        $this->repository = $repository;
        $this->domainID = $domainID;
        $this->exceptID = $exceptID;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $separator = config('ftp.domain_separator');
        return $this->repository->findWhere([
                'domain_id' => $this->domainID,
                [$attribute, 'LIKE', $value . $separator . '%'],
                ['id', '!=', $this->exceptID],
            ])->isEmpty();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Login must be unique for domain.';
    }
}

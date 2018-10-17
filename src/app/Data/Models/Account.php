<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Account",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/account_readonly_fields"),
 *         @OA\Schema(ref="#/components/schemas/account_editable_fields"),
 *     }
 * )
 * @OA\Schema(
 *     schema="account_readonly_fields",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1,
 *     ),
 *     @OA\Property(
 *         property="domain_id",
 *         type="integer",
 *         example=1,
 *     )
 * )
 * @OA\Schema(
 *     schema="account_editable_fields",
 *     required={"login", "password", "relative_dir"},
 *     @OA\Property(
 *         property="login",
 *         type="string",
 *         example="mylogin@domain",
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         example="hashed_password",
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="integer",
 *         example=1,
 *     ),
 *     @OA\Property(
 *         property="relative_dir",
 *         type="integer",
 *         example="sub/dir",
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Account description",
 *     )
 * )
 */
class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain_id',
        'login',
        'password',
        'status',
        'relative_dir',
        'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'absolute_dir'
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    protected function setLoginAttribute($name)
    {
        $domain_separator = config('ftp.domain_separator');

        $this->attributes['login'] =
            $name .
            $domain_separator .
            $this->domain->name;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = md5($password);
    }

    public function setHashedPasswordAttribute($hashed_password)
    {
        $this->attributes['password'] = $hashed_password;
    }

    /**
     * This function is called by App\Observers\AccountObserver
     * to generate pureftpd related data and add it to the model.
     *
     * @var array
     */
    public function setGeneratedFields()
    {
        $this->absolute_dir = $this->generateAbsoluteDir();
    }

    protected function generateAbsoluteDir()
    {
        $base_dir = $this->domain->getBaseDirectory() . '/';

        return
            $base_dir .
            $this->relative_dir;
    }
}

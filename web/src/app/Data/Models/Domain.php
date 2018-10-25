<?php

namespace App\Data\Models;

use App\Http\Controllers\AccountController;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="Domain")
 * @OA\Property(
 *     property="id",
 *     type="integer",
 *     example=1,
 * )
 * @OA\Property(
 *     property="name",
 *     type="string",
 *     example="domain.test",
 * )
 */
class Domain extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function keys()
    {
        return $this->hasMany(Key::class);
    }

    public function getBaseDirectory()
    {
        $base_dir = config('ftp.data_base_dir') . '/';

        return $base_dir . $this->id . '/' ;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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


    public function getBaseDirectory()
    {
        $base_dir = config('ftp.data_base_dir') . '/';

        return $base_dir . $this->id . '/' ;
    }
}

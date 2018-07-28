<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain_id',
        'token',
        'description',
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

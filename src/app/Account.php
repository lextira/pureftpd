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
        'name',
        'password',
        'status',
        'relative_dir',
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
        $this->belongsTo(Domain::class);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = md5($password);
    }

    /**
     * This function is called by App\Observers\AccountObserver
     * to generate pureftpd related data and add it to the model.
     *
     * @var array
     */
    public function setGeneratedFields()
    {
        $this->login = $this->generateLogin();
        $this->absolute_dir = $this->generateAbsoluteDir();
    }

    protected function generateLogin()
    {
        $domain_separator = config('ftp.domain_separator');

        return
            $this->name .
            $domain_separator .
            $this->domain->name;
    }

    protected function generateAbsoluteDir()
    {
        $base_dir = $this->domain->getBaseDirectory() . '/';

        return
            $base_dir .
            $this->relative_dir;
    }


}

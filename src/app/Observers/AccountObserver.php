<?php

namespace App\Observers;

use App\Account;

class AccountObserver
{
    /**
     * Handle the account "creating" event.
     *
     * @param  \App\Account  $account
     * @return void
     */
    public function creating(Account $account)
    {
        $account->setGeneratedFields();
    }

    /**
     * Handle the account "updating" event.
     *
     * @param  \App\Account  $account
     * @return void
     */
    public function updating(Account $account)
    {
        $account->setGeneratedFields();
    }

    /**
     * Handle the account "saving" event.
     *
     * @param  \App\Account  $account
     * @return void
     */
    public function saving(Account $account)
    {
        $account->setGeneratedFields();
    }
}

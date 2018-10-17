<?php

namespace App\Observers;

use App\Data\Models\Account;

class AccountObserver
{
    /**
     * Handle the account "creating" event.
     *
     * @param Account $account
     * @return void
     */
    public function creating(Account $account)
    {
        $account->setGeneratedFields();
    }

    /**
     * Handle the account "updating" event.
     *
     * @param Account $account
     * @return void
     */
    public function updating(Account $account)
    {
        $account->setGeneratedFields();
    }

    /**
     * Handle the account "saving" event.
     *
     * @param Account $account
     * @return void
     */
    public function saving(Account $account)
    {
        $account->setGeneratedFields();
    }
}

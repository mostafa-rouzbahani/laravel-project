<?php

namespace App\Policies;

use App\User;
use App\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any transactions.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the transaction.
     *
     * @param User $user
     * @param Transaction $transaction
     * @return mixed
     */
    public function view(User $user, Transaction $transaction)
    {
        //
    }

    /**
     * Determine whether the user can create transactions.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the transaction.
     *
     * @param User $user
     * @param Transaction $transaction
     * @return mixed
     */
    public function update(User $user, Transaction $transaction)
    {
        if($user->id === $transaction->b_user_id || $user->id === $transaction->s_user_id || $user->isAdmin()){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can cancel the transaction.
     *
     * @param User $user
     * @param Transaction $transaction
     * @return mixed
     */
    public function cancel(User $user, Transaction $transaction)
    {
        return $user->id === $transaction->b_user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the transaction.
     *
     * @param User $user
     * @param Transaction $transaction
     * @return mixed
     */
    public function delete(User $user, Transaction $transaction)
    {
        //
    }

    /**
     * Determine whether the user can restore the transaction.
     *
     * @param User $user
     * @param Transaction $transaction
     * @return mixed
     */
    public function restore(User $user, Transaction $transaction)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the transaction.
     *
     * @param User $user
     * @param Transaction $transaction
     * @return mixed
     */
    public function forceDelete(User $user, Transaction $transaction)
    {
        //
    }
}

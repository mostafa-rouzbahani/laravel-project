<?php

namespace App\Policies;

use App\User;
use App\Advertisement;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertisementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any advertisements.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the advertisement.
     *
     * @param  \App\User  $user
     * @param  \App\Advertisement  $advertisement
     * @return mixed
     */
    public function view(User $user, Advertisement $advertisement)
    {
        //
    }

    /**
     * Determine whether the user can create advertisements.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the advertisement.
     *
     * @param  \App\User  $user
     * @param  \App\Advertisement  $advertisement
     * @return mixed
     */
    public function update(User $user, Advertisement $advertisement)
    {
        return $user->id === $advertisement->user_id;
    }

    /**
     * Determine whether the user can delete the advertisement.
     *
     * @param  \App\User  $user
     * @param  \App\Advertisement  $advertisement
     * @return mixed
     */
    public function delete(User $user, Advertisement $advertisement)
    {
        return $user->id === $advertisement->user_id;
    }

    /**
     * Determine whether the user can restore the advertisement.
     *
     * @param  \App\User  $user
     * @param  \App\Advertisement  $advertisement
     * @return mixed
     */
    public function restore(User $user, Advertisement $advertisement)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the advertisement.
     *
     * @param  \App\User  $user
     * @param  \App\Advertisement  $advertisement
     * @return mixed
     */
    public function forceDelete(User $user, Advertisement $advertisement)
    {
        //
    }
}

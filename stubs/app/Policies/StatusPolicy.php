<?php

namespace App\Policies;

use App\Models\{Status, User};

class StatusPolicy
{
	/**
	 * Determine whether the user can view any models.
	 */
	public function viewAny(User $user): bool
	{
		return $user->can("view statuses");
	}

	/**
	 * Determine whether the user can lazyily view any models.
	 */
	public function lazyViewAny(User $user): bool
	{
		return $this->viewAny($user);
	}

	/**
	 * Determine whether the user can create models.
	 */
	public function create(User $user): bool
	{
		return $user->can("create statuses");
	}

	/**
	 * Determine whether the user can store the model.
	 */
	public function store(User $user, $context = null): bool
	{
		return $this->create($user);
	}

	/**
	 * Determine whether the user can view the model.
	 */
	public function view(User $user, Status $status): bool
	{
		return $this->viewAny($user);
	}

	/**
	 * Determine whether the user can edit the model.
	 */
	public function edit(User $user, Status $status): bool
	{
		return $user->can("edit statuses");
	}

	/**
	 * Determine whether the user can update the model.
	 */
	public function update(User $user, Status $status, $context = null): bool
	{
		return $this->edit($user, $status);
	}

	/**
	 * Determine whether the user can delete the model.
	 */
	public function delete(User $user, Status $status, $context = null): bool
	{
		return $user->can("delete statuses");
	}

	/**
	 * Determine whether the user can restore the model.
	 */
	public function restore(User $user, Status $status): bool
	{
		return $user->can("restore statuses");
	}

	/**
	 * Determine whether the user can permanently delete the model.
	 */
	public function forceDelete(User $user, Status $status): bool
	{
		return $user->can("force delete statuses");
	}
}

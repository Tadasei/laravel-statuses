<?php

namespace App\Models;

use App\Enums\StatusableType;

use Illuminate\Database\Eloquent\{
	Factories\HasFactory,
	Builder,
	Model
};

class Status extends Model
{
	/** @use HasFactory<\Database\Factories\StatusFactory> */
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		"statusable_type",
		"name",
		"color",
		"is_initial",
		"is_final",
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			"statusable_type" => StatusableType::class,

			"is_initial" => "boolean",

			"is_final" => "boolean",
		];
	}

	/**
	 * Scope a query to only include initial statuses.
	 */
	public function scopeIsInitial(Builder $query): void
	{
		$query->where("is_initial", true);
	}

	/**
	 * Scope a query to only include non initial statuses.
	 */
	public function scopeIsNotInitial(Builder $query): void
	{
		$query->where("is_initial", false);
	}

	/**
	 * Scope a query to only include final statuses.
	 */
	public function scopeIsfinal(Builder $query): void
	{
		$query->where("is_final", true);
	}

	/**
	 * Scope a query to only include non final statuses.
	 */
	public function scopeIsNotfinal(Builder $query): void
	{
		$query->where("is_final", false);
	}
}

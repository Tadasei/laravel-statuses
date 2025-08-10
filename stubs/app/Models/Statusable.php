<?php

namespace App\Models;

use App\Enums\StatusableType;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Statusable extends MorphPivot
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = ["statusable_type", "statusable_id", "status_id"];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			"statusable_type" => StatusableType::class,
		];
	}
}

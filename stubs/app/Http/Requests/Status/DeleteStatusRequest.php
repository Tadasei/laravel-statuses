<?php

namespace App\Http\Requests\Status;

use App\Models\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteStatusRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			"statuses" => ["required", "array"],

			"statuses.*" => [
				"distinct:strict",
				"numeric",
				"integer",
				Rule::exists(Status::class, "id"),
			],
		];
	}
}

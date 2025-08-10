<?php

namespace App\Http\Requests\Status;

use App\Enums\StatusableType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StatusRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			"statusable_type" => [
				"required",
				"string",
				Rule::enum(StatusableType::class),
			],

			"name" => ["required", "string", "max:255"],

			"color" => ["required", "string", "hex_color"],

			"is_initial" => ["required", "boolean"],

			"is_final" => ["required", "boolean"],
		];
	}
}

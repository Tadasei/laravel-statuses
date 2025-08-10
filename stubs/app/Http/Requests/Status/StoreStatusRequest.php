<?php

namespace App\Http\Requests\Status;

use App\Models\Status;
use Illuminate\Validation\Validator;

class StoreStatusRequest extends StatusRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return array_merge_recursive(parent::rules(), [
			//Add custom rules here for the store method only
		]);
	}

	/**
	 * Get the "after" validation callables for the request.
	 */
	public function after(): array
	{
		return [
			function (Validator $validator) {
				if ($this->nameExistsForStatusableType()) {
					$validator
						->errors()
						->add(
							"name",
							__("validation.unique", ["attribute" => "name"]),
						);
				}
			},
		];
	}

	protected function nameExistsForStatusableType(): bool
	{
		return Status::where([
			["statusable_type", "=", $this->statusable_type],
			["name", "=", $this->name],
		])->exists();
	}
}

<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Status;

use Tests\{
	Traits\HandlesUsers,
	TestCase
};

class StatusControllerTest extends TestCase
{
	use HandlesUsers;

	/**
	 * store method request validation test.
	 */
	public function test_store_endpoint_rejects_invalid_data(): void
	{
		$user = $this->createUserWithPermissions(["create statuses"]);

		$response = $this->actingAs($user)->postJson(route("statuses.store"), [
			"statusable_type" => null,
			"name" => null,
			"color" => null,
			"is_initial" => null,
			"is_final" => null,
		]);

		$response->assertUnprocessable();

		$response->assertInvalid([
			"statusable_type",
			"name",
			"color",
			"is_initial",
			"is_final",
		]);
	}

	/**
	 * update method request validation test.
	 */
	public function test_update_endpoint_rejects_invalid_data(): void
	{
		$user = $this->createUserWithPermissions(["edit statuses"]);

		$status = Status::factory()->createOne();

		$response = $this->actingAs($user)->patchJson(
			route("statuses.update", ["status" => $status->id]),
			[
				"statusable_type" => null,
				"name" => null,
				"color" => null,
				"is_initial" => null,
				"is_final" => null,
			],
		);

		$response->assertUnprocessable();

		$response->assertInvalid([
			"statusable_type",
			"name",
			"color",
			"is_initial",
			"is_final",
		]);
	}

	/**
	 * destroy method request validation test.
	 */
	public function test_destroy_endpoint_rejects_invalid_data(): void
	{
		$user = $this->createUserWithPermissions(["delete statuses"]);

		$status = Status::factory()->createOne();

		$response = $this->actingAs($user)->deleteJson(
			route("statuses.destroy"),
			[
				"statuses" => [
					-1, // Invalid ID to test validation
					$status->id,
				],
			],
		);

		$response->assertUnprocessable();

		$response->assertInvalid(["statuses.0"]);
	}

	/**
	 * lazy method authorization test.
	 */
	public function test_lazy_endpoint_denies_unauthorized_user(): void
	{
		$user = $this->createUserWithoutPermissions(["view statuses"]);

		$response = $this->actingAs($user)->putJson(route("statuses.lazy"), [
			"paginate" => false,
		]);

		$response->assertForbidden();
	}

	/**
	 * index method authorization test.
	 */
	public function test_index_endpoint_denies_unauthorized_user(): void
	{
		$user = $this->createUserWithoutPermissions(["view statuses"]);

		$response = $this->actingAs($user)->getJson(route("statuses.index"));

		$response->assertForbidden();
	}

	/**
	 * store method authorization test.
	 */
	public function test_store_endpoint_denies_unauthorized_user(): void
	{
		$user = $this->createUserWithoutPermissions(["create statuses"]);

		$status = Status::factory()->makeOne();

		$response = $this->actingAs($user)->postJson(route("statuses.store"), [
			...$status->only(["name", "color", "is_initial", "is_final"]),
			"statusable_type" => $status->statusable_type->value,
		]);

		$response->assertForbidden();
	}

	/**
	 * show method authorization test.
	 */
	public function test_show_endpoint_denies_unauthorized_user(): void
	{
		$user = $this->createUserWithoutPermissions(["view statuses"]);

		$status = Status::factory()->createOne();

		$response = $this->actingAs($user)->getJson(
			route("statuses.show", [
				"status" => $status->id,
			]),
		);

		$response->assertForbidden();
	}

	/**
	 * update method authorization test.
	 */
	public function test_update_endpoint_denies_unauthorized_user(): void
	{
		$user = $this->createUserWithoutPermissions(["edit statuses"]);

		$status = Status::factory()->createOne();

		$updatedStatus = Status::factory()->makeOne();

		$response = $this->actingAs($user)->patchJson(
			route("statuses.update", [
				"status" => $status->id,
			]),
			[
				...$updatedStatus->only([
					"name",
					"color",
					"is_initial",
					"is_final",
				]),
				"statusable_type" => $updatedStatus->statusable_type->value,
			],
		);

		$response->assertForbidden();
	}

	/**
	 * destroy method authorization test.
	 */
	public function test_destroy_endpoint_denies_unauthorized_user(): void
	{
		$user = $this->createUserWithoutPermissions(["delete statuses"]);

		$status = Status::factory()->createOne();

		$response = $this->actingAs($user)->deleteJson(
			route("statuses.destroy"),
			[
				"statuses" => [$status->id],
			],
		);

		$response->assertForbidden();
	}

	/**
	 * lazy method exceptions test.
	 */
	public function test_lazy_endpoint_throws_no_exception(): void
	{
		$user = $this->createUserWithPermissions(["view statuses"]);

		$response = $this->actingAs($user)->putJson(route("statuses.lazy"), [
			"paginate" => false,
		]);

		$response->assertOk();
	}

	/**
	 * index method exceptions test.
	 */
	public function test_index_endpoint_throws_no_exception(): void
	{
		$user = $this->createUserWithPermissions(["view statuses"]);

		$response = $this->actingAs($user)->getJson(route("statuses.index"));

		$response->assertOk();
	}

	/**
	 * store method exceptions test.
	 */
	public function test_store_endpoint_throws_no_exception(): void
	{
		$user = $this->createUserWithPermissions(["create statuses"]);

		$status = Status::factory()->makeOne();

		$response = $this->actingAs($user)->postJson(route("statuses.store"), [
			...$status->only(["name", "color", "is_initial", "is_final"]),
			"statusable_type" => $status->statusable_type->value,
		]);

		$response->assertCreated();

		$this->assertDatabaseHas(Status::class, [
			...$status->only(["name", "color", "is_initial", "is_final"]),
			"statusable_type" => $status->statusable_type->value,
			"id" => $response["id"],
		]);
	}

	/**
	 * show method exceptions test.
	 */
	public function test_show_endpoint_throws_no_exception(): void
	{
		$user = $this->createUserWithPermissions(["view statuses"]);

		$status = Status::factory()->createOne();

		$response = $this->actingAs($user)->getJson(
			route("statuses.show", [
				"status" => $status->id,
			]),
		);

		$response->assertOk();
	}

	/**
	 * update method exceptions test.
	 */
	public function test_update_endpoint_throws_no_exception(): void
	{
		$user = $this->createUserWithPermissions(["edit statuses"]);

		$status = Status::factory()->createOne();

		$updatedStatus = Status::factory()->makeOne();

		$response = $this->actingAs($user)->patchJson(
			route("statuses.update", [
				"status" => $status->id,
			]),
			[
				...$updatedStatus->only([
					"name",
					"color",
					"is_initial",
					"is_final",
				]),
				"statusable_type" => $updatedStatus->statusable_type->value,
			],
		);

		$response->assertNoContent();

		$this->assertDatabaseHas(Status::class, [
			...$updatedStatus->only([
				"name",
				"color",
				"is_initial",
				"is_final",
			]),
			"statusable_type" => $updatedStatus->statusable_type->value,
			"id" => $status->id,
		]);
	}

	/**
	 * destroy method exceptions test.
	 */
	public function test_destroy_endpoint_throws_no_exception(): void
	{
		$user = $this->createUserWithPermissions(["delete statuses"]);

		$status = Status::factory()->createOne();

		$response = $this->actingAs($user)->deleteJson(
			route("statuses.destroy"),
			[
				"statuses" => [$status->id],
			],
		);

		$response->assertNoContent();

		$this->assertModelMissing($status);
	}
}

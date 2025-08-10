<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create("statusables", function (Blueprint $table) {
			$table->morphs("statusable");

			$table
				->foreignId("status_id")
				->constrained()
				->cascadeOnDelete()
				->restrictOnUpdate();

			$table->primary(["statusable_type", "statusable_id", "status_id"]);

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists("statusables");
	}
};

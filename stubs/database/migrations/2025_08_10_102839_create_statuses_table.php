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
		Schema::create("statuses", function (Blueprint $table) {
			$table->id();

			$table->string("statusable_type");

			$table->string("name");

			$table->unique(["statusable_type", "name"]);

			$table->string("color");

			$table->boolean("is_initial")->default(false);

			$table->boolean("is_final")->default(false);

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists("statuses");
	}
};

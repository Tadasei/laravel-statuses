<?php

use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

Route::middleware(["auth:sanctum"])->group(function () {
	Route::delete("/statuses", [StatusController::class, "destroy"])->name(
		"statuses.destroy",
	);

	Route::apiResource("statuses", StatusController::class)->except([
		"destroy",
	]);

	Route::put("/lazy/statuses", [StatusController::class, "lazy"])->name(
		"statuses.lazy",
	);
});

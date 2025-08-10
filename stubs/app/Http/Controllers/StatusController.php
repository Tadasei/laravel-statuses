<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Traits\LazyLoad;

use App\Http\Requests\{
	Status\DeleteStatusRequest,
	Status\StoreStatusRequest,
	Status\UpdateStatusRequest,
	LazyLoadRequest
};
use Illuminate\Http\{JsonResponse, Response};
use Illuminate\Support\Facades\{DB, Gate};

class StatusController extends Controller
{
	use LazyLoad;

	public function lazy(LazyLoadRequest $request): JsonResponse
	{
		Gate::authorize("lazyViewAny", Status::class);

		return response()->json([
			"statuses" => $this->getLazyLoadedData($request, Status::query()),
		]);
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(): JsonResponse
	{
		Gate::authorize("viewAny", Status::class);

		return response()->json([
			"statuses" => Status::latest()->paginate(5),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreStatusRequest $request): JsonResponse
	{
		Gate::authorize("store", [Status::class, $request->validated()]);

		$status = DB::transaction(fn() => Status::create($request->validated()));

		return response()->json(["id" => $status->id], 201);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Status $status): JsonResponse
	{
		Gate::authorize("view", $status);

		return response()->json([
			"status" => $status,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateStatusRequest $request, Status $status): Response
	{
		Gate::authorize("update", [$status, $request->validated()]);

		DB::transaction(fn() => $status->update($request->validated()));

		return response()->noContent();
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(DeleteStatusRequest $request): Response
	{
		Status::whereIn("id", $request->statuses)
			->get()
			->each(fn(Status $status) => Gate::authorize("delete", $status));

		DB::transaction(fn() => Status::whereIn("id", $request->statuses)->delete());

		return response()->noContent();
	}
}

<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\{UsersController};

Route::middleware(['auth'])->prefix("admin")->group(function () {
    // Route::get("/users", [UsersController::class, "index"])->name("admin.users");
    // Route::get("/users/{user}", [UsersController::class, "show"])->name("admin.users.show");
    // Route::get("/users/{user}/edit", [UsersController::class, "edit"])->name("admin.users.edit");
    // Route::put("/users/{user}", [UsersController::class, "update"])->name("admin.users.update");
    // Route::delete("/users/{user}", [UsersController::class, "destroy"])->name("admin.users.destroy");
    // Route::get("/users/create", [UsersController::class, "create"])->name("admin.users.create");
    // Route::post("/users", [UsersController::class, "store"])->name("admin.users.store");
    Route::resource("users", UsersController::class);
});

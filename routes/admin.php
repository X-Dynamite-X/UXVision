<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\{UsersController};

Route::middleware(['auth'])->prefix("admin")->group(function () {
    Route::get("/users", [UsersController::class, "index"])->name("admin.users");
});

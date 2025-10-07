<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/',[HomeController::class,'index'])->name('home');

//One to one
//One To many
//Many-to-Many — Users ↔ Roles (with pivot data)
//Route::get('/many-to-many', function () {
//    [$admin, $editor] = [
//        Role::firstOrCreate(['name' => 'admin']),
//        Role::firstOrCreate(['name' => 'editor']),
//    ];
//    $u = User::firstOrFail();
//
//    // attach with pivot data
//    $u->roles()->syncWithoutDetaching([
//        $admin->id  => ['assigned_at' => now()],
//        $editor->id => ['assigned_at' => now()],
//    ]);
//
//    // read with pivot
//    return $u->roles()->get()->map(fn($r) => [
//        'role' => $r->name,
//        'assigned_at' => $r->pivot->assigned_at,
//    ]);
//});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

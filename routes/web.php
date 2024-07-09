<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


// MÈTODES GET DEL CONTROLADOR USUARI
Route::controller(UserController::class)->group(function () {
  Route::get('/', 'show_login')->name('login');
  Route::get('/login', 'show_login')->middleware('auth:sanctum');
  Route::get('/register', 'show_register');
  Route::get('/logout', 'show_login');
  Route::get('/recover', 'show_recover')->name('password.request');
  Route::get('/reset-password/{token}', 'show_reset_password')->middleware('guest')->name('password.reset');
  Route::get('/edit', 'show_edit');
});

// MÈTODES POST I PUT DEL CONTROLADOR USUARI
Route::controller(UserController::class)->group(function () {
  Route::post('/login', 'login')->middleware('web');
  Route::post('/register', 'register');
  Route::post('/recover', 'recover')->middleware('guest')->name('password.email');
  Route::post('/reset-password', 'reset_password')->middleware('guest')->name('password.update');
  Route::post('/logout', 'logout')->middleware('auth:sanctum');
  Route::put('/editUser/{id}', 'edit_user');
  Route::put('/editPassword/{id}', 'change_password');
});

// MÈTODES GET DEL CONTROLADOR NOTE
Route::controller(NoteController::class)->group(function () {
  Route::get('/home', 'show_home')->name('home');
  Route::get('/add_note', 'show_add_note');
  Route::get('/edit_note/{unique_id}', 'show_edit_note');
  Route::get('/get_notes', 'getNotes');
  Route::get('/get_filtered_notes/{query}', 'get_filtered_notes');
  Route::get('/get_images/{id}', 'get_images');
});

// MÈTODES POST, PUT I DELETE DEL CONTROLADOR NOTE
Route::controller(NoteController::class)->group(function () {
  Route::post('/upload_image/{id}', 'upload_image');
  Route::post('/pin_note/{id}', 'pin_note');
  Route::post('/search_note', 'search_note');
  Route::post('/add_note', 'add_note');
  Route::post('/reminder/{id}', 'reminder');
  Route::put('/edit_note/{id}', 'edit_note');
  Route::delete('/delete_note/{id}', 'delete_note')->name('note.delete');
  Route::delete('/delete_image/{id}', 'delete_image');
});


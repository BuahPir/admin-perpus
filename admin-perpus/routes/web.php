<?php

use Illuminate\Support\Facades\Route;

Route::get('/upload-book', function () {
    return view('upload-book');
});

Route::post('/upload-book', 'BookController@upload')->name('book.upload');
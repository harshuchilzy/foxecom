<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/single-product', function () {
    return view('singleproduct');
});

// Route::get('products/{id}', function ($id) {
//     // echo '<pre>';
//     // print_r($product);
//     // echo '</pre>';

//     echo $id;
// });


Route::get('products/{product}', function (\Lunar\Models\Contracts\Product $product) {
    echo '<pre>';
    $product = $product->load('variants.prices', 'media'); // App\Models\Product
    print_r($product->translateAttribute('name'));
    echo '</pre>';

});

Route::get('/offer', function () {
    return view('offerpage');
});

Route::get('/cart', function () {
    return view('cart');
});

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';



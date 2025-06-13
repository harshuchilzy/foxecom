<?php

use App\Livewire\Home;
use Livewire\Volt\Volt;
use Lunar\Models\Product;
use App\Livewire\SearchPage;
use App\Livewire\ProductPage;
use App\Livewire\CheckoutPage;
use App\Livewire\ProductsPage;
use App\Livewire\CollectionPage;
use App\Livewire\CheckoutSuccessPage;
use Illuminate\Support\Facades\Route;



Route::get('blog', function () {
    return view('pages.blog');
})->name('blog');

Route::get('contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('faq', function () {
    return view('pages.faq');
})->name('faq');

Route::get('partners', function () {
    return view('pages.partners');
})->name('partners');

Route::get('privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('shipping-and-payment', function () {
    return view('pages.shipping-and-payment');
})->name('shipping-and-payment');

Route::get('/offer', function () {
    return view('offerpage');
});

Route::get('/wholesale', function () {
    return view('wholesale');
})->name('wholesale');

// Route::get('/products', function () {
//     $products = Product::all();
//     $collections = \Lunar\Models\Collection::all();
//     return view('wholesale', [
//         'products' => $products,
//         'collections' => $collections,
//     ]);
// })->name('products.index');

// Route::get('/single-product', function () {
//     return view('single-product');
// });

// Route::get('/cart', function () {
//     return view('cart');
// });

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::get('/checkout', function () {
//     return view('checkout');
// });

// Route::get('/redemptions', function () {
//     return view('redemptions');
// });



// Route::get('/account', function () {
//     return view('account');
// });

// // Route::view('dashboard', 'dashboard')
// //     ->middleware(['auth', 'verified'])
// //     ->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
//     Volt::route('settings/password', 'settings.password')->name('settings.password');
//     Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
// });

// Route::get('/wholesale', function () {
//     return view('wholesale');
// })->name('wholesale');

// Lunar routes frontend - single product page
// Route::get('products/{product}', function (Product $product) {
//     //dd($product->load(['productType']));
// Route::get('products/{id}', function ($id) {
//     // echo '<pre>';
//     // print_r($product);
//     // echo '</pre>';

//     echo $id;
// });

//require __DIR__.'/auth.php';

// Route::get('products/{product}', function (\Lunar\Models\Contracts\Product $product) {
//     echo '<pre>';
//     $product = $product->load('variants.prices', 'media'); // App\Models\Product
//     print_r($product->translateAttribute('name'));
//     echo '</pre>';

// });



// Route::get('/cart', function () {
//     return view('cart');
// });

// Route::view('customer.dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('customer.dashboard');

// Route::get('/checkout', function () {
//     return view('checkout');
// });

// Route::get('/redemptions', function () {
//     return view('redemptions');
// });

// Route::get('/account', function () {
//     return view('account');
// });

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
//     Volt::route('settings/password', 'settings.password')->name('settings.password');
//     Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
// });



// Lunar routes frontend - single product page
// Route::get('products/{product}', function (Product $product) {
//     //dd($product->load(['productType']));
//     // echo '<pre>';
//     // $product = $product->load('variants.prices', 'media');
//     // print_r($product->translateAttribute('name'));
//     // echo '</pre>';
//     return view('single-product', [
//         'product' => $product,
//     ]);
// })->name('products.show');

Route::get('/', Home::class)->name('home');

Route::get('/collections/{slug}', CollectionPage::class)->name('collection.view');

Route::get('products', ProductsPage::class)->name('products.index');

Route::get('/products/{slug}', ProductPage::class)->name('product.view');

Route::get('search', SearchPage::class)->name('search.view');

Route::get('checkout', CheckoutPage::class)->name('checkout.view');

Route::get('checkout/success', CheckoutSuccessPage::class)->name('checkout-success.view');

<?php

use App\Models\User;
use App\Livewire\Home;
use Lunar\Models\Order;
use App\Livewire\CartPage;
use App\Livewire\BrandPage;
use App\Livewire\OfferPage;
use App\Livewire\OrdersPage;
use App\Livewire\SearchPage;
use Illuminate\Http\Request;
use App\Livewire\AccountPage;
use App\Livewire\AddressPage;
use App\Livewire\ProductPage;
use App\Livewire\CheckoutPage;
use App\Livewire\ProductsPage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Livewire\CollectionPage;
use App\Mail\CustomerWelcomeMail;
use App\Mail\CustomerNewOrderMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UpdatePrice;
use App\Livewire\CheckoutSuccessPage;
use Illuminate\Support\Facades\Route;
use Lunar\Models\Order as ModelsOrder;
use App\Http\Controllers\CheckoutController;

require __DIR__ . '/auth.php';

//Blog Page
Route::get('blog', function () {
    return view('pages.blog');
})->name('blog');

//About Page
Route::get('about', function () {
    return view('pages.about');
})->name('about');

//Terms and Conditions Page
Route::get('terms-and-conditions', function () {
    return view('pages.terms-and-conditions');
})->name('terms-conditions');

//Privacy Policy Page
Route::get('privacy-policy', function () {
    return view('pages.privacy-policy');
})->name('privacy-policy');

//Refund Policy Page
Route::get('refund-policy', function () {
    return view('pages.refund-policy');
})->name('refund-policy');

//Delivery Policy Page
Route::get('delivery-policy', function () {
    return view('pages.delivery-policy');
})->name('delivery-policy');

//Contact Page
Route::get('contact', function () {
    return view('pages.contact');
})->name('contact');

//FAQ Page
Route::get('faq', function () {
    return view('pages.faq');
})->name('faq');

//Partners Page
Route::get('partners', function () {
    return view('pages.partners');
})->name('partners');

//Privacy Page
Route::get('privacy', function () {
    return view('pages.privacy');
})->name('privacy');

//Shipping and Payment Page
Route::get('shipping-and-payment', function () {
    return view('pages.shipping-and-payment');
})->name('shipping-and-payment');

//Home Page - livewire
Route::get('/', Home::class)->name('home');

//Single Collections Page - livewire
Route::get('/collections/{slug}', CollectionPage::class)->middleware('auth')->name('collection.view');

//Single Brands Page - livewire
Route::get('/brands/{slug}', BrandPage::class)->middleware('auth')->name('brand.view');

//Products Page - livewire
Route::get('products', ProductsPage::class)->name('products.index');

//Single Product Page - livewire
Route::get('/products/{slug}', ProductPage::class)->name('product.view');

//Search Page - livewire
Route::get('search', SearchPage::class)->name('search.view');

//Checkout Page - livewire
Route::get('checkout', CheckoutPage::class)->middleware('auth')->name('checkout.view');

//Checkout Success Page - livewire
Route::get('checkout/success', CheckoutSuccessPage::class)->middleware('auth')->name('checkout-success.view');

//Orders Page - livewire
Route::get('/orders', OrdersPage::class)->middleware('auth')->name('redemptions');

//Cart Page - livewire
Route::get('/cart', CartPage::class)->middleware('auth')->name('cart');

//Address Page - livewire
Route::get('/addresses', AddressPage::class)->name('addresses')->middleware('auth');

//Account Page - livewire
Route::get('/account', AccountPage::class)->middleware('auth')->name('account');

// Move to API
Route::get('/address/search', function (Request $request) {
    $user = $request->user();
    $customer = $user->customers->first();
    $addresses = [];
    if ($customer) {
        $addresses = $customer->addresses->map(function ($address) {
            $shorten_address = array(
                $address->first_name,
                $address->last_name,
                $address->company_name,
                $address->line_one,
                $address->line_two,
                $address->line_three,
                $address->city,
                $address->state,
                $address->postcode,
                $address->contact_email
            );
            $address['address'] = implode(', ', array_filter($shorten_address));
            return $address;
        });
    }
    return response()->json($addresses);
})->middleware('auth')->name('api.address.search');

//Single Offer Page - livewire
Route::get('/offers/{id}', OfferPage::class)->middleware('auth')->name('discount.show');

Route::redirect('admin', '/dashboard');

Route::get('/api/cities/search', function () {
    $country = request('country');
    $search = strtolower(request('search', ''));

    $cities = match ($country) {
        'uk' => [
            ['value' => 'london', 'label' => 'London'],
            ['value' => 'manchester', 'label' => 'Manchester'],
            ['value' => 'birmingham', 'label' => 'Birmingham'],
            ['value' => 'liverpool', 'label' => 'Liverpool'],
            ['value' => 'leeds', 'label' => 'Leeds'],
            ['value' => 'glasgow', 'label' => 'Glasgow'],
            ['value' => 'edinburgh', 'label' => 'Edinburgh'],
            ['value' => 'bristol', 'label' => 'Bristol'],
            ['value' => 'sheffield', 'label' => 'Sheffield'],
            ['value' => 'nottingham', 'label' => 'Nottingham'],
        ],
        'uae' => [
            ['value' => 'dubai', 'label' => 'Dubai'],
            ['value' => 'abu_dhabi', 'label' => 'Abu Dhabi'],
            ['value' => 'sharjah', 'label' => 'Sharjah'],
            ['value' => 'ajman', 'label' => 'Ajman'],
            ['value' => 'fujairah', 'label' => 'Fujairah'],
            ['value' => 'ras_al_khaimah', 'label' => 'Ras Al Khaimah'],
            ['value' => 'umm_al_quwain', 'label' => 'Umm Al Quwain'],
        ],
        default => [],
    };
    return collect($cities)
        ->filter(fn ($city) => str_contains(strtolower($city['label']), $search))
        ->values()
        ->toArray();
})->name('api.cities.search');

Route::get('unsubscribe', function(){
    return redirect()->route('home');
})->name('unsubscribe');

Route::middleware('auth')
    ->prefix('checkout')
    ->as('checkout.')
    ->controller(CheckoutController::class)
    ->group(function () {
        Route::post('initiate', 'initiate')->name('initiate');
        Route::post('complete', 'complete')->name('complete');
    });



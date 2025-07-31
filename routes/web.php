<?php

use App\Models\User;
use App\Livewire\Home;
use Lunar\Models\Order;
use App\Livewire\CartPage;
use App\Livewire\OfferPage;
use App\Livewire\OrdersPage;
use App\Livewire\SearchPage;
use Illuminate\Http\Request;
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

Route::get('blog', function () {
    return view('pages.blog');
})->name('blog');

Route::get('about', function () {
    return view('pages.about');
})->name('about');

Route::get('terms-and-conditions', function () {
    return view('pages.terms-and-conditions');
})->name('terms-conditions');

Route::get('privacy-policy', function () {
    return view('pages.privacy-policy');
})->name('privacy-policy');

Route::get('refund-policy', function () {
    return view('pages.refund-policy');
})->name('refund-policy');

Route::get('delivery-policy', function () {
    return view('pages.delivery-policy');
})->name('delivery-policy');

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
})->name('offers');

Route::get('/wholesale', function () {
    return view('wholesale');
})->name('wholesale');

Route::get('/account', function () {
    return view('account');
})->name('account')->middleware('auth');

Route::get('/new-checkout', function () {
    return view('checkout');
});

Route::get('/', Home::class)->name('home');

Route::get('/collections/{slug}', CollectionPage::class)->middleware('auth')->name('collection.view');

Route::get('products', ProductsPage::class)->name('products.index');

Route::get('/products/{slug}', ProductPage::class)->name('product.view');

Route::get('search', SearchPage::class)->name('search.view');

Route::get('checkout', CheckoutPage::class)->middleware('auth')->name('checkout.view');

Route::get('checkout/success', CheckoutSuccessPage::class)->middleware('auth')->name('checkout-success.view');

Route::get('/orders', OrdersPage::class)->middleware('auth')->name('redemptions');

Route::get('/cart', CartPage::class)->middleware('auth')->name('cart');

Route::get('/addresses', AddressPage::class)->name('addresses')->middleware('auth');

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

// Route::get('test', function () {

//     $user = auth()->user();
//     $customer = $user->customers->first();
//     $billing_address = $customer->addresses->where('billing_default', 1)->first();
//     echo $billing_address->country;
//     echo '<pre>';
//     print_r($customer->addresses->where('billing_default', 1)->first()->toArray());
//     echo '</pre>';
// });


// Route::get('/offers/{id}', OfferPage::class)->name('redemption.show');
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

Route::get('temp', function(){
        // $user = User::find();
        // phpinfo();
        echo 'OK';
        $order = Lunar\Models\Order::find(3);
;
            Mail::to('testreceiver@gmail.com')->send(new CustomerNewOrderMail($order));

        // $record = ModelsOrder::find(3);
        // return response()->streamDownload(function () use ($record) {
        //     echo Pdf::loadView('lunarpanel::pdf.order', [
        //         'record' => $record,
        //     ])->stream();
        // }, name: "Order-{$record->reference}.pdf");
    });

Route::get('update-prices', [UpdatePrice::class, 'update']);

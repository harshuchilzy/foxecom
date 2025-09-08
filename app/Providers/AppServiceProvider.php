<?php

namespace App\Providers;

use App\Models\MyStaff;

//use App\Filament\Resources\RedemptionResource;
use Lunar\Models\CartLine;
use Lunar\Facades\Payments;
use Lunar\Admin\Models\Staff;
use App\Payments\NgeniusPayment;
use Lunar\Base\ShippingModifiers;
use Lunar\Shipping\ShippingPlugin;
use App\Modifiers\ShippingModifier;
use Illuminate\Foundation\AliasLoader;
use Lunar\Actions\Carts\CalculateLine;
use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\PageResource;
use App\Actions\Carts\CustomCalculateLine;
use App\Filament\Extensions\MyCustomerExtensions\MyCustomerResourceExtension;
use Lunar\Admin\Support\Facades\LunarPanel;
use App\Filament\Resources\RedemptionResource;
use Lunar\Validation\CartLine\CartLineQuantity;
use App\Filament\Resources\ProductReviewResource;
use Lunar\Admin\Filament\Resources\StaffResource;
use App\Validation\CartLine\CustomCartLineQuantity;
use Lunar\Admin\Filament\Resources\DiscountResource;
use App\Filament\Extensions\MyStaffExtensions\MyStaffResourceExtension;
use Lunar\Admin\Filament\Resources\DiscountResource\Pages\ListDiscounts;
use App\Filament\Extensions\MyDiscountExtensions\MyDiscountResourceExtension;
use App\Filament\Extensions\MyDiscountExtensions\MyListDiscountPageExtension;
use App\Filament\Extensions\MyOrderExtensions\MyOrderResourceExtension;
use App\Filament\Resources\ConfigurationResource;
use Lunar\Admin\Filament\Resources\CustomerResource;
use Lunar\Admin\Filament\Resources\OrderResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $loader = AliasLoader::getInstance();
        // $loader->alias(Staff::class, MyStaff::class);

        LunarPanel::panel(function ($panel) {
            return $panel
                ->brandName('Foxergo')
                ->brandLogo(asset('images/dayzSolution_logo.png'))
                ->darkModeBrandLogo(asset('images/dayzSolution_logo_dark.png'))
                ->favicon(asset('images/blacklogo.png'))
                ->path('dashboard')
                ->plugins([
                    new ShippingPlugin,
                ])
                ->resources([
                    ProductReviewResource::class,
                    PageResource::class,
                    ConfigurationResource::class,
                    //RedemptionResource::class,
                ]);
        })->register();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(ShippingModifiers $shippingModifiers): void
    {
        LunarPanel::extensions([
            ListDiscounts::class => MyListDiscountPageExtension::class,
            DiscountResource::class => MyDiscountResourceExtension::class,
            StaffResource::class => MyStaffResourceExtension::class,
            CustomerResource::class => MyCustomerResourceExtension::class,
            OrderResource::class => MyOrderResourceExtension::class,
        ]);

        Payments::extend('ngenius', function ($app) {
            return $app->make(NgeniusPayment::class);
        });

        $shippingModifiers->add(
            ShippingModifier::class
        );

        \Lunar\Facades\ModelManifest::replace(
            \Lunar\Models\Contracts\Product::class,
            \App\Models\Product::class,
        // \App\Models\CustomProduct::class,
        );


        CartLine::deleting(function (CartLine $line) {
            if (empty(data_get($line->meta, 'free'))) {
                CartLine::where('cart_id', $line->cart_id)
                    ->where('meta->parent_line_id', $line->id)
                    ->delete();
            }
        });

        //replace CartLineQuantity with CustomCartLineQuantity
        $this->app->bind(CartLineQuantity::class, CustomCartLineQuantity::class);
    
    }
}

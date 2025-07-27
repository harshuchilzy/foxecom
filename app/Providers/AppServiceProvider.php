<?php

namespace App\Providers;

use Lunar\Models\CartLine;

//use App\Filament\Resources\RedemptionResource;
use Lunar\Facades\Payments;
use App\Payments\NgeniusPayment;
use Lunar\Base\ShippingModifiers;
use Lunar\Shipping\ShippingPlugin;
use App\Modifiers\ShippingModifier;
use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\PageResource;
use Lunar\Admin\Support\Facades\LunarPanel;
use App\Filament\Resources\RedemptionResource;
use Lunar\Validation\CartLine\CartLineQuantity;
use App\Filament\Resources\ProductReviewResource;
use App\Validation\CartLine\CustomCartLineQuantity;
use Lunar\Admin\Filament\Resources\DiscountResource;
use Lunar\Admin\Filament\Resources\DiscountResource\Pages\ListDiscounts;
use App\Filament\Extensions\MyDiscountExtensions\MyDiscountResourceExtension;
use App\Filament\Extensions\MyDiscountExtensions\MyListDiscountPageExtension;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        LunarPanel::panel(function ($panel) {
            return $panel
                ->path('dashboard')
                ->plugins([
                    new ShippingPlugin,
                ])
                ->resources([
                    ProductReviewResource::class,
                    PageResource::class,
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

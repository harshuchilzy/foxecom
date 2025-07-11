<?php

namespace App\Providers;

use App\Filament\Resources\PageResource;

//use App\Filament\Resources\RedemptionResource;
use Lunar\Admin\Support\Facades\LunarPanel;
use App\Filament\Resources\ProductReviewResource;
use App\Filament\Extensions\MyDiscountExtensions\MyDiscountResourceExtension;
use App\Filament\Extensions\MyDiscountExtensions\MyListDiscountPageExtension;
use App\Filament\Resources\RedemptionResource;
use App\Modifiers\ShippingModifier;
use Illuminate\Support\ServiceProvider;
use Lunar\Admin\Filament\Resources\DiscountResource;
use Lunar\Admin\Filament\Resources\DiscountResource\Pages\ListDiscounts;
use Lunar\Base\ShippingModifiers;
use Lunar\Shipping\ShippingPlugin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // LunarPanel::panel(fn($panel) => $panel->path('dashboard')->plugins([
        //     new ShippingPlugin,
        // ]))->register();

        LunarPanel::panel(function ($panel) {
            return $panel
                ->path('dashboard')
                ->plugins([
                    new ShippingPlugin,
                ])
                ->resources([
                    ProductReviewResource::class,
                    //RedemptionResource::class,
                ]);
        })->register();

        LunarPanel::panel(function ($panel) {
            return $panel
                ->path('dashboard')
                ->resources([
                    PageResource::class,
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
            DiscountResource::class => MyDiscountResourceExtension::class
        ]);

        $shippingModifiers->add(
            ShippingModifier::class
        );

        \Lunar\Facades\ModelManifest::replace(
            \Lunar\Models\Contracts\Product::class,
            \App\Models\Product::class,
        // \App\Models\CustomProduct::class,
        );
    }
}

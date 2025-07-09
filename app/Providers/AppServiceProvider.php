<?php

namespace App\Providers;

use Lunar\Base\ShippingModifiers;
use Lunar\Shipping\ShippingPlugin;
use App\Modifiers\ShippingModifier;
use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\PageResource;

//use App\Filament\Resources\RedemptionResource;
use Lunar\Admin\Support\Facades\LunarPanel;
use App\Filament\Resources\ProductReviewResource;

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

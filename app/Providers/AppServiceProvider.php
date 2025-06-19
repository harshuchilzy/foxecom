<?php

namespace App\Providers;

use App\Modifiers\ShippingModifier;
use Illuminate\Support\ServiceProvider;
use Lunar\Admin\Support\Facades\LunarPanel;
use Lunar\Shipping\ShippingPlugin;
use Lunar\Base\ShippingModifiers;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        LunarPanel::panel(fn($panel) => $panel->path('dashboard')->plugins([
            new ShippingPlugin,
        ]))->register();
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

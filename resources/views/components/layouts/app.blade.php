<x-layouts.app.slidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.slidebar>

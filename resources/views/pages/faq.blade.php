<x-layouts.app.layout>
    <div class="max-w-[1440px] mx-auto px-4 py-12" x-data="{ query: '', filter(el) { return !this.query || el.toLowerCase().includes(this.query.toLowerCase()) } }" x-init="$watch('query', value => { document.querySelectorAll('[data-faq]').forEach(el => { el.closest('details').style.display = filter(el.textContent) ? '' : 'none' }) })">
        <!-- Category: Orders & Shipping -->
        <section aria-labelledby="orders" class="mt-4">
            <div class="max-w-3xl mb-10">
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight">FAQs</h1>
                <p class="mt-3 text-gray-600">We’ve collected the most common questions from our customers about vapor products, shipping, and safety. Dummy answers are shown below — replace with your own store information.</p>
            </div>
            <div class="divide-y divide-gray-200 rounded-2xl border border-gray-200 bg-white shadow-sm">
                <!-- Q1 -->
                <details class="group p-5" open>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Where do you ship, and what are the delivery times?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        We currently offer domestic and international shipping via standard and express services.
                        Typical delivery windows are 2–5 business days (domestic) and 5–12 business days
                        (international). Exact estimates appear at checkout based on your address.
                    </div>
                </details>
                <!-- Q2 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Do you require age verification on delivery?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        Yes. Orders may be subject to age verification at checkout and/or upon delivery. A valid
                        government‑issued ID confirming legal smoking age in your region is required.
                    </div>
                </details>
                <!-- Q3 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">What are your shipping fees?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        Rates are calculated at checkout based on weight, destination, and service speed. You can
                        configure free‑shipping thresholds here (e.g., “Free over €50”).
                    </div>
                </details>
            </div>
        </section>


        <!-- Add more categories here as in previous version -->


        <!-- Contact -->
        <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold">Need more help?</h3>
            <p class="mt-2 text-gray-600">Can’t find your answer here? <a href="{{ route('contact') }}"
                    class="underline decoration-2 underline-offset-2 hover:no-underline">Contact support</a> or email <a
                    href="mailto:accounts@foxergo.com"
                    class="underline decoration-2 underline-offset-2 hover:no-underline">accounts@foxergo.com</a>.</p>
        </div>


        <!-- Disclaimer -->
        <p class="mt-6 text-sm text-gray-500">This page contains general information and placeholder policies. Replace
            with your store’s actual terms. Vapor products are not suitable for non‑smokers. Keep out of reach of
            children and pets.</p>
    </div>

</x-layouts.app.layout>

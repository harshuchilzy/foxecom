<x-layouts.app.layout>
    <div class="max-w-[1440px] mx-auto px-4 py-12" x-data="{ query: '', filter(el) { return !this.query || el.toLowerCase().includes(this.query.toLowerCase()) } }" x-init="$watch('query', value => { document.querySelectorAll('[data-faq]').forEach(el => { el.closest('details').style.display = filter(el.textContent) ? '' : 'none' }) })">
        <!-- Category: Orders & Shipping -->
        <section aria-labelledby="orders" class="mt-4">
            <div class="mb-10">
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight">FOXERGO – Frequently Asked Questions</h1>
                <p class="mt-3 text-gray-600 mb-4">We’ve collected the most common questions from our customers about Foxergo products, shipping, and safety.</p>
                <hr>
            </div>
            <div class="divide-y divide-gray-200 rounded-2xl border border-gray-200 bg-white shadow-sm">
                <!-- Q1 -->
                <details class="group p-5" open>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Who can buy from FOXERGO?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        FOXERGO supplies <strong class="text-black">trade customers only</strong> (retailers, wholesalers, hospitality). You must be <strong class="text-black">18+</strong> and accept our age-restricted goods policy. We may request proof of business and photo ID.
                    </div>
                </details>
                <!-- Q2 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Are your products genuine?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <strong class="text-black">Yes.</strong> We source directly from brands or authorised distributors. Each shipment is batch-tracked; we operate a zero-tolerance policy on counterfeits.
                    </div>
                </details>
                <!-- Q3 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Are your products compliant?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        We only supply products <strong class="text-black">for sale in markets where the buyer is legally permitted to retail them.</strong> As the buyer, you are responsible for ensuring products you purchase comply with local laws/regulations in your area.
                    </div>
                </details>
                <!-- Q4 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">What nicotine strengths do you stock?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        Availability varies by brand and market. Product pages list strengths and ingredients.
                    </div>
                </details>
                <!-- Q5 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">How should vapes be stored?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        Keep sealed, upright, away from heat/sunlight (ideally 5–25°C). Do not refrigerate or freeze. Keep away from children and pets.
                    </div>
                </details>
            </div>

            <div class="mt-12 mb-6">
                <h2 class="text-xl md:text-2xl font-bold tracking-tight mb-4 ml-4">Orders, Payments & VAT</h2>
            </div>

            <div class="divide-y divide-gray-200 rounded-2xl border border-gray-200 bg-white shadow-sm">
                <!-- Q6 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">What payment methods do you accept?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        We accept card, cash, and bank transfer (pro-forma). Orders paid by bank transfer ship once cleared.
                    </div>
                </details>

                <!-- Q7 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Are prices shown with or without VAT?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        Prices on our website are <strong class="text-black">shown ex-VAT</strong> unless stated otherwise. UK VAT (20%) is added at checkout and itemised on your invoice.
                    </div>
                </details>

                <!-- Q8 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Do you provide VAT invoices?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <strong class="text-black">Yes.</strong> A full VAT invoice is emailed when your order is confirmed and is available in <strong class="text-black">Redemptions and Orders → Download Invoice</strong>
                    </div>
                </details>

                <!-- Q9 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Can I change or cancel an order?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        If your order hasn’t shipped, contact <strong class="text-black"><a href="mailto:support@foxergo.com">support@foxergo.com</a></strong> and we’ll try to amend/cancel it. If already dispatched, please follow the Returns section below.
                    </div>
                </details>
            </div>

            <div class="mt-12 mb-6">
                <h2 class="text-xl md:text-2xl font-bold tracking-tight mb-4 ml-4">Delivery & Click & Collect</h2>
            </div>

            <div class="divide-y divide-gray-200 rounded-2xl border border-gray-200 bg-white shadow-sm">
                <!-- Q10 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Where do you deliver?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        UK Mainland, Highlands & Islands, and Northern Ireland.
                    </div>
                </details>

                <!-- Q11 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">How long does delivery take?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <ul class="list-inside list-disc">
                            <li><strong class="text-black">UK Mainland (Courier – Tracked):</strong> Typically <strong class="text-black">Next Business Day</strong> for orders placed before <strong class="text-black">2:00 pm (Mon–Fri).</strong></li>
                            <li><strong class="text-black">Highlands/Islands/NI:</strong> 2–3 business days.</li>
                        </ul>
                    </div>
                </details>

                <!-- Q12 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">How much is delivery?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <ul class="list-inside list-disc mb-4">
                            <li><strong class="text-black">Orders £100+ (ex-VAT): Free Next-Business-Day</strong> UK Mainland.</li>
                            <li><strong class="text-black">Orders under £100:</strong> £10 shipping charge</li>
                        </ul>
                        <p>Pallet rates quoted by our team for larger consignments.</p>
                    </div>
                </details>
            </div>

            <div class="mt-12 mb-6">
                <h2 class="text-xl md:text-2xl font-bold tracking-tight mb-4 ml-4">Returns, Refunds & Warranty</h2>
            </div>

            <div class="divide-y divide-gray-200 rounded-2xl border border-gray-200 bg-white shadow-sm">
                <!-- Q13 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Can I return items if I change my mind?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        For purchases made in-store, we are not legally required to offer a refund or exchange if you simply change your mind. However, as part of our customer service promise, we are happy to accept returns for unused and unopened goods within 14 days of purchase, provided you have proof of purchase (such as a receipt).
                    </div>
                </details>

                <!-- Q14 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">What if my order arrives damaged or incorrect?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <ul class="list-inside list-disc">
                            <li>Notify us within <strong class="text-black">48 hours</strong> with photos and your order number. We’ll arrange a replacement or refund once verified.</li>
                        </ul>
                    </div>
                </details>
            </div>

            <div class="mt-12 mb-6">
                <h2 class="text-xl md:text-2xl font-bold tracking-tight mb-4 ml-4">Safety, Disposal & Environment</h2>
            </div>

            <div class="divide-y divide-gray-200 rounded-2xl border border-gray-200 bg-white shadow-sm">
                <!-- Q15 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Battery and device disposal</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <strong class="text-black">Do not</strong> dispose of devices in household waste. Follow local <strong class="text-black">WEEE</strong> and battery recycling guidance. We can assist business customers with compliant disposal options.
                    </div>
                </details>

                <!-- Q16 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Allergens & ingredients</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <ul class="list-inside list-disc">
                            <li>Ingredients and allergen info are shown on product packaging. If you need an <strong class="text-black">SDS</strong> or specific composition data for a brand, contact us.</li>
                        </ul>
                    </div>
                </details>
            </div>

            <div class="mt-12 mb-6">
                <h2 class="text-xl md:text-2xl font-bold tracking-tight mb-4 ml-4">Account & Support</h2>
            </div>

            <div class="divide-y divide-gray-200 rounded-2xl border border-gray-200 bg-white shadow-sm">
                <!-- Q17 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">How do I open a trade account?</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        Press <strong class="text-black">Login / Register</strong> and provide your business details. Once the sign up form is complete, your account will be active.
                    </div>
                </details>

                <!-- Q18 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">I can’t log in / need help with an order.</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <ul class="list-inside list-disc">
                            <li>Email <strong class="text-black"><a href="mailto:accounts@foxergo.com" class="underline decoration-2 underline-offset-2 hover:no-underline">accounts@foxergo.com</a></strong> with your business name, order number, and details. We aim to respond within <strong class="text-black">one business day.</strong></li>
                        </ul>
                    </div>
                </details>
            </div>

            <div class="mt-12 mb-6">
                <h2 class="text-xl md:text-2xl font-bold tracking-tight mb-4 ml-4">Policy Summaries</h2>
            </div>

            {{-- <div class="divide-y divide-gray-200 rounded-2xl border border-gray-200 bg-white shadow-sm">
                <!-- Q17 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Delivery Policy</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <p class="mb-4">Orders placed before 5PM GMT are processed the same working day. Orders after 5PM or on weekends/public holidays are processed the next business day.</p>
                        <p>Delivery windows are estimated; carriers may experience delays. Risk passes to you on delivery. See full policy on our Delivery page.</p>
                    </div>
                </details>

                <!-- Q18 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Returns & Cancellations Policy</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <p class="mb-4">If any product you purchase from us is faulty, damaged, or not as described, you are legally entitled to a repair, replacement, or full refund.</p>
                        <ul class="list-inside list-disc mb-4">
                            <li>You have 30 days from the date of purchase (or receipt, for online orders) to reject the goods and request a full refund.</li>
                            <li>After 30 days, and within 6 months, we will offer a repair or replacement in the first instance. If repair or replacement is not possible, you may then be entitled to a refund.</li>
                        </ul>
                        <p>We will cover any reasonable postage costs for returning faulty, damaged, or incorrect items.</p>
                    </div>
                </details>

                <!-- Q18 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Refunds</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <p class="mb-4">Refunds will be issued to your original payment method only.  We may reduce your refund if the goods have been handled more than necessary to establish their nature, characteristics, and functioning.  Refunds are processed within 14 days of receiving the returned goods or evidence of dispatch.</p>
                    </div>
                </details>

                <!-- Q19 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Age-Restricted Goods Policy</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <p class="mb-4">Trade customers must be <strong class="text-black">18+.</strong> We verify age and may require ID on delivery/collection. You must operate a compliant age-verification policy at point of sale.</p>
                    </div>
                </details>

                <!-- Q20 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Privacy</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <p class="mb-4">We process your data to fulfil orders, prevent fraud, and meet legal obligations. Payment data is handled securely by <strong class="text-black">Worldpay.</strong> See our Privacy Policy for full details.</p>
                    </div>
                </details>

                <!-- Q21 -->
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                        <span class="text-base font-medium">Terms of Sale</span>
                        <span class="shrink-0">
                            <svg class="h-5 w-5 transition-transform group-open:rotate-45" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-gray-600" data-faq>
                        <p class="mb-4">All orders are subject to availability and our Terms & Conditions. Title passes on receipt of cleared funds; risk passes on delivery. Prices are ex-VAT; VAT added at checkout where applicable.</p>
                    </div>
                </details>
            </div> --}}
        </section>

        <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="mb-6">
                <h3 class="text-lg font-semibold">Delivery Policy</h3>
                <p class="mt-2 text-gray-600">Orders placed before 5PM GMT are processed the same working day. Orders after 5PM or on weekends/public holidays are processed the next business day.</p>
                <p class="mt-2 text-gray-600">Delivery windows are estimated; carriers may experience delays. Risk passes to you on delivery. See full policy on our Delivery page.</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold">Returns & Cancellations Policy</h3>
                <p class="mt-2 text-gray-600">If any product you purchase from us is faulty, damaged, or not as described, you are legally entitled to a repair, replacement, or full refund.</p>
                <ul class="list-inside list-disc mt-2 text-gray-600">
                    <li>You have 30 days from the date of purchase (or receipt, for online orders) to reject the goods and request a full refund.</li>
                    <li>After 30 days, and within 6 months, we will offer a repair or replacement in the first instance. If repair or replacement is not possible, you may then be entitled to a refund.</li>
                </ul>
                <p class="mt-2 text-gray-600">We will cover any reasonable postage costs for returning faulty, damaged, or incorrect items.</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold">Refunds</h3>
                <p class="mt-2 text-gray-600">Refunds will be issued to your original payment method only.  We may reduce your refund if the goods have been handled more than necessary to establish their nature, characteristics, and functioning.  Refunds are processed within 14 days of receiving the returned goods or evidence of dispatch.</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold">Age-Restricted Goods Policy</h3>
                <p class="mt-2 text-gray-600">Trade customers must be <strong class="text-black">18+</strong>. We verify age and may require ID on delivery/collection. You must operate a compliant age-verification policy at point of sale.</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold">Privacy</h3>
                <p class="mt-2 text-gray-600">We process your data to fulfil orders, prevent fraud, and meet legal obligations. Payment data is handled securely by <strong class="text-black">Worldpay.</strong> See our Privacy Policy for full details.</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold">Terms of Sale</h3>
                <p class="mt-2 text-gray-600">All orders are subject to availability and our Terms & Conditions. Title passes on receipt of cleared funds; risk passes on delivery. Prices are ex-VAT; VAT added at checkout where applicable.</p>
            </div>
        </div>


        <!-- Add more categories here as in previous version -->


        <!-- Contact -->
        <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold">Need more help?</h3>
            <p class="mt-2 text-gray-600">Can’t find your answer here? <a href="{{ route('contact') }}"
                    class="underline decoration-2 underline-offset-2 hover:no-underline">Contact support</a> or email <a
                    href="mailto:accounts@foxergo.com"
                    class="underline decoration-2 underline-offset-2 hover:no-underline">accounts@foxergo.com</a>.</p>
        </div>


    </div>

</x-layouts.app.layout>

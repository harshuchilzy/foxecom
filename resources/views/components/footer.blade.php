<footer class="w-full bg-white">
    <div class="flex justify-between items-start px-5 max-w-[1280px] mx-auto py-10 w-full flex-col md:flex-row gap-[30px] md:gap-0">
        <!-- Footer Logo -->
        <div>
            <a href="{{route('home')}}"><img class="w-[100px]" src="{{ asset('images/blacklogo.png') }}" alt="Footer Logo"></a>
        </div>

        <!-- Footer Information Menu -->
        <div class="flex items-start gap-12">
            <div>
                <p class="text-[#1B1819] uppercase font-normal text-[12px] mb-4">Information</p>
                <ul class="text-[#1B1819] font-normal font-inter text-[16px] flex flex-col gap-1">
                    <li><a href="{{route('privacy-policy')}}">Privacy</a></li>
                    <li><a href="{{route('faq')}}">FAQ</a></li>
                    <li><a href="{{route('delivery-policy')}}">Shipping and Payment</a></li>
                    <li><a href="{{ route('partners') }}">Partners</a></li>
                    <li><a href="{{ route('blogs') }}">Blog</a></li>
                    <li><a href="{{route('contact')}}">Contacts</a></li>
                </ul>
            </div>

            <div></div>
        </div>

        <!-- Contact Details -->
        <div class="flex flex-col items-start lg:items-start">
            <a href="tel:+447925606692" class="bg-[#1B1819] text-white py-[8px] px-[16px] rounded-lg cursor-pointer">Call Now</a>
            <div class="mt-4">
                <a href="tel:+447925606692"><p class="font-semibold text-[14px] text-[#1B1819]">+44 7925 606692</p></a>
                <a href="mailto:accounts@foxergo.com"><p class="font-semibold text-[14px] text-[#1B1819]">accounts@foxergo.com</p></a>
            </div>
        </div>
    </div>

    <!-- Footer Bottum -->
    <div class="py-8 px-4 flex justify-between items-center max-w-[1280px] mx-auto">
        <div class="flex items-center gap-2 md:gap-4 flex-col md:flex-row">
            <a href="https://www.instagram.com/fox_ergo/" target="_blank" class="bg-black rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="25" height="25" fill="#FFFFFF">
                    <path
                        d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                </svg>
            </a>
            <a href="https://www.linkedin.com/company/foxergo/" target="_blank" class="bg-black rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="25" height="25" fill="#FFFFFF">
                    <path
                        d="M100.3 448H7.4V148.9h92.9zM53.8 108.1C24.1 108.1 0 83.5 0 53.8a53.8 53.8 0 0 1 107.6 0c0 29.7-24.1 54.3-53.8 54.3zM447.9 448h-92.7V302.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V448h-92.8V148.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V448z"/>
                </svg>
            </a>
        </div>
        <div class="flex flex-col items-start">
            <p class="font-semibold text-[14px] text-[#1B1819]">24 Sanderling Way, Porthcawl,</p>
            <p class="font-semibold text-[14px] text-[#1B1819]">Wales, CF36 3TD</p>
        </div>
        <div class="flex items-center gap-3 md:gap-6 flex-col md:flex-row">
            <div>
                <p class="text-[#1B1819] font-bold text-[28px]">18+</p>
            </div>
            <div class="flex flex-col items-center">
                <p class="font-semibold text-[14px] text-[#1B1819]">Score</p>
                <p class="font-semibold text-[14px] text-[#1B1819]">For adults</p>
            </div>
        </div>
    </div>

    {{-- <script src="{{ asset('js/age-verification.js') }}"></script> --}}

    <!-- Age Verification Popup -->
    <x-notifications.age-verification/>
</footer>

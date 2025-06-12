<footer class="w-full bg-white">
    <div class="flex justify-between items-start px-5 max-w-[1440px] mx-auto py-10 w-full flex-col md:flex-row gap-[30px] md:gap-0">
        <div>
            <a href="{{route('home')}}"><img class="w-[100px]" src="{{ asset('images/blacklogo.png') }}" alt="Footer Logo"></a>
        </div>
        <div class="flex items-start gap-12">
            <div>
                <p class="text-[#1B1819] uppercase font-normal text-[12px] mb-4">Information</p>
                <ul class="text-[#1B1819] font-normal text-[14px] flex flex-col gap-2">
                    <li><a href="{{route('privacy')}}">Privacy</a></li>
                    <li><a href="{{route('faq')}}">FAQ</a></li>
                    <li><a href="{{route('shipping-and-payment')}}">Shipping and Payment</a></li>
                    <li><a href="{{route('partners')}}">Partners</a></li>
                    <li><a href="{{route('blog')}}">Blog</a></li>
                    <li><a href="{{route('contact')}}">Contacts</a></li>
                </ul>
            </div>
            <div>
                <p class="text-[#1B1819] uppercase font-normal text-[12px] mb-4">Menu</p>
                <ul class="text-[#1B1819] font-normal text-[14px] flex flex-col gap-2">
                    <li><a href="#">Example</a></li>
                    <li><a href="#">Example</a></li>
                    <li><a href="#">Example</a></li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col items-center lg:items-start">
            <a class="bg-[#1B1819] text-white py-[8px] px-[16px] rounded-lg cursor-pointer">Request a call</a>
            <div class="mt-4">
                <a href="tel:+1(999)999-99-99"><p class="font-semibold text-[14px] text-[#1B1819]">+1 (999) 999-99-99</p></a>
                <a href="mailto:info@logoipsum.com"><p class="font-semibold text-[14px] text-[#1B1819]">info@logoipsum.com</p></a>
            </div>
        </div>
    </div>

    <div class="py-8 px-4 flex justify-between items-center max-w-[1440px] mx-auto">
        <div class="flex items-center gap-2 md:gap-4 flex-col md:flex-row">
            <a href="https://telegram.org/" target="_blank">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" rx="20" fill="#1B1819"/><path d="M12.2374 19.027C17.0692 17.0513 20.2912 15.7487 21.9033 15.1194C26.5063 13.3226 27.4627 13.0105 28.0861 13.0001C28.2232 12.9979 28.5298 13.0298 28.7284 13.1811C28.8961 13.3088 28.9422 13.4813 28.9643 13.6023C28.9864 13.7234 29.0139 13.9992 28.992 14.2147C28.7426 16.6744 27.6633 22.6434 27.1142 25.3983C26.8818 26.564 26.4244 26.9548 25.9815 26.9931C25.0189 27.0762 24.288 26.3961 23.3558 25.8226C21.897 24.9251 21.0729 24.3664 19.6569 23.4907C18.0205 22.4786 19.0813 21.9224 20.0139 21.0133C20.258 20.7754 24.4988 17.1552 24.5809 16.8268C24.5912 16.7857 24.6007 16.6326 24.5038 16.5517C24.4069 16.4709 24.2639 16.4985 24.1606 16.5205C24.0143 16.5517 21.6839 17.9973 17.1694 20.8573C16.5079 21.2836 15.9087 21.4913 15.3719 21.4805C14.7801 21.4685 13.6417 21.1664 12.7955 20.9083C11.7575 20.5916 10.9325 20.4242 11.0044 19.8864C11.0418 19.6063 11.4528 19.3198 12.2374 19.027Z" fill="white"/></svg>
            </a>
            <a href="https://www.whatsapp.com/" target="_blank">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" rx="20" fill="#1B1819"/><path fill-rule="evenodd" clip-rule="evenodd" d="M25.6 14.3C24.1 12.8 22.1 12 20 12C15.6 12 12 15.6 12 20C12 21.4 12.4 22.8 13.1 24L12 28L16.2 26.9C17.4 27.5 18.7 27.9 20 27.9C24.4 27.9 28 24.3 28 19.9C28 17.8 27.1 15.8 25.6 14.3ZM20 26.6C18.8 26.6 17.6 26.3 16.6 25.7L16.4 25.6L13.9 26.3L14.6 23.9L14.4 23.6C13.7 22.5 13.4 21.3 13.4 20.1C13.4 16.5 16.4 13.5 20 13.5C21.8 13.5 23.4 14.2 24.7 15.4C26 16.7 26.6 18.3 26.6 20.1C26.6 23.6 23.7 26.6 20 26.6ZM23.6 21.6C23.4 21.5 22.4 21 22.2 21C22 20.9 21.9 20.9 21.8 21.1C21.7 21.3 21.3 21.7 21.2 21.9C21.1 22 21 22 20.8 22C20.6 21.9 20 21.7 19.2 21C18.6 20.5 18.2 19.8 18.1 19.6C18 19.4 18.1 19.3 18.2 19.2C18.3 19.1 18.4 19 18.5 18.9C18.6 18.8 18.6 18.7 18.7 18.6C18.8 18.5 18.7 18.4 18.7 18.3C18.7 18.2 18.3 17.2 18.1 16.8C18 16.5 17.8 16.5 17.7 16.5C17.6 16.5 17.5 16.5 17.3 16.5C17.2 16.5 17 16.5 16.8 16.7C16.6 16.9 16.1 17.4 16.1 18.4C16.1 19.4 16.8 20.3 16.9 20.5C17 20.6 18.3 22.7 20.3 23.5C22 24.2 22.3 24 22.7 24C23.1 24 23.9 23.5 24 23.1C24.2 22.6 24.2 22.2 24.1 22.2C24 21.7 23.8 21.7 23.6 21.6Z" fill="white"/></svg>
            </a>
        </div>
        <div class="flex flex-col items-start">
            <p class="font-semibold text-[14px] text-[#1B1819]">1901 Thornridge Cir. Shiloh,</p>
            <p class="font-semibold text-[14px] text-[#1B1819]">Hawaii 81063</p>
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
    {{-- <div class="container mx-auto text-center">
        <p>&copy; {{ date('Y') }} FoxErgo. All rights reserved.</p>
    </div> --}}
    <script src="{{ asset('js/age-verification.js') }}"></script>
    <x-notifications.age-verification />
</footer>

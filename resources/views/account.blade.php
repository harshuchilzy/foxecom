<x-layouts.app.layout>

    <div class="max-w-[1440px] mx-auto px-5 py-12 flex flex-col gap-8 justify-center items-center">
        <div class="flex justify-start w-full">
            <h2 class="text-[#000000] font-bold text-[28px]">Your Account</h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <a href="{{route('redemptions')}}">
                <div class="border border-[#008ECC] rounded-[6px] p-5 flex gap-4 items-center justify-start">
                    <div class="">
                        <div class="bg-[#0B0E2D] p-3 rounded-full">
                            <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M27.8322 7.01717L24.6655 5.35467C21.8852 3.89642 20.495 3.1665 19.0003 3.1665C17.5057 3.1665 16.1155 3.89484 13.3352 5.35467L12.8269 5.62225L26.955 13.6957L33.3137 10.5132C32.2908 9.35417 30.641 8.48809 27.8322 7.014M34.4347 12.6095L28.1045 15.7762V20.5832C28.1045 20.8981 27.9794 21.2002 27.7567 21.4229C27.534 21.6456 27.2319 21.7707 26.917 21.7707C26.602 21.7707 26.3 21.6456 26.0773 21.4229C25.8546 21.2002 25.7295 20.8981 25.7295 20.5832V16.9637L20.1878 19.7345V34.6812C21.3247 34.3978 22.6182 33.7201 24.6655 32.645L27.8322 30.9825C31.2379 29.1949 32.9416 28.3019 33.8884 26.6948C34.8337 25.0893 34.8337 23.0896 34.8337 19.0948V18.9096C34.8337 15.9123 34.8337 14.0377 34.4347 12.6095ZM17.8128 34.6812V19.7345L3.56599 12.6095C3.16699 14.0377 3.16699 15.9123 3.16699 18.9064V19.0917C3.16699 23.0896 3.16699 25.0893 4.11224 26.6948C5.05908 28.3019 6.76274 29.1965 10.1685 30.9841L13.3352 32.645C15.3824 33.7201 16.676 34.3978 17.8128 34.6812ZM4.68699 10.5148L19.0003 17.6714L24.4011 14.9718L10.3316 6.93167L10.1685 7.01717C7.36124 8.48967 5.70983 9.35575 4.68699 10.5163" fill="white"/></svg>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <p class="font-inter font-semibold text-[15px] text-black">Your Orders</p>
                        <p class="font-inter font-normal text-[12px] text-black">Track, return, view invoices or reorder purchases.</p>
                    </div>
                </div>
            </a>

            <div class="border border-[#008ECC] rounded-[6px] p-5 flex gap-4 items-center justify-start">
                <div class="">
                    <div class="bg-[#0B0E2D] p-3 rounded-full">
                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.75 9.5H33.25V28.5H4.75V9.5ZM19 14.25C20.2598 14.25 21.468 14.7504 22.3588 15.6412C23.2496 16.532 23.75 17.7402 23.75 19C23.75 20.2598 23.2496 21.468 22.3588 22.3588C21.468 23.2496 20.2598 23.75 19 23.75C17.7402 23.75 16.532 23.2496 15.6412 22.3588C14.7504 21.468 14.25 20.2598 14.25 19C14.25 17.7402 14.7504 16.532 15.6412 15.6412C16.532 14.7504 17.7402 14.25 19 14.25ZM11.0833 12.6667C11.0833 13.5065 10.7497 14.312 10.1558 14.9058C9.56197 15.4997 8.75652 15.8333 7.91667 15.8333V22.1667C8.75652 22.1667 9.56197 22.5003 10.1558 23.0942C10.7497 23.688 11.0833 24.4935 11.0833 25.3333H26.9167C26.9167 24.4935 27.2503 23.688 27.8442 23.0942C28.438 22.5003 29.2435 22.1667 30.0833 22.1667V15.8333C29.2435 15.8333 28.438 15.4997 27.8442 14.9058C27.2503 14.312 26.9167 13.5065 26.9167 12.6667H11.0833Z" fill="white"/></svg>
                    </div>
                </div>
                <div class="flex flex-col">
                    <p class="font-inter font-semibold text-[15px] text-black">Your Payments</p>
                    <p class="font-inter font-normal text-[12px] text-black">Manage cards, billing info, and payment methods.</p>
                </div>
            </div>

            <div class="border border-[#008ECC] rounded-[6px] p-5 flex gap-4 items-center justify-start">
                <div class="">
                    <div class="bg-[#0B0E2D] p-3 rounded-full">
                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 1.5835C11.0833 1.5835 4.75 7.91683 4.75 15.8335V26.9168C4.75 28.1766 5.25045 29.3848 6.14124 30.2756C7.03204 31.1664 8.24022 31.6668 9.5 31.6668H14.25V19.0002H7.91667V15.8335C7.91667 12.894 9.08437 10.0749 11.1629 7.9964C13.2414 5.91787 16.0605 4.75016 19 4.75016C21.9395 4.75016 24.7586 5.91787 26.8371 7.9964C28.9156 10.0749 30.0833 12.894 30.0833 15.8335V19.0002H23.75V31.6668H30.0833V33.2502H19V36.4168H28.5C29.7598 36.4168 30.968 35.9164 31.8588 35.0256C32.7496 34.1348 33.25 32.9266 33.25 31.6668V15.8335C33.25 7.91683 26.8692 1.5835 19 1.5835Z" fill="white"/></svg>
                    </div>
                </div>
                <div class="flex flex-col">
                    <p class="font-inter font-semibold text-[15px] text-black">Customer Service</p>
                    <p class="font-inter font-normal text-[12px] text-black">Contact support or resolve an issue.</p>
                </div>
            </div>

            <a href="{{ route('address') }}">
                <div class="border border-[#008ECC] rounded-[6px] p-5 flex gap-4 items-center justify-start">
                    <div class="">
                        <div class="bg-[#0B0E2D] p-3 rounded-full">
                            <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.83301 35.875V15.375L20.4997 5.125L34.1663 15.375V35.875H23.9163V23.9167H17.083V35.875H6.83301Z" fill="white"/></svg>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <p class="font-inter font-semibold text-[15px] text-black">Your Addresses</p>
                        <p class="font-inter font-normal text-[12px] text-black">Add, edit, or remove delivery addresses.</p>
                    </div>
                </div>
            </a>

            <div class="border border-[#008ECC] rounded-[6px] p-5 flex gap-4 items-center justify-start">
                <div class="">
                    <div class="bg-[#0B0E2D] p-3 rounded-full">
                        <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M32.5 13.0001H27.625V10.0913C27.625 5.85007 24.5212 2.06382 20.2962 1.65757C19.1675 1.54893 18.0285 1.67728 16.9523 2.03439C15.8761 2.39151 14.8863 2.96951 14.0464 3.73137C13.2065 4.49323 12.5351 5.42214 12.075 6.45858C11.615 7.49502 11.3766 8.61613 11.375 9.75007V13.0001H6.5V35.7501H32.5V13.0001ZM19.5 27.6251C17.7125 27.6251 16.25 26.1626 16.25 24.3751C16.25 22.5876 17.7125 21.1251 19.5 21.1251C21.2875 21.1251 22.75 22.5876 22.75 24.3751C22.75 26.1626 21.2875 27.6251 19.5 27.6251ZM14.625 13.0001V9.75007C14.625 7.05257 16.8025 4.87507 19.5 4.87507C22.1975 4.87507 24.375 7.05257 24.375 9.75007V13.0001H14.625Z" fill="white"/></svg>
                    </div>
                </div>
                <div class="flex flex-col">
                    <p class="font-inter font-semibold text-[15px] text-black">Login & Security</p>
                    <p class="font-inter font-normal text-[12px] text-black">Change your email, password, or sign-in settings.</p>
                </div>
            </div>

            <div class="border border-[#008ECC] rounded-[6px] p-5 flex gap-4 items-center justify-start">
                <div class="">
                    <div class="bg-[#0B0E2D] px-5 py-3 rounded-full">
                        <svg width="24" height="39" viewBox="0 0 24 39" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_754_1680)"><path d="M20.4 0H3.6C1.6125 0 0 1.6377 0 3.65625V35.3438C0 37.3623 1.6125 39 3.6 39H20.4C22.3875 39 24 37.3623 24 35.3438V3.65625C24 1.6377 22.3875 0 20.4 0ZM12 36.5625C10.6725 36.5625 9.6 35.4732 9.6 34.125C9.6 32.7768 10.6725 31.6875 12 31.6875C13.3275 31.6875 14.4 32.7768 14.4 34.125C14.4 35.4732 13.3275 36.5625 12 36.5625Z" fill="white"/></g><defs><clipPath id="clip0_754_1680"><rect width="24" height="39" fill="white"/></clipPath></defs></svg>
                    </div>
                </div>
                <div class="flex flex-col">
                    <p class="font-inter font-semibold text-[15px] text-black">Install Our Mobile App</p>
                    <p class="font-inter font-normal text-[12px] text-black">Add the app to your home screen for quicker access.</p>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app.layout>

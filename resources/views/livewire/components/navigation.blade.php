{{-- <header class="relative border-b border-gray-100">
    <div class="flex items-center justify-between h-16 px-4 mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
        <div class="flex items-center">
            <a class="flex items-center flex-shrink-0"
               href="{{ url('/') }}"
               wire:navigate
            >
                <span class="sr-only">Home</span>

                <x-brand.logo class="w-auto h-6 text-indigo-600" />
            </a>

            <nav class="hidden lg:gap-4 lg:flex lg:ml-8">
                @foreach ($this->collections as $collection)
                    <a class="text-sm font-medium transition hover:opacity-75"
                       href="{{ route('collection.view', $collection->defaultUrl->slug) }}"
                       wire:navigate
                    >
                        {{ $collection->translateAttribute('name') }}
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="flex items-center justify-between flex-1 ml-4 lg:justify-end">
            <x-header.search class="max-w-sm mr-4" />

            <div class="flex items-center -mr-4 sm:-mr-6 lg:mr-0">
                @livewire('components.cart')

                <div x-data="{ mobileMenu: false }">
                    <button x-on:click="mobileMenu = !mobileMenu"
                            class="grid flex-shrink-0 w-16 h-16 border-l border-gray-100 lg:hidden">
                        <span class="sr-only">Toggle Menu</span>

                        <span class="place-self-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </span>
                    </button>

                    <div x-cloak
                         x-transition
                         x-show="mobileMenu"
                         class="absolute right-0 top-auto z-50 w-screen p-4 sm:max-w-xs">
                        <ul x-on:click.away="mobileMenu = false"
                            class="p-6 space-y-4 bg-white border border-gray-100 shadow-xl rounded-xl">
                            @foreach ($this->collections as $collection)
                                <li>
                                    <a class="text-sm font-medium"
                                       href="{{ route('collection.view', $collection->defaultUrl->slug) }}"
                                       wire:navigate
                                    >
                                        {{ $collection->translateAttribute('name') }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header> --}}
<header class="w-full bg-themeblack text-white relative" x-data="{ show: false }">
    <div class="lg:flex items-center container mx-auto gap-8 hidden p-4">
        <div>
            <a href="{{route('home')}}"><img class="w-3xs xl:w-2xs" src="{{ asset('images/logo.png') }}" alt=""></a>
        </div>
        <div class="flex items-center justify-between gap-4 w-full">
            <div class="flex items-center gap-4">
                @if (auth()->check())
                    <svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 14.75C13.0711 14.75 14.75 13.0711 14.75 11C14.75 8.92893 13.0711 7.25 11 7.25C8.92893 7.25 7.25 8.92893 7.25 11C7.25 13.0711 8.92893 14.75 11 14.75Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M11 1C8.34784 1 5.8043 2.05357 3.92893 3.92893C2.05357 5.8043 1 8.34784 1 11C1 13.365 1.5025 14.9125 2.875 16.625L11 26L19.125 16.625C20.4975 14.9125 21 13.365 21 11C21 8.34784 19.9464 5.8043 18.0711 3.92893C16.1957 2.05357 13.6522 1 11 1Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    
                    <div class="flex flex-col">
                        <span class="text-sans text-[#C5C6CC] lg:text-sm xl:text-lg font-semibold">Deliver to Joseph</span>
                        <span class="text-sans textwhite lg:text-base xl:text-xl font-bold">Porthcawl CF36 5</span>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4 flex-wrap xl:flex-nowrap lg:w-[20%] xl:w-auto">
                <a href="{{route('home')}}" class="w-[150px] h-[40px] flex items-center justify-center gap-2 rounded-[60px] {{ request()->routeIs('home') ? 'bg-[#1275EE]' : 'bg-[#1275EE4D]' }}">
                    <span>
                        <svg width="15" height="24" viewBox="0 0 15 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.24453 0.046669C9.39217 0.104853 9.52024 0.214258 9.61086 0.359618C9.70148 0.504977 9.75014 0.67904 9.75004 0.85752V10.286H14.2501C14.3908 10.286 14.5287 10.3313 14.648 10.4167C14.7673 10.502 14.8631 10.624 14.9246 10.7686C14.9861 10.9133 15.0107 11.0748 14.9957 11.2347C14.9807 11.3946 14.9266 11.5464 14.8396 11.6729L6.58948 23.6728C6.49308 23.8128 6.36088 23.9151 6.21127 23.9653C6.06166 24.0155 5.90207 24.0112 5.75472 23.9529C5.60736 23.8946 5.47956 23.7853 5.38909 23.6402C5.29863 23.495 5.24999 23.3213 5.24996 23.1431V13.7146H0.74988C0.609159 13.7145 0.471283 13.6693 0.35201 13.5839C0.232737 13.4986 0.136878 13.3766 0.0753894 13.232C0.0139004 13.0873 -0.0107383 12.9258 0.00428917 12.7659C0.0193166 12.606 0.0734039 12.4541 0.16037 12.3277L8.41052 0.32781C8.50675 0.187738 8.63877 0.0854014 8.78824 0.035018C8.9377 -0.0153654 9.09719 -0.0112932 9.24453 0.046669Z" fill="white"/></svg>
                    </span>
                    <span class="text-sans text-white lg:text-base xl:text-xl  font-semibold">Offers</span>
                </a>

                <a href="{{route('products.index')}}" class="w-[150px] h-[40px] flex items-center justify-center gap-2 rounded-[60px] {{ request()->routeIs('products.index') ? 'bg-[#1275EE]' : 'bg-[#1275EE4D]' }}">
                    <span>
                        <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.67264 0.827127C9.87839 0.58029 10.1336 0.379319 10.4218 0.237178C10.71 0.0950367 11.0248 0.0148816 11.3459 0.00188228C11.667 -0.011117 11.9872 0.043328 12.286 0.161706C12.5847 0.280084 12.8553 0.459766 13.0804 0.689163L13.2045 0.827127L17.7251 6.25141H21.157C21.3983 6.2509 21.6369 6.30136 21.8573 6.39949C22.0778 6.49761 22.275 6.6412 22.436 6.82083C22.5971 7.00046 22.7184 7.2121 22.792 7.44187C22.8656 7.67164 22.8899 7.91437 22.8631 8.15416L22.7574 9.03483L22.6424 9.88561L22.5481 10.5225L22.4389 11.2066L22.3147 11.9252L22.1745 12.6702L22.0181 13.4301C21.9353 13.8134 21.8464 14.1962 21.7514 14.5787C21.4969 15.5882 21.1774 16.5801 20.7948 17.5484L20.5408 18.1692L20.2947 18.7302L20.0625 19.2292L19.9544 19.4523L19.6681 20.0156C19.3002 20.7169 18.6058 21.1308 17.8711 21.1906L17.6872 21.1975H5.17847C4.77653 21.2005 4.38133 21.0943 4.03507 20.8902C3.6888 20.6861 3.40449 20.3917 3.21248 20.0386L2.94575 19.5212L2.7388 19.0959L2.62958 18.8602L2.39964 18.3439C1.87457 17.1247 1.44857 15.8652 1.12578 14.5775C1.06336 14.3275 1.00357 14.0769 0.946423 13.8256L0.783165 13.0806L0.637153 12.3517L0.508387 11.6469L0.393417 10.9721L0.293393 10.3351L0.208316 9.74535L0.104842 8.9601L0.0289623 8.32087L0.00941741 8.14496C-0.0143648 7.91909 0.0070061 7.69075 0.0722867 7.47321C0.137567 7.25567 0.245454 7.05329 0.389671 6.87783C0.533888 6.70238 0.711556 6.55735 0.912338 6.45119C1.11312 6.34503 1.33301 6.27985 1.55921 6.25946L1.71557 6.25141H5.15202L9.67264 0.827127ZM9.09434 11.6803C9.01657 11.409 8.84174 11.1758 8.60316 11.0251C8.36458 10.8744 8.07891 10.8167 7.80054 10.863C7.52217 10.9093 7.27055 11.0564 7.09359 11.2762C6.91664 11.496 6.82671 11.7733 6.84093 12.0551L6.85588 12.1885L7.43073 15.6376L7.45947 15.7686C7.53724 16.0399 7.71207 16.2731 7.95065 16.4238C8.18923 16.5745 8.47491 16.6322 8.75328 16.5859C9.03164 16.5396 9.28326 16.3925 9.46022 16.1727C9.63717 15.9529 9.7271 15.6757 9.71288 15.3938L9.69793 15.2605L9.12309 11.8114L9.09434 11.6803ZM15.0762 10.8663C14.7984 10.82 14.5131 10.8772 14.2747 11.0273C14.0363 11.1773 13.8612 11.4097 13.7828 11.6803L13.7541 11.8114L13.1792 15.2605C13.1312 15.5497 13.1956 15.8464 13.3591 16.0898C13.5226 16.3332 13.773 16.5049 14.0589 16.5698C14.3448 16.6347 14.6448 16.5879 14.8974 16.439C15.1499 16.2901 15.3361 16.0503 15.4177 15.7686L15.4464 15.6376L16.0213 12.1885C16.0711 11.8878 15.9996 11.5797 15.8224 11.3318C15.6452 11.0839 15.3768 10.9164 15.0762 10.8663ZM11.4386 2.29874L8.14469 6.25141H14.7325L11.4386 2.29874Z" fill="white"/></svg>
                    </span>
                   <span class="text-sans text-white lg:text-base xl:text-xl  font-semibold">Wholesale</span>
                </a>
            </div>

            <div class="flex items-center">
                <div class="flex flex-col">
                    @auth
                    <span class="text-sans text-[#C5C6CC] lg:text-sm xl:text-lg font-semibold">{{auth()->user()->first_name}}</span>
                    <a href="/settings"><span class="text-sans textwhite lg:text-base xl:text-xl font-bold">Account & Settings</span></a>
                    @else
                        <a href=""><span class="text-sans text-[#C5C6CC] lg:text-sm xl:text-lg font-semibold">Login</span></a>
                        <a href=""><span class="text-sans textwhite lg:text-base xl:text-xl font-bold">Register</span></a>
                    @endauth
                </div>
            </div>

            <div class="flex items-center">
                <div class="flex flex-col">
                    <span class="text-sans text-[#C5C6CC] xl:text-lg font-semibold">Redemptions</span>
                    <span class="text-sans textwhite lg:text-base xl:text-xl font-bold">& Orders</span>
                </div>
            </div>

            <div class="flex items-center -mr-4 sm:-mr-6 lg:mr-0">
                @livewire('components.cart')

                <div x-data="{ mobileMenu: false }">
                    <button x-on:click="mobileMenu = !mobileMenu"
                            class="grid flex-shrink-0 w-16 h-16 border-l border-gray-100 lg:hidden">
                        <span class="sr-only">Toggle Menu</span>

                        <span class="place-self-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </span>
                    </button>

                    <div x-cloak
                         x-transition
                         x-show="mobileMenu"
                         class="absolute right-0 top-auto z-50 w-screen p-4 sm:max-w-xs">
                        <ul x-on:click.away="mobileMenu = false"
                            class="p-6 space-y-4 bg-white border border-gray-100 shadow-xl rounded-xl">
                            @foreach ($this->collections as $collection)
                                <li>
                                    <a class="text-sm font-medium"
                                       href="{{ route('collection.view', $collection->defaultUrl->slug) }}"
                                       wire:navigate
                                    >
                                        {{ $collection->translateAttribute('name') }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block lg:hidden p-4">

        <div class="flex items-center justify-between gap-4 w-full pt-5 relative">
            <button class="w-[40px] h-[40px]" @click="show = !show">
                <img class="w-full h-full rounded-[1000px]" src="https://unavatar.io/x/calebporzio" alt="">   
            </button>
            <button>
                <svg width="35" height="35" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.3 20.2999C20.8127 20.2999 21.3045 20.5036 21.6671 20.8662C22.0296 21.2288 22.2333 21.7205 22.2333 22.2333C22.2333 22.746 22.0296 23.2378 21.6671 23.6003C21.3045 23.9629 20.8127 24.1666 20.3 24.1666C19.7872 24.1666 19.2955 23.9629 18.9329 23.6003C18.5703 23.2378 18.3666 22.746 18.3666 22.2333C18.3666 21.1603 19.227 20.2999 20.3 20.2999ZM4.83331 4.83325H7.99431L8.90298 6.76659H23.2C23.4564 6.76659 23.7022 6.86843 23.8835 7.04972C24.0648 7.231 24.1666 7.47688 24.1666 7.73325C24.1666 7.89759 24.1183 8.06192 24.0506 8.21659L20.59 14.4709C20.2613 15.0606 19.6233 15.4666 18.8983 15.4666H11.6966L10.8266 17.0423L10.7976 17.1583C10.7976 17.2223 10.8231 17.2838 10.8684 17.3291C10.9138 17.3745 10.9752 17.3999 11.0393 17.3999H22.2333V19.3333H10.6333C10.1206 19.3333 9.62881 19.1296 9.26624 18.767C8.90367 18.4044 8.69998 17.9127 8.69998 17.3999C8.69998 17.0616 8.78698 16.7426 8.93198 16.4719L10.2466 14.1036L6.76665 6.76659H4.83331V4.83325ZM10.6333 20.2999C11.1461 20.2999 11.6378 20.5036 12.0004 20.8662C12.363 21.2288 12.5666 21.7205 12.5666 22.2333C12.5666 22.746 12.363 23.2378 12.0004 23.6003C11.6378 23.9629 11.1461 24.1666 10.6333 24.1666C10.1206 24.1666 9.62881 23.9629 9.26624 23.6003C8.90367 23.2378 8.69998 22.746 8.69998 22.2333C8.69998 21.1603 9.56031 20.2999 10.6333 20.2999ZM19.3333 13.5333L22.0206 8.69992H9.80198L12.0833 13.5333H19.3333Z" fill="white"/></svg>
            </button>
            {{-- <div class="modal-action absolute top-3 right-4 !m-0 z-9">
                <form method="dialog">
                    <button class="bg-transparent hover:bg-transparent text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                    </button>
                </form>
            </div> --}}
        </div>

        <div class="flex items-end justify-center gap-4 w-full -mt-6 pl-[15px]">
            <button class="bg-[#1275EE] rounded-[42px] px-6 py-1 font-white min-w-[126px]">Offers</button>
            <div>
                <img class="w-[80px]" src="{{ asset('images/mobilelogo.png') }}" alt="">
            </div>
            <button class="bg-[#3131317D] rounded-[42px] px-6 py-1 font-white">Wholesale</button>
        </div>
        
    </div>

   
    <div class="z-10 p-6 absolute w-full bg-themeblack min-h-screen transition-all duration-300 ease-out transform -translate-y-full" :class="{'translate-y-0': show}" x-show="show" @click.away="show = false">
        <div class="rounded-[15px] p-0 bg-white opacity-100 w-full">
            <div class="p-5">
                <h3 class="text-[24px] font-semibold text-[#000000]">Hi, Joseph!</h3>
            </div>

            <hr>
            <div class="w-full px-4 py-2">
                <ul class="menu text-black w-full p-0 font-normal text-[16px] font-inter">
                    <li class="pb-2">
                        <details close>
                            <summary class="!bg-transparent">Account Settings</summary>
                            <ul>
                                <li><a>Account Settings Submenu 1</a></li>
                                <li><a>Account Settings Submenu 2</a></li>
                            </ul>
                        </details>
                    </li>
                    <li class="pb-2">
                        <details close>
                            <summary>Edit Profile</summary>
                            <ul>
                                <li><a>Notifications Submenu 1</a></li>
                                <li><a>Notifications Submenu 2</a></li>
                            </ul>
                        </details>
                    </li>
                    <li class="pb-2">
                        <details close>
                            <summary>Change Password</summary>
                            <ul>
                                <li><a>Notifications Submenu 1</a></li>
                                <li><a>Notifications Submenu 2</a></li>
                            </ul>
                        </details>
                    </li>
                    <li class="flex items-center justify-between flex-row pb-2">
                        <span>Add a payment method</span>
                        <span><svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.7662 7.35238H7.31948V12.7991H5.50389V7.35238H0.0571289V5.53679H5.50389V0.0900269H7.31948V5.53679H12.7662V7.35238Z" fill="#4B4B4B"/></svg></span>
                    </li>

                    <li class="flex items-center justify-between flex-row pb-2">
                        <span>Push notifications</span>
                        <span class="!bg-transparent">
                            <input type="checkbox" checked="checked" class="toggle border-[#c0bcbd] bg-[#c0bcbd] checked:border-[#E5386D] checked:bg-[#E5386D] checked:text-white"/>
                        </span>
                    </li>
                </ul>
            </div>
            <hr>
            <div class="w-full px-4 py-2">
                <p class="text-[#ADADAD] font-normal text-[16px] ml-2 py-3">More</p>
                <ul class="menu text-black w-full p-0 font-normal text-[16px] font-inter">
                    <li class="pb-2">
                        <details close>
                            <summary class="!bg-transparent">About us</summary>
                            <ul>
                                <li><a>About us Submenu 1</a></li>
                                <li><a>About us Submenu 2</a></li>
                            </ul>
                        </details>
                    </li>
                    <li class="pb-2">
                        <details close>
                            <summary>Privacy policy</summary>
                            <ul>
                                <li><a>Privacy policy Submenu 1</a></li>
                                <li><a>Privacy policy Submenu 2</a></li>
                            </ul>
                        </details>
                    </li>
                    <li class="pb-2">
                        <details close>
                            <summary>Terms and conditions</summary>
                            <ul>
                                <li><a>Terms and conditions Submenu 1</a></li>
                                <li><a>Terms and conditions Submenu 2</a></li>
                            </ul>
                        </details>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</header> 
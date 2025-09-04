<div class="store-notice">
    @if ($storeNoticeStatus)
        <div x-data="{ open: true }" class="">
            <div 
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-5"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-5"
                class="fixed top-0 left-0 w-full z-50 bg-[#1375ee] text-white shadow-md"
            >
                <div class="container mx-auto px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <!-- Info Icon -->
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13 6H11V13.2H13V6ZM13 15.6H11V18H13V15.6Z"
                                    fill="#ffffff"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z"
                                    fill="#ffffff"></path>
                            </g>
                        </svg>
                        <p class="text-sm md:text-base font-medium">
                            {{ $storeNotice }}
                        </p>
                    </div>

                    <!-- Close Button -->
                    <button @click="open = false" class="ml-4 text-white hover:text-[#11316d] transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Spacer -->
            <div 
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-5"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-5" 
                class="h-14">
            </div>
        </div>
    @endif
</div>

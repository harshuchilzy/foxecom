<!-- Lightbox -->
<div >
    <!-- Lightbox Overlay -->
    <div class="fixed inset-0 bg-black/90 z-50 flex-col items-center justify-center" x-show="show" x-transition x-cloak>
        <!-- Action Bar -->
        <div class="flex justify-between items-center px-6 py-3 text-white top-0 w-full z-10 absolute">
            <div class="text-sm"> <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span> </div>
            <div class="flex gap-2">
                <button @click="zoomIn" class="bg-white/10 hover:bg-white/20 px-3 py-1 rounded cursor-pointer">
                    <svg fill="#ffffff" width="16px" height="16px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="m1920 1766.678-368.126-368.234c114.287-146.817 183.033-330.826 183.033-530.99C1734.907 389.16 1345.746 0 867.454 0 389.16 0 0 389.161 0 867.454c0 478.292 389.161 867.453 867.454 867.453 200.164 0 384.065-68.854 530.99-183.033L1766.678 1920 1920 1766.678ZM867.454 1518.044c-358.8 0-650.59-291.79-650.59-650.59s291.79-650.59 650.59-650.59 650.59 291.79 650.59 650.59-291.79 650.59-650.59 650.59ZM975.885 487.943H759.022v271.079h-271.08v216.863h271.08v271.08h216.863v-271.08h271.08V759.022h-271.08v-271.08Z" fill-rule="evenodd"></path> </g></svg>
                </button>
                <button @click="zoomOut" class="bg-white/10 hover:bg-white/20 px-3 py-1 rounded cursor-pointer">
                    <svg fill="#ffffff" width="16px" height="16px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M867.454 1518.044c-358.8 0-650.59-291.79-650.59-650.59s291.79-650.59 650.59-650.59 650.59 291.79 650.59 650.59-291.79 650.59-650.59 650.59ZM1920 1766.678l-368.126-368.234c114.287-146.817 183.033-330.826 183.033-530.99C1734.907 389.16 1345.746 0 867.454 0 389.16 0 0 389.161 0 867.454c0 478.292 389.161 867.453 867.454 867.453 200.164 0 384.065-68.854 530.99-183.033L1766.678 1920 1920 1766.678ZM487.943 975.885h759.021V759.022H487.943v216.863Z" fill-rule="evenodd"></path> </g></svg>
                </button>
                <a :href="images[currentIndex]" download class="bg-white/10 hover:bg-white/20 px-3 py-1 rounded">
                    <svg width="22px" height="22px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>Download-3</title> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Download-3"> <rect id="Rectangle" fill-rule="nonzero" x="0" y="0" width="24" height="24"> </rect> <line x1="12" y1="5" x2="12" y2="15" id="Path" stroke="#ffffff" stroke-width="2" stroke-linecap="round"> </line> <path d="M17,11 L12.7071,15.2929 C12.3166,15.6834 11.6834,15.6834 11.2929,15.2929 L7,11" id="Path" stroke="#ffffff" stroke-width="2" stroke-linecap="round"> </path> <line x1="19" y1="20" x2="5" y2="20" id="Path" stroke="#ffffff" stroke-width="2" stroke-linecap="round"> </line> </g> </g> </g></svg>
                </a>
                <button @click="close" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded cursor-pointer">
                    <svg fill="#ffffff" width="20px" height="20px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5 c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4 C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"></path> </g></svg>
                </button>
            </div>
        </div>

        
        <div class="h-full">
            <!-- Main Image with Arrows -->
            <div class="relative w-full px-4 flex justify-center items-center object-contain max-h-[90%] h-[80%] top-1/2 -translate-y-1/2">
                <img
                    :src="images[currentIndex]"
                    :style="'transform: scale(' + zoom + ')'
                    "
                    class="max-w-full max-h-[90%] top-1/2 object-contain rounded transition-transform duration-300" 
                />
                <button @click="prev" class="absolute left-0 top-1/2 -translate-y-1/2 text-white text-3xl px-2 cursor-pointer">❮</button>
                <button @click="next" class="absolute right-0 top-1/2 -translate-y-1/2 text-white text-3xl px-2 cursor-pointer">❯</button>
            </div>

            <!-- Thumbnails inside Lightbox -->
            <div class="flex overflow-x-auto gap-2 mt-4 px-6 pb-6 w-full absolute bottom-0 justify-center">
                <template x-for="(src, index) in images" :key="'thumb-' + index">
                    <img
                    :src="src"
                    @click="currentIndex = index"
                    :class="{
                        'border-white': currentIndex === index,
                        'border-transparent': currentIndex !== index
                    }"
                    class="w-20 h-14 object-cover rounded cursor-pointer border-2"
                    />
                </template>
            </div>
        </div>
    </div>
</div>
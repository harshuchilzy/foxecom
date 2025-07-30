<div>
    <button class="{{ $type == 'orderBtn' ? 'bg-[#FFD200] rounded-[15px] px-4 py-2 text-black font-roboto text-normal text-[12px] cursor-pointer hover:bg-[#fef381] hover:shadow-lg' : 'bg-[#1275EE] hover:bg-[#11316d] hover:shadow-lg rounded-[12px] w-full py-1 text-white font-inter font-normal text-[12px] text-center cursor-pointer'}}" wire:click.prevent="addToCart">
        <span wire:loading.remove wire:target="addToCart">Buy it again</span>
        <span wire:loading wire:target="addToCart">Adding...</span>
    </button>
</div>

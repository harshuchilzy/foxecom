<div x-data="{ paymentMethod: @entangle('paymentType'), paymentBox: true, waiveDeliveryFee: @entangle('waiveDeliveryFee') }">
    <div class="flex gap-4 mt-4">
        <button @class([
            'px-5 py-2 text-sm border font-medium rounded-lg cursor-pointer',
            'text-green-700 border-green-600 bg-green-50' => $paymentType === 'ngenius',
            'text-gray-500 hover:text-gray-700' => $paymentType !== 'ngenius',
        ]) type="button" @click="paymentBox = true; waiveDeliveryFee = false"
            wire:click.prevent="$set('paymentType', 'ngenius')">
            Pay by Card
        </button>

        <button @class([
            'px-5 py-2 text-sm border font-medium rounded-lg cursor-pointer',
            'text-green-700 border-green-600 bg-green-50' =>
                $paymentType === 'cash-in-hand',
            'text-gray-500 hover:text-gray-700' => $paymentType !== 'cash-in-hand',
        ]) type="button" @click="paymentBox = false"
            wire:click.prevent="$set('paymentType', 'cash-in-hand')">
            Pay with Cash
        </button>

        <button @class([
            'px-5 py-2 text-sm border font-medium rounded-lg cursor-pointer',
            'text-green-700 border-green-600 bg-green-50' =>
                $paymentType === 'pay-via-bank',
            'text-gray-500 hover:text-gray-700' => $paymentType !== 'pay-via-bank',
        ]) type="button" @click="paymentBox = false;"
            wire:click.prevent="$set('paymentType', 'pay-via-bank')">
            Pay via Bank Transfer
        </button>
        {{-- @php
            echo $paymentType;
        @endphp --}}
    </div>

    <button type="button" wire:click.prevent="initiateHostedPaymentPage" wire:loading.attr="disabled"
        wire:target="initiateHostedPaymentPage"
        class="!text-white !bg-[#0066FF] hover:!bg-[#1275EE] focus:ring-4 focus:outline-none font-medium rounded-lg text-sm font-inter px-5 py-2.5 text-center cursor-pointer hover:shadow-lg my-6 w-full
         disabled:!bg-[#4F7FEF] disabled:opacity-90 disabled:cursor-wait">
        <span wire:loading.remove wire:target="initiateHostedPaymentPage">
            Pay Online
        </span>
        <span wire:loading wire:target="initiateHostedPaymentPage">
            Processing...
        </span>
    </button>
</div>

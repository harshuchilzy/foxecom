<div x-data="{ paymentMethod: @entangle('paymentType'), paymentBox: true }">
    <div class="flex gap-4 mt-4">
        <button @class([
            'px-5 py-2 text-sm border font-medium rounded-lg cursor-pointer',
            'text-green-700 border-green-600 bg-green-50' => $paymentType === 'ngenius',
            'text-gray-500 hover:text-gray-700' => $paymentType !== 'ngenius',
        ])
                type="button"
                @click="paymentBox = true"
                wire:click.prevent="$set('paymentType', 'ngenius')">
            Pay by card
        </button>

        <button @class([
            'px-5 py-2 text-sm border font-medium rounded-lg cursor-pointer',
            'text-green-700 border-green-600 bg-green-50' => $paymentType === 'cash-in-hand',
            'text-gray-500 hover:text-gray-700' => $paymentType !== 'cash-in-hand',
        ])
                type="button"
                @click="paymentBox = false"
                wire:click.prevent="$set('paymentType', 'cash-in-hand')">
            Pay with cash
        </button>
        {{-- @php
            echo $paymentType;
        @endphp --}}
    </div>

    <div x-show="paymentBox">
        <div id="ngenius-3ds-mount" class="h-56 hidden"></div>

        <div wire:ignore>
            <div id="ngenius-mount" class="h-56 my-4"></div>
        </div>
    </div>
    <div class="my-6" x-show="!paymentBox">
        <label for="clientPassword" class="block mb-2 text-sm font-medium text-gray-900 ">Client Payment Password</label>
        <div class="flex md:flex-row flex-col gap-2 w-full">
            <div class="w-full relative">
                <input type="password" id="clientPassword" wire:model="clientPassword" @class([
                    'bg-gray-50 border w-full text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5', 'border-gray-300' => $isVerified == false, 'border-green-300' => $isVerified == true]) placeholder="" />
                
                @if($isVerified)
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-green-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <button type="button" class="!text-white !bg-[#0066FF] hover:!bg-[#1275EE] focus:ring-4 focus:outline-none font-medium rounded-lg text-sm font-inter px-5 py-2.5 text-center cursor-pointer hover:shadow-lg"  wire:click="verifyAuthenticationKey" primary >
                <span wire:loading.remove wire:target="verifyAuthenticationKey">Verify</span>
                <span wire:loading wire:target="verifyAuthenticationKey">Verifying...</span>
            </button>
        </div>
        @if ($errors->has('client-key-error'))
            <div class="p-2 mt-4 text-xs font-medium text-center text-red-700 rounded bg-red-50"
                role="alert">
                @foreach ($errors->get('client-key-error') as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
    </div>
</div>


@script
<script>
    let sessionId = null;
    const csrfToken = '{{ csrf_token() }}';
    let payBtn = document.getElementById('payBtn');
    const mountNgeniusPaymentForm = document.getElementById('ngenius-mount');
    const mount3DSDiv = document.getElementById('ngenius-3ds-mount');
    const apiKey = '{{ config('lunar.payments.types.ngenius.sdk_key') }}';
    const outletRef = '{{ config('lunar.payments.types.ngenius.outlet_ref') }}';

    const resetFormParts = () => {
        const newBtn = payBtn.cloneNode(true);
        payBtn.parentNode.replaceChild(newBtn, payBtn);
        payBtn = newBtn;

        window.Alpine.initTree(payBtn);

        mountNgeniusPaymentForm.innerHTML = '';

        mount3DSDiv.innerHTML = '';
        mount3DSDiv.classList.add('hidden');
    }

    const setButtonState = (btn, enabled, textEnabled = btn.textContent, textDisabled = btn.textContent) => {
        btn.disabled = !enabled;
        btn.textContent = enabled ? textEnabled : textDisabled;
        $wire.dispatch('switchsubmitpaymentbtn', {switch: !enabled});
    }

    const initializePaymentForm = () => {
        window.NI.unMountCardInputs();

        window.NI.mountCardInput('ngenius-mount', {
            apiKey: apiKey,
            outletRef: outletRef,
            style: {
                main: {
                    display: 'flex',
                    flexDirection: 'column',
                    marginBottom: '1rem',
                },
                base: {
                    fontSize: '16px',
                    color: '#2D3748',
                    backgroundColor: '#F7FAFC',
                    border: '1px solid #CBD5E0',
                    borderRadius: '0.375rem',
                    padding: '0.5rem 0.75rem',
                    transition: 'border-color 0.2s ease',
                },
                focus: {
                    borderColor: '#3182CE',
                    boxShadow: '0 0 0 1px #3182CE',
                },
                invalid: {
                    borderColor: '#E53E3E',
                    backgroundColor: '#FFF5F5',
                },
                showInputsLabel: true,
            },
            onSuccess: async () => {
                payBtn.addEventListener('click', async () => {
                    if (payBtn.disabled) return;

                    setButtonState(payBtn, false, 'Processing...', 'Processing...');

                    const {session_id} = await window.NI.generateSessionId();

                    const payData = await fetch("{{ route('checkout.initiate') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({sessionId: session_id}),
                    }).then(r => r.json());

                    mount3DSDiv.classList.remove('hidden');

                    const finalState = await window.NI.handlePaymentResponse(payData, {
                        mountId: 'ngenius-3ds-mount',
                        style: {
                            width: 500,
                            height: 500,
                        }
                    });

                    if (finalState.status !== 'CAPTURED') {
                        resetFormParts();
                        initializePaymentForm();
                        console.warn('Payment not captured. State:', finalState.state);
                        return;
                    }

                    const result = await fetch("{{ route('checkout.complete') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({sessionId: session_id}),
                    }).then(r => r.json());

                    if (result.success !== true) {
                        resetFormParts();
                        initializePaymentForm();
                        console.warn('Payment capture failed:', result.message);
                        return;
                    }

                    mount3DSDiv.classList.add('hidden');
                    window.location.href = '{{ route('checkout-success.view')}}';
                });
            },
            onFail: err => {
                console.error('SDK mount failed:', err);
            },
            onChangeValidStatus: ({isPanValid, isExpiryValid, isCVVValid, isNameValid}) => {
                const allValid = isPanValid && isExpiryValid && isCVVValid && isNameValid;

                setButtonState(payBtn, allValid, 'Submit Payment', 'Enter card details');
            }
        });
    }

    initializePaymentForm();

</script>
@endscript

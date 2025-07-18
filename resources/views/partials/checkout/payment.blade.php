<div>
    <div id="ngenius-3ds-mount" class="h-56 hidden"></div>

    <div wire:ignore>
        <div id="ngenius-mount" class="h-56 my-4"></div>
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

@extends('web/layouts/master')

@section('content')
<section class="inner-banner-wrapper">
    <div class="inner-banner-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="banner-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Make a Donation</li>
                        </ol>
                    </nav>
                    <h5>We appreciate your generous donation. Your donation helps to sustain iPharmacy.com. We will
                        email a receipt to your email account. Thank you.</h5>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="donation-wrapper common-gap">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3 mb-md-0">
                <div class="donation-left-img">
                    <img class="img-fluid" src="{{ url('assets/images/donation-left-img1.jpg') }}" alt="">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="donation-right-wrap">
                    <div class="donation-title-wrap">
                        <div class="donation-title">
                            <h3>Make a Donation</h3>
                            <div class="row mt-3">
                                <div class="col-12 col-md-12 mb-3">
                                    <div class="InputError-box">
                                        <div class="input-group donation-custom-amount">
                                            <input type="text" id="donor_name" class="form-control" placeholder="Full Name*" required @auth value="{{ auth()->user()->name.' '.auth()->user()->last_name   }}" @endauth>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 mb-3">
                                    <div class="InputError-box">
                                        <div class="input-group donation-custom-amount">
                                            <input type="email" id="donor_email" class="form-control" placeholder="Email*" required @auth value="{{ auth()->user()->email}}" @endauth>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 mb-3">
                                    <div class="InputError-box">
                                        <div class="input-group donation-custom-amount">
                                            <input type="text" id="donor_phone" class="form-control" placeholder="Phone Number" @auth value="{{ auth()->user()->mobile}}" @endauth>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul>
                                <li>
                                    <input type="radio" id="Donation_One_Time" name="donation_time" value="Donation_One_Time" checked>
                                    <label for="Donation_One_Time">ONE TIME</label>
                                </li>
                                <li>
                                    <input type="radio" id="Donation_Monthly" name="donation_time" value="Donation_Monthly">
                                    <label for="Donation_Monthly">MONTHLY</label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Monthly Subscription Notice -->
                    <div id="monthly-notice" style="display: none; margin-bottom: 20px; padding: 15px; background-color: #e8f4f8; border-radius: 5px; border-left: 4px solid #17a2b8;">
                        <p style="margin: 0; color: #0c5460;">
                            <i class="fa-solid fa-info-circle"></i>
                            <strong>Monthly Subscription:</strong> You will be charged this amount every month until you
                            cancel. You can manage your subscription anytime after donation.
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                            <div class="choose-donation-group">
                                <input id="Donation_Price5" name="Donation_Price" value="5" type="radio" />
                                <label for="Donation_Price5">
                                    <span>$5</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                            <div class="choose-donation-group">
                                <input id="Donation_Price10" name="Donation_Price" value="10" type="radio" />
                                <label for="Donation_Price10">
                                    <span>$10</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                            <div class="choose-donation-group">
                                <input id="Donation_Price15" name="Donation_Price" value="15" type="radio" />
                                <label for="Donation_Price15">
                                    <span>$15</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                            <div class="choose-donation-group">
                                <input id="Donation_Price20" name="Donation_Price" value="20" type="radio" />
                                <label for="Donation_Price20">
                                    <span>$20</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                            <div class="choose-donation-group">
                                <input id="Donation_Price25" name="Donation_Price" value="25" type="radio" />
                                <label for="Donation_Price25">
                                    <span>$25</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                            <div class="choose-donation-group">
                                <input id="Donation_Price35" name="Donation_Price" value="35" type="radio" />
                                <label for="Donation_Price35">
                                    <span>$35</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-8 mb-3">
                            <div class="InputError-box">
                                <div class="input-group donation-custom-amount">
                                    <span class="input-group-text" id="custom_amount">$</span>
                                    <input type="text" id="custom_amount_input" class="form-control" placeholder="Other Amount" aria-label="Username" aria-describedby="Other-Amount">
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Notice for Monthly -->
                    <div id="payment-method-notice" style="display: none; margin-bottom: 15px; padding: 10px; background-color: #fff3cd; border-radius: 5px; border-left: 4px solid #ffc107;">
                        <p style="margin: 0; color: #856404; font-size: 14px;">
                            <i class="fa-solid fa-exclamation-triangle"></i>
                            <strong>Note:</strong> Monthly subscriptions are only available with Square payment method.
                            PayPal recurring donations are not currently supported.
                        </p>
                    </div>

                    <div class="choose-payment-method">

                        <h4>Choose Payment method</h4>

                        <ul>
                            <li>
                                <div class="choose-donation-group">
                                    <input id="payment_method_square" name="payment_method" value="square" type="radio" />
                                    <label for="payment_method_square">
                                        <span class="name">Credit/Debit card</span>
                                        <span class="img">
                                            <img class="img-fluid" src="{{ url('assets/images/Payment-icons.png') }}" alt="">
                                        </span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="choose-donation-group">
                                    <input id="payment_method_paypal" name="payment_method" value="paypal" type="radio" />
                                    <label for="payment_method_paypal">
                                        <span class="name">PayPal</span>
                                        <span class="img"><img class="img-fluid" src="{{ url('assets/images/paypal-icon.png') }}" alt=""></span>
                                    </label>
                                </div>
                            </li>
                        </ul>

                        

                        <div id="square-card-section" style="display:none; margin-top:20px;">
                            <div id="card-container"></div>
                            <input type="hidden" id="card-nonce" name="nonce">
                        </div>
                    </div>
                    <div class="donation-submit-btn">
                        <button type="button" id="donation-submit" class="btn common-btn1">
                            <abbr id="submit-text">Submit Now</abbr>
                            <span><i class="fa-solid fa-arrow-right"></i></span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


{{-- <script src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", async function() {
            const submitBtn = document.getElementById('donation-submit');
            // const customAmountInput = document.getElementById('custom_amount');
            const customAmountInput = document.querySelector('input[placeholder="Other Amount"]');
            const donationRadios = document.querySelectorAll('input[name="Donation_Price"]');
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
            const squareSection = document.getElementById('square-card-section');
            let card;

            if (customAmountInput) {
                customAmountInput.addEventListener('focus', function() {
                    donationRadios.forEach(radio => radio.checked = false);
                });
                customAmountInput.addEventListener('input', function() {
                    donationRadios.forEach(radio => radio.checked = false);
                });
            }

            // If a radio is clicked, clear custom amount
            donationRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        customAmountInput.value = '';
                    }
                });
            });

            // Toggle Square card input if selected
            paymentRadios.forEach(radio => {
                radio.addEventListener('change', async function() {
                    if (this.value === 'square') {
                        squareSection.style.display = 'block';
                        if (!card) {
                            try {
                                const payments = Square.payments(
                                    "{{ config('services.square.app_id') }}",
"{{ config('services.square.location_id') }}"
);
card = await payments.card();
await card.attach('#card-container');
} catch (err) {
console.error("Square init error:", err);
alert("Failed to initialize Square payments." + err);
}
}
} else {
squareSection.style.display = 'none';
}
});
});

// If custom amount is focused/typed, clear radio selection
if (customAmountInput) {
customAmountInput.addEventListener('focus', () => donationRadios.forEach(r => r.checked =
false));
customAmountInput.addEventListener('input', () => donationRadios.forEach(r => r.checked =
false));
}
// If a radio is clicked, clear custom amount
donationRadios.forEach(radio => radio.addEventListener('change', () => customAmountInput.value =
''));

// Handle Submit
submitBtn.addEventListener('click', async function() {
let donorName = document.getElementById('donor_name').value.trim();
let donorEmail = document.getElementById('donor_email').value.trim();
let donorPhone = document.getElementById('donor_phone').value.trim();
let donationType = document.querySelector('input[name="donation_time"]:checked')
.value;
let amount = document.querySelector('input[name="Donation_Price"]:checked')
?.value || customAmountInput.value.trim();
let paymentMethod = document.querySelector('input[name="payment_method"]:checked')
?.value;

if (!donorName || !donorEmail || !amount || !paymentMethod) {
alert('Please fill all required fields');
return;
}

if (paymentMethod === 'paypal') {
// Redirect to PayPal flow
let url =
`/paypal/payment?amount=${amount}&type=${donationType}&name=${encodeURIComponent(donorName)}&email=${encodeURIComponent(donorEmail)}&phone=${encodeURIComponent(donorPhone)}`;
window.location.href = url;
} else if (paymentMethod === 'square') {
if (!card) {
alert("Please select Square as payment method first.");
return;
}
// Generate nonce
const result = await card.tokenize();
if (result.status === 'OK') {
let nonce = result.token;

// Send to backend via AJAX
fetch("{{ route('square.process') }}", {
method: "POST",
headers: {
"Content-Type": "application/json",
"X-CSRF-TOKEN": "{{ csrf_token() }}"
},
body: JSON.stringify({
name: donorName,
email: donorEmail,
phone: donorPhone,
type: donationType,
amount: amount,
nonce: nonce
})
})
.then(res => res.json())
.then(data => {
if (data.success) {
window.location.href = data
.redirect_url; // ✅ redirect handled here
} else {
alert("Payment failed: " + data.message);
if (data.redirect_url) {
window.location.href = data
.redirect_url; // optionally redirect to cancel page
}
}
})
.catch(err => {
console.error("Payment error:", err);
alert("Unexpected error occurred.");
});
} else {
alert("Card error: " + result.errors[0].message);
}
}
});
});
</script> --}}


<!--<script src="https://sandbox.web.squarecdn.com/v1/square.js"></script>-->
<script src="https://web.squarecdn.com/v1/square.js"></script>
{{-- <script>
    document.addEventListener("DOMContentLoaded", async function() {
        const submitBtn = document.getElementById('donation-submit');
        const submitText = document.getElementById('submit-text');
        const customAmountInput = document.getElementById('custom_amount_input');
        const donationRadios = document.querySelectorAll('input[name="Donation_Price"]');
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        const donationTimeRadios = document.querySelectorAll('input[name="donation_time"]');
        const squareSection = document.getElementById('square-card-section');
        const monthlyNotice = document.getElementById('monthly-notice');
        const paymentMethodNotice = document.getElementById('payment-method-notice');
        const paypalRadio = document.getElementById('payment_method_paypal');
        const squareRadio = document.getElementById('payment_method_square');
        let card;
        const weAccepted = document.getElementById('we-accepted');
        const weAcceptedTitle = document.getElementById('we-accepted-title');

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'square') {
                    weAccepted.style.display = 'flex'; // or 'block'
                    weAcceptedTitle.style.display = 'block';
                } else {
                    weAccepted.style.display = 'none';
                    weAcceptedTitle.style.display = 'none';
                }
            });
        });
        // Handle donation type change (One Time vs Monthly)
        donationTimeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'Donation_Monthly') {
                    // Show monthly notice
                    monthlyNotice.style.display = 'block';
                    submitText.textContent = 'Start Monthly Subscription';

                    // Enable PayPal in case subscriptions are supported
                    paypalRadio.disabled = false;

                    // If no payment method is selected, default to Square
                    const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
                    // if (!selectedPayment) {
                    //     squareRadio.checked = true;
                    //     squareRadio.dispatchEvent(new Event('change'));
                    // }

                } else { // One-Time donation
                    monthlyNotice.style.display = 'none';
                    paymentMethodNotice.style.display = 'none';
                    submitText.textContent = 'Submit Now';

                    // Re-enable PayPal
                    paypalRadio.disabled = false;
                }
            });
        });
        // Handle custom amount input
        if (customAmountInput) {
            customAmountInput.addEventListener('focus', function() {
                donationRadios.forEach(radio => radio.checked = false);
            });
            customAmountInput.addEventListener('input', function() {
                donationRadios.forEach(radio => radio.checked = false);

                // Validate minimum amount for subscriptions
                const donationType = document.querySelector('input[name="donation_time"]:checked').value;
                if (donationType === 'Donation_Monthly') {
                    const amount = parseFloat(this.value);
                    if (amount && amount < 5) {
                        this.setCustomValidity('Minimum amount for monthly subscription is $5');
                    } else {
                        this.setCustomValidity('');
                    }
                }
            });
        }

        // Clear custom amount when radio is selected
        donationRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    customAmountInput.value = '';
                    customAmountInput.setCustomValidity('');
                }
            });
        });

        // Toggle Square card input if selected
        paymentRadios.forEach(radio => {
            radio.addEventListener('change', async function() {
                if (this.value === 'square') {
                    squareSection.style.display = 'block';
                    if (!card) {
                        try {
                            const payments = Square.payments(
                                "{{ config('services.square.app_id') }}"
, "{{ config('services.square.location_id') }}"
);
card = await payments.card();
await card.attach('#card-container');
} catch (err) {
console.error("Square init error:", err);
alert("Failed to initialize Square payments: " + err.message);
}
}
} else {
squareSection.style.display = 'none';
}
});
});

// Handle Submit
submitBtn.addEventListener('click', async function() {
// Disable submit button to prevent double clicks
submitBtn.disabled = true;
const originalText = submitText.textContent;
submitText.textContent = 'Processing...';

try {
let donorName = document.getElementById('donor_name').value.trim();
let donorEmail = document.getElementById('donor_email').value.trim();
let donorPhone = document.getElementById('donor_phone').value.trim();
let donationType = document.querySelector('input[name="donation_time"]:checked').value;
let amount = document.querySelector('input[name="Donation_Price"]:checked') ? .value || customAmountInput.value.trim();
let paymentMethod = document.querySelector('input[name="payment_method"]:checked') ? .value;


if (!donorName || !donorEmail || !amount || !paymentMethod) {
alert('Please fill all required fields');
return;
}


const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
if (!emailRegex.test(donorEmail)) {
alert('Please enter a valid email address');
return;
}


const amountNum = parseFloat(amount);
if (isNaN(amountNum) || amountNum <= 0) { alert('Please enter a valid amount'); return; } if (donationType==='Donation_Monthly' && amountNum < 5) { alert('Minimum amount for monthly subscription is $5'); return; } // if (donationType==='Donation_Monthly' && paymentMethod==='paypal' ) { // alert('Monthly subscriptions are only available with Square payment method'); // return; // } if (paymentMethod==='paypal' ) { const paypalPaymentUrl=@json(route('paypal.payment')); const paypalSubscriptionUrl=@json(route('paypal.subscription')); // const url=`${paypalPaymentUrl}?amount=${amount}&type=${donationType}&name=${encodeURIComponent(donorName)}&email=${encodeURIComponent(donorEmail)}&phone=${encodeURIComponent(donorPhone)}`; // window.location.href=url; let url='' ; if (donationType==='Donation_One_Time' ) { url=`${paypalPaymentUrl}?amount=${amount}&type=Donation_One_Time&name=${encodeURIComponent(donorName)}&email=${encodeURIComponent(donorEmail)}&phone=${encodeURIComponent(donorPhone)}`; } else { url=`${paypalSubscriptionUrl}?amount=${amount}&name=${encodeURIComponent(donorName)}&email=${encodeURIComponent(donorEmail)}&phone=${encodeURIComponent(donorPhone)}`; } window.location.href=url; return; } else if (paymentMethod==='square' ) { if (!card) { alert("Please wait for Square payment form to load."); return; } const result=await card.tokenize(); if (result.status==='OK' ) { let nonce=result.token; const response=await fetch("{{ route('square.process') }}", { method: "POST" , headers: { "Content-Type" : "application/json" , "X-CSRF-TOKEN" : "{{ csrf_token() }}" } , body: JSON.stringify({ name: donorName , email: donorEmail , phone: donorPhone , type: donationType , amount: amount , nonce: nonce }) }); const data=await response.json(); if (data.success) { window.location.href=data.redirect_url; } else { console.log(data.message) alert("Payment failed: " + (data.message || 'Unknown error'));
                            if (data.redirect_url) {
                                window.location.href = data.redirect_url;
                            }
                        }
                    } else {
                        let errorMessage = " Card validation failed"; if (result.errors && result.errors.length> 0) {
    errorMessage = result.errors[0].message;
    }
    alert("Card error: " + errorMessage);
    }
    }
    } catch (error) {
    console.error("Payment error:", error);
    alert("An unexpected error occurred. Please try again.");
    } finally {
    // Re-enable submit button
    submitBtn.disabled = false;
    submitText.textContent = originalText;
    }
    });
    });

    </script> --}}


    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            const submitBtn = document.getElementById('donation-submit');
            const submitText = document.getElementById('submit-text');
            const customAmountInput = document.getElementById('custom_amount_input');
            const donationRadios = document.querySelectorAll('input[name="Donation_Price"]');
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
            const donationTimeRadios = document.querySelectorAll('input[name="donation_time"]');
            const squareSection = document.getElementById('square-card-section');
            const monthlyNotice = document.getElementById('monthly-notice');
            const paymentMethodNotice = document.getElementById('payment-method-notice');
            const paypalRadio = document.getElementById('payment_method_paypal');
            const squareRadio = document.getElementById('payment_method_square');
            let card;
            // const weAccepted = document.getElementById('we-accepted');
            // const weAcceptedTitle = document.getElementById('we-accepted-title');

            // Form fields for validation
            const donorNameField = document.getElementById('donor_name');
            const donorEmailField = document.getElementById('donor_email');
            const donorPhoneField = document.getElementById('donor_phone');

            // Validation functions
            // function showFieldError(field, message) {
            //     // Remove any existing error
            //     removeFieldError(field);

            //     // Add error styling
            //     field.style.borderColor = '#dc3545';
            //     field.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';

            //     // Create error message element
            //     const errorDiv = document.createElement('div');
            //     errorDiv.className = 'field-error-message';
            //     errorDiv.style.color = '#dc3545';
            //     errorDiv.style.fontSize = '12px';
            //     errorDiv.style.marginTop = '4px';
            //     errorDiv.style.display = 'block';
            //     errorDiv.textContent = message;

            //     // Insert error message after the field's parent container
            //     field.parentElement.parentElement.appendChild(errorDiv);
            // }

            // function removeFieldError(field) {
            //     // Reset field styling
            //     field.style.borderColor = '';
            //     field.style.boxShadow = '';

            //     // Remove error message
            //     const existingError = field.parentElement.parentElement.querySelector('.field-error-message');
            //     if (existingError) {
            //         existingError.remove();
            //     }
            // }
            function showFieldError(field, message) {
                // Remove existing error
                removeFieldError(field);

                // Add error styling to input
                field.classList.add('is-invalid'); // Bootstrap red border

                // Create error element
                const errorDiv = document.createElement('div');
                errorDiv.className = 'field-error-message text-danger';
                errorDiv.style.fontSize = '12px';
                errorDiv.style.marginTop = '4px';
                errorDiv.textContent = message;

                // Append after .input-group, inside .InputError-box
                const inputGroup = field.closest('.input-group');
                const errorBox = field.closest('.InputError-box');
                if (inputGroup && errorBox) {
                    inputGroup.insertAdjacentElement('afterend', errorDiv);
                }
            }

            function removeFieldError(field) {
                field.classList.remove('is-invalid');
                const errorBox = field.closest('.InputError-box');
                if (!errorBox) return;
                const existingError = errorBox.querySelector('.field-error-message');
                if (existingError) existingError.remove();
            }

            function showFieldSuccess(field) {
                removeFieldError(field);
                field.style.borderColor = '#28a745';
                field.style.boxShadow = '0 0 0 0.2rem rgba(40, 167, 69, 0.25)';
            }

            function validateName(name) {
                if (!name.trim()) {
                    return {
                        isValid: false
                        , message: 'Full name is required'
                    };
                }
                if (name.trim().length < 2) {
                    return {
                        isValid: false
                        , message: 'Name must be at least 2 characters long'
                    };
                }
                if (!/^[a-zA-Z\s]+$/.test(name.trim())) {
                    return {
                        isValid: false
                        , message: 'Name can only contain letters and spaces'
                    };
                }
                return {
                    isValid: true
                };
            }

            function validateEmail(email) {
                if (!email.trim()) {
                    return {
                        isValid: false
                        , message: 'Email is required'
                    };
                }
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email.trim())) {
                    return {
                        isValid: false
                        , message: 'Please enter a valid email address'
                    };
                }
                return {
                    isValid: true
                };
            }

            function validatePhone(phone) {
                if (phone.trim() === '') {
                    return {
                        isValid: true
                    }; // Phone is optional
                }
                const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
                const cleanPhone = phone.replace(/[\s\-\(\)]/g, '');
                if (cleanPhone.length < 10) {
                    return {
                        isValid: false
                        , message: 'Phone number must be at least 10 digits'
                    };
                }
                if (!/^[\+]?[\d\s\-\(\)]+$/.test(phone)) {
                    return {
                        isValid: false
                        , message: 'Please enter a valid phone number'
                    };
                }
                return {
                    isValid: true
                };
            }

            function validateAmount(amount, donationType) {
                if (!amount || amount.trim() === '') {
                    return {
                        isValid: false
                        , message: 'Please select or enter a donation amount'
                    };
                }

                const numAmount = parseFloat(amount);
                if (isNaN(numAmount) || numAmount <= 0) {
                    return {
                        isValid: false
                        , message: 'Please enter a valid amount greater than 0'
                    };
                }

                if (numAmount > 10000) {
                    return {
                        isValid: false
                        , message: 'Maximum donation amount is $10,000'
                    };
                }

                if (donationType === 'Donation_Monthly' && numAmount < 5) {
                    return {
                        isValid: false
                        , message: 'Minimum amount for monthly subscription is $5'
                    };
                }

                return {
                    isValid: true
                };
            }

            // Field validation on blur/focus out
            donorNameField.addEventListener('blur', function() {
                const validation = validateName(this.value);
                if (validation.isValid) {
                    showFieldSuccess(this);
                } else {
                    showFieldError(this, validation.message);
                }
            });

            donorNameField.addEventListener('focus', function() {
                removeFieldError(this);
            });

            donorEmailField.addEventListener('blur', function() {
                const validation = validateEmail(this.value);
                if (validation.isValid) {
                    showFieldSuccess(this);
                } else {
                    showFieldError(this, validation.message);
                }
            });

            donorEmailField.addEventListener('focus', function() {
                removeFieldError(this);
            });

            donorPhoneField.addEventListener('blur', function() {
                const validation = validatePhone(this.value);
                if (validation.isValid) {
                    if (this.value.trim() !== '') {
                        showFieldSuccess(this);
                    } else {
                        removeFieldError(this);
                        this.style.borderColor = '';
                        this.style.boxShadow = '';
                    }
                } else {
                    showFieldError(this, validation.message);
                }
            });

            donorPhoneField.addEventListener('focus', function() {
                removeFieldError(this);
            });

            // Custom amount validation
            customAmountInput.addEventListener('blur', function() {
                if (this.value.trim() !== '') {
                    const donationType = getSelectedDonationType();
                    const validation = validateAmount(this.value, donationType);
                    if (validation.isValid) {
                        showFieldSuccess(this);
                    } else {
                        showFieldError(this, validation.message);
                    }
                } else {
                    removeFieldError(this);
                    this.style.borderColor = '';
                    this.style.boxShadow = '';
                }
            });

            customAmountInput.addEventListener('focus', function() {
                removeFieldError(this);
            });

            // Real-time validation for amount input
            customAmountInput.addEventListener('input', function() {
                // Only allow numbers and decimal point
                this.value = this.value.replace(/[^0-9.]/g, '');

                // Prevent multiple decimal points
                const parts = this.value.split('.');
                if (parts.length > 2) {
                    this.value = parts[0] + '.' + parts.slice(1).join('');
                }

                // Limit to 2 decimal places
                if (parts[1] && parts[1].length > 2) {
                    this.value = parts[0] + '.' + parts[1].substring(0, 2);
                }

                // Clear radio selections when typing
                donationRadios.forEach(r => r.checked = false);
            });

            // Phone number formatting
            donorPhoneField.addEventListener('input', function() {
                // Remove all non-numeric characters except + and -
                let value = this.value.replace(/[^\d\+\-\(\)\s]/g, '');
                this.value = value;
            });

            // Helper functions
            function getSelectedDonationAmount() {
                const selectedRadio = document.querySelector('input[name="Donation_Price"]:checked');
                return selectedRadio ? selectedRadio.value : customAmountInput.value.trim();
            }

            function getSelectedDonationType() {
                return document.querySelector('input[name="donation_time"]:checked').value;
            }

            function getSelectedPaymentMethod() {
                const selected = document.querySelector('input[name="payment_method"]:checked');
                return selected ? selected.value : null;
            }

            function showAmountError(message) {
                // Remove any existing amount error first
                removeAmountError();

                // Create and show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'amount-error-message';
                errorDiv.style.color = '#dc3545';
                errorDiv.style.fontSize = '14px';
                errorDiv.style.marginTop = '10px';
                errorDiv.style.marginBottom = '15px';
                errorDiv.style.padding = '8px 12px';
                errorDiv.style.backgroundColor = '#f8d7da';
                errorDiv.style.border = '1px solid #f5c6cb';
                errorDiv.style.borderRadius = '4px';
                errorDiv.innerHTML = `<i class="fa-solid fa-exclamation-triangle"></i> ${message}`;

                // Find the donation amounts row (the one with all the price buttons and custom amount)
                const donationAmountsRow = document.querySelector('#custom_amount_input').closest('.row');

                // Insert the error message after the donation amounts row
                donationAmountsRow.insertAdjacentElement('afterend', errorDiv);
            }

            function removeAmountError() {
                const existingError = document.querySelector('.amount-error-message');
                if (existingError) {
                    existingError.remove();
                }
            }

            function showPaymentMethodError(message) {
                const paymentSection = document.querySelector('.choose-payment-method');

                // Remove existing payment error
                const existingError = paymentSection.querySelector('.payment-error-message');
                if (existingError) {
                    existingError.remove();
                }

                // Create and show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'payment-error-message';
                errorDiv.style.color = '#dc3545';
                errorDiv.style.fontSize = '14px';
                errorDiv.style.marginTop = '10px';
                errorDiv.style.padding = '8px 12px';
                errorDiv.style.backgroundColor = '#f8d7da';
                errorDiv.style.border = '1px solid #f5c6cb';
                errorDiv.style.borderRadius = '4px';
                errorDiv.innerHTML = `<i class="fa-solid fa-exclamation-triangle"></i> ${message}`;

                // Insert after payment method options
                const paymentUl = paymentSection.querySelector('ul');
                paymentUl.insertAdjacentElement('afterend', errorDiv);
            }

            function removePaymentMethodError() {
                const existingError = document.querySelector('.payment-error-message');
                if (existingError) {
                    existingError.remove();
                }
            }

            function validateAllFields() {
                const nameValid = validateName(donorNameField.value);
                const emailValid = validateEmail(donorEmailField.value);
                const phoneValid = validatePhone(donorPhoneField.value);
                const amount = getSelectedDonationAmount();
                const amountValid = validateAmount(amount, getSelectedDonationType());
                const paymentMethod = getSelectedPaymentMethod();

                let allValid = true;

                if (!nameValid.isValid) {
                    showFieldError(donorNameField, nameValid.message);
                    allValid = false;
                }

                if (!emailValid.isValid) {
                    showFieldError(donorEmailField, emailValid.message);
                    allValid = false;
                }

                if (!phoneValid.isValid) {
                    showFieldError(donorPhoneField, phoneValid.message);
                    allValid = false;
                }

                if (!amountValid.isValid) {
                    showAmountError(amountValid.message);
                    if (customAmountInput.value.trim() !== '') {
                        showFieldError(customAmountInput, amountValid.message);
                    }
                    allValid = false;
                } else {
                    removeAmountError();
                }

                if (!paymentMethod) {
                    showPaymentMethodError('Please select a payment method');
                    allValid = false;
                } else {
                    removePaymentMethodError();
                }

                return allValid;
            }

            // Payment method change handler
            // paymentRadios.forEach(radio => {
            //     radio.addEventListener('change', function() {
            //         // Remove payment method error when user selects a method
            //         removePaymentMethodError();

            //         if (this.value === 'square') {
            //             weAccepted.style.display = 'flex';
            //             weAcceptedTitle.style.display = 'block';
            //         } else {
            //             weAccepted.style.display = 'none';
            //             weAcceptedTitle.style.display = 'none';
            //         }
            //     });
            // });

            // Handle donation type change
            donationTimeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'Donation_Monthly') {
                        monthlyNotice.style.display = 'block';
                        submitText.textContent = 'Start Monthly Subscription';
                        paypalRadio.disabled = false;

                        // Re-validate amount for monthly minimum
                        if (customAmountInput.value.trim() !== '') {
                            const validation = validateAmount(customAmountInput.value, 'Donation_Monthly');
                            if (!validation.isValid) {
                                showFieldError(customAmountInput, validation.message);
                            } else {
                                showFieldSuccess(customAmountInput);
                            }
                        }
                    } else {
                        monthlyNotice.style.display = 'none';
                        paymentMethodNotice.style.display = 'none';
                        submitText.textContent = 'Submit Now';
                        paypalRadio.disabled = false;

                        // Re-validate amount for one-time (remove monthly minimum)
                        if (customAmountInput.value.trim() !== '') {
                            const validation = validateAmount(customAmountInput.value, 'Donation_One_Time');
                            if (validation.isValid) {
                                showFieldSuccess(customAmountInput);
                            }
                        }
                    }
                });
            });

            // Custom amount logic
            if (customAmountInput) {
                customAmountInput.addEventListener('focus', () => {
                    donationRadios.forEach(r => r.checked = false);
                    removeFieldError(customAmountInput);
                });
            }

            donationRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    customAmountInput.value = '';
                    removeFieldError(customAmountInput);
                    removeAmountError(); // Remove amount error when user selects preset amount
                    customAmountInput.style.borderColor = '';
                    customAmountInput.style.boxShadow = '';
                });
            });

            // Initialize Square card if selected
            paymentRadios.forEach(radio => {
                radio.addEventListener('change', async function() {
                    if (this.value === 'square') {
                        squareSection.style.display = 'block';
                        if (!card) {
                            try {
                                const payments = Square.payments("{{ config('services.square.app_id') }}", "{{ config('services.square.location_id') }}");
                                card = await payments.card();
                                await card.attach('#card-container');
                            } catch (err) {
                                console.error("Square init error:", err);
                                alert("Failed to initialize Square payments: " + err.message);
                            }
                        }
                    } else {
                        squareSection.style.display = 'none';
                    }
                });
            });

            // Handle submit
            submitBtn.addEventListener('click', async function() {
                // Validate all fields before processing
                if (!validateAllFields()) {
                    return;
                }

                const donorName = donorNameField.value.trim();
                const donorEmail = donorEmailField.value.trim();
                const donorPhone = donorPhoneField.value.trim();
                const donationType = getSelectedDonationType();
                const amount = getSelectedDonationAmount();
                const paymentMethod = getSelectedPaymentMethod();

                // Additional validation for monthly PayPal
                // if (donationType === 'Donation_Monthly' && paymentMethod === 'paypal') {
                //     showPaymentMethodError('Monthly subscriptions are only available with Square payment method');
                //     return;
                // }

                submitBtn.disabled = true;
                const originalText = submitText.textContent;
                submitText.textContent = 'Processing...';

                try {
                    if (paymentMethod === 'paypal') {
                        const paypalPaymentUrl = @json(route('paypal.payment'));
                        const paypalSubscriptionUrl = @json(route('paypal.subscription'));
                        let url = donationType === 'Donation_One_Time' ?
                            `${paypalPaymentUrl}?amount=${amount}&type=Donation_One_Time&name=${encodeURIComponent(donorName)}&email=${encodeURIComponent(donorEmail)}&phone=${encodeURIComponent(donorPhone)}` :
                            `${paypalSubscriptionUrl}?amount=${amount}&name=${encodeURIComponent(donorName)}&email=${encodeURIComponent(donorEmail)}&phone=${encodeURIComponent(donorPhone)}`;
                        window.location.href = url;
                        return;
                    } else if (paymentMethod === 'square') {
                        if (!card) {
                            alert("Please wait for Square payment form to load.");
                            return;
                        }
                        const result = await card.tokenize();
                        if (result.status === 'OK') {
                            const nonce = result.token;
                            const response = await fetch("{{ route('square.process') }}", {
                                method: "POST"
                                , headers: {
                                    "Content-Type": "application/json"
                                    , "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                }
                                , body: JSON.stringify({
                                    name: donorName
                                    , email: donorEmail
                                    , phone: donorPhone
                                    , type: donationType
                                    , amount: amount
                                    , nonce
                                })
                            });
                            const data = await response.json();
                            if (data.success) window.location.href = data.redirect_url;
                            else {
                                alert("Payment failed: " + (data.message || 'Unknown error'));
                                if (data.redirect_url) window.location.href = data.redirect_url;
                            }
                        } else {
                            let errorMessage = "Card validation failed";
                            if (result.errors && result.errors.length > 0) errorMessage = result.errors[0].message;
                            alert("Card error: " + errorMessage);
                        }
                    }
                } catch (error) {
                    console.error("Payment error:", error);
                    alert("An unexpected error occurred. Please try again.");
                } finally {
                    submitBtn.disabled = false;
                    submitText.textContent = originalText;
                }
            });
        });

    </script>


    @endsection

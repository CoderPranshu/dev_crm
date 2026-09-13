@php
    $products = \App\Models\Product::where('category_id', '3')->latest()->get();
@endphp

<form action="{{ route('admin.warranty.store') }}" method="POST" id="demoOtpForm">
    @csrf

    <input type="hidden" name="user_id" id="user_id">

    <div class="fpb-7">
        <label class="eForm-label">{{ get_phrase('Phone') }}</label>
        <div style="display: flex; gap: 10px;">
            <input type="tel" class="form-control eForm-control" name="phone_no" id="phone"
                placeholder="Enter phone number">
            <button type="button" class="btn btn-primary btn-sm" id="sendOtpBtn">Send OTP</button>
        </div>
    </div>

    <div class="fpb-7" id="otpSection" style="display: none;">
        <label class="eForm-label">{{ get_phrase('Enter OTP') }}</label>
        <div style="display: flex; gap: 10px;">
            <input type="text" class="form-control eForm-control" id="otpInput" placeholder="Enter OTP">
            <button type="button" class="btn btn-success" id="verifyOtpBtn">Verify OTP</button>
        </div>
        <small id="otpMessage" style="color: red;"></small>
    </div>

    <div class="fpb-7" id="userLookupMessage" style="display:none;"></div>

    <div id="remainingFields" style="opacity: 0.5; pointer-events: none;">
        <div class="fpb-7">
            <label class="eForm-label">{{ get_phrase('Customer Name') }}</label>
            <input type="text" class="form-control eForm-control" name="name" id="name" disabled>
        </div>

        <div class="fpb-7">
            <label class="eForm-label">{{ get_phrase('Email') }}</label>
            <input type="email" class="form-control eForm-control" name="email" id="email" disabled>
        </div>

        <div class="fpb-7">
            <label class="eForm-label">{{ get_phrase('Product') }}</label>
            <select name="product_id" class="eForm-control form-control" id="product_id" disabled>
                <option value="">{{ get_phrase('Select Product') }}</option>
                @foreach ($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="fpb-7">
            <button type="submit" class="btn-form my-2 w-100" id="submitBtn" disabled>
                Submit
            </button>
        </div>
    </div>
</form>

<script>
let otpVerified = false;

let resendTimer = 45;
let timerInterval = null;

const sendOtpBtn = document.getElementById('sendOtpBtn');
const verifyOtpBtn = document.getElementById('verifyOtpBtn');
const otpSection = document.getElementById('otpSection');
const otpInput = document.getElementById('otpInput');
const otpMessage = document.getElementById('otpMessage');
const phoneInput = document.getElementById('phone');

const remainingFields = document.getElementById('remainingFields');
const nameField = document.getElementById('name');
const emailField = document.getElementById('email');
const productField = document.getElementById('product_id');
const submitBtn = document.getElementById('submitBtn');
const userIdField = document.getElementById('user_id');
const userLookupMessage = document.getElementById('userLookupMessage');


// ✅ SEND OTP
sendOtpBtn.addEventListener('click', function () {

    const phone = phoneInput.value.trim();

    if (phone === '' || phone.length < 10) {
        alert('Please enter valid phone number');
        return;
    }

    sendOtpBtn.disabled = true;

    fetch("{{ route('admin.send.otp') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ phone: phone })
    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {

            otpSection.style.display = 'block';

            otpMessage.innerText = data.message;
            otpMessage.style.color = 'green';

            // ✅ POPUP OTP
            alert("Your OTP is: " + data.otp);

            // OPTIONAL: Autofill OTP
            otpInput.value = data.otp;

            startResendTimer();

        } else {
            alert('Failed to send OTP');
            sendOtpBtn.disabled = false;
        }
    })
    .catch(() => {
        alert('Something went wrong');
        sendOtpBtn.disabled = false;
    });
});


// ✅ TIMER
function startResendTimer() {

    resendTimer = 45;

    sendOtpBtn.innerText = `Resend OTP in ${resendTimer}s`;

    timerInterval = setInterval(() => {

        resendTimer--;

        sendOtpBtn.innerText = `Resend OTP in ${resendTimer}s`;

        if (resendTimer <= 0) {
            clearInterval(timerInterval);
            sendOtpBtn.disabled = false;
            sendOtpBtn.innerText = "Resend OTP";
        }

    }, 1000);
}


// ✅ VERIFY OTP
verifyOtpBtn.addEventListener('click', function () {

    const otp = otpInput.value.trim();
    const phone = phoneInput.value.trim();

    fetch("{{ route('admin.verify.otp') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            otp: otp,
            phone: phone
        })
    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {

            otpVerified = true;

            otpMessage.innerText = data.message;
            otpMessage.style.color = 'green';

            // ENABLE FORM
            remainingFields.style.opacity = '1';
            remainingFields.style.pointerEvents = 'auto';

            nameField.disabled = false;
            emailField.disabled = false;
            productField.disabled = false;
            submitBtn.disabled = false;

            checkExistingUser(phone);

        } else {
            otpMessage.innerText = data.message;
            otpMessage.style.color = 'red';
        }
    });

});


// ✅ CHECK USER
function checkExistingUser(phone) {

    fetch("{{ route('admin.warranty.check-user') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        },
        body: JSON.stringify({ phone_no: phone })
    })
    .then(res => res.json())
    .then(data => {

        userLookupMessage.style.display = 'block';

        if (data.exists) {

            userIdField.value = data.user.id;
            nameField.value = data.user.name ?? '';
            emailField.value = data.user.email ?? '';

            nameField.readOnly = true;
            emailField.readOnly = true;

            userLookupMessage.innerHTML =
                '<span class="text-success">Existing user found.</span>';

        } else {

            userIdField.value = '';
            nameField.value = '';
            emailField.value = '';

            nameField.readOnly = false;
            emailField.readOnly = false;

            userLookupMessage.innerHTML =
                '<span class="text-warning">User not found. Enter details.</span>';
        }

    })
    .catch(() => {

        userLookupMessage.style.display = 'block';
        userLookupMessage.innerHTML =
            '<span class="text-danger">Error checking user.</span>';
    });
}
</script>

{{-- <script>
    let otpVerified = false;

    // TIMER VARIABLES
    let resendTimer = 45;
    let timerInterval = null;

    const sendOtpBtn = document.getElementById('sendOtpBtn');
    const verifyOtpBtn = document.getElementById('verifyOtpBtn');
    const otpSection = document.getElementById('otpSection');
    const otpInput = document.getElementById('otpInput');
    const otpMessage = document.getElementById('otpMessage');
    const phoneInput = document.getElementById('phone');

    const remainingFields = document.getElementById('remainingFields');
    const nameField = document.getElementById('name');
    const emailField = document.getElementById('email');
    const productField = document.getElementById('product_id');
    const submitBtn = document.getElementById('submitBtn');
    const userIdField = document.getElementById('user_id');
    const userLookupMessage = document.getElementById('userLookupMessage');

    // SEND OTP
    sendOtpBtn.addEventListener('click', function () {
        const phone = phoneInput.value.trim();

        if (phone === '' || phone.length < 10) {
            alert('Please enter valid phone number');
            return;
        }

        // Disable button immediately
        sendOtpBtn.disabled = true;

        fetch("{{ route('admin.send.otp') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                phone: phone
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                otpSection.style.display = 'block';
                otpMessage.innerText = data.message;
                otpMessage.style.color = 'green';

                startResendTimer(); // START TIMER

            } else {
                alert('Failed to send OTP');
                sendOtpBtn.disabled = false;
            }
        })
        .catch(() => {
            alert('Something went wrong');
            sendOtpBtn.disabled = false;
        });
    });

    // TIMER FUNCTION
    function startResendTimer() {
        resendTimer = 45;

        sendOtpBtn.innerText = `Resend OTP in ${resendTimer}s`;

        timerInterval = setInterval(() => {
            resendTimer--;

            sendOtpBtn.innerText = `Resend OTP in ${resendTimer}s`;

            if (resendTimer <= 0) {
                clearInterval(timerInterval);

                sendOtpBtn.disabled = false;
                sendOtpBtn.innerText = "Resend OTP";
            }
        }, 1000);
    }

    // VERIFY OTP
    verifyOtpBtn.addEventListener('click', function () {
        const otp = otpInput.value.trim();
        const phone = phoneInput.value.trim();

        fetch("{{ route('admin.verify.otp') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                otp: otp,
                phone: phone
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                otpVerified = true;

                otpMessage.innerText = data.message;
                otpMessage.style.color = 'green';

                remainingFields.style.opacity = '1';
                remainingFields.style.pointerEvents = 'auto';

                nameField.disabled = false;
                emailField.disabled = false;
                productField.disabled = false;
                submitBtn.disabled = false;

                checkExistingUser(phone);
            } else {
                otpMessage.innerText = data.message;
                otpMessage.style.color = 'red';
            }
        });
    });

    // CHECK USER
    function checkExistingUser(phone) {
        fetch("{{ route('admin.warranty.check-user') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                phone_no: phone
            })
        })
        .then(response => response.json())
        .then(data => {
            userLookupMessage.style.display = 'block';

            if (data.exists) {
                userIdField.value = data.user.id;
                nameField.value = data.user.name ?? '';
                emailField.value = data.user.email ?? '';

                nameField.readOnly = true;
                emailField.readOnly = true;

                userLookupMessage.innerHTML =
                    '<span class="text-success">Existing user found and selected.</span>';
            } else {
                userIdField.value = '';
                nameField.value = '';
                emailField.value = '';

                nameField.readOnly = false;
                emailField.readOnly = false;

                userLookupMessage.innerHTML =
                    '<span class="text-warning">User not found. Please enter details.</span>';
            }
        })
        .catch(error => {
            console.error(error);
            userLookupMessage.style.display = 'block';
            userLookupMessage.innerHTML =
                '<span class="text-danger">Error checking user.</span>';
        });
    }
</script> --}}

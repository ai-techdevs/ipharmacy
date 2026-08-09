<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ipharmacy</title>
    <!-- Bootstrap -->
    <link rel="shortcut icon" href="{{ url('assets/images/favicon.jpg')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" media="all">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="{{ url('assets/css/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/aos.css')}}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/menu.css')}}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/style.css')}}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/responsive.css')}}" rel="stylesheet" media="all">
    
  </head>
  <body>
    
 <section class="otp-body">
    <div class="otp-Verification-wrap">
        <div class="title">
            <h3>OTP Verification</h3>
            <p>Please enter 6-digit verification code we sent to your email</p>
            <h5>{{ mask_email(session('registration_email', 'youremail@gmail.com')) }}</h5>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->has('otp'))
            <div class="alert alert-danger">{{ $errors->first('otp') }}</div>
        @endif
        @if($errors->has('general'))
            <div class="alert alert-danger">{{ $errors->first('general') }}</div>
        @endif

        <form method="POST" action="{{ route('otp.verify.submit') }}" id="otp-form">
            @csrf
            <div class="otp-input">
                <ul class="d-flex gap-2 list-unstyled justify-content-center">
                    @for($i=0;$i<6;$i++)
                        <li>
                            <input inputmode="numeric" pattern="\d*" class="otp-digit" type="text" maxlength="1" autocomplete="one-time-code" />
                        </li>
                    @endfor
                </ul>
                <input type="hidden" name="otp" id="otp-hidden" />
            </div>

            <div class="resend-otp-wrap mt-3">
                <p>Didn’t receive a code? 
                    <button type="button" id="resend-otp" class="btn btn-link p-0">Resend</button>
                    <span id="resend-timer" class="text-muted"></span>
                </p>
            </div>

            <div class="verify-btn-wrap mt-4">
                <button type="submit" class="common-btn2">Verify</button>
            </div>
        </form>
    </div>
    <div class="back-btn-wrap mt-3">
        <a href="{{ route('registration') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i> </a>
    </div>
</section>
{{-- @if(session('registration_otp'))
    <script>
        alert("Your test OTP is: {{ session('registration_otp') }}");
    </script>
@endif --}}
@php
   
    function mask_email($email) {
        if (strpos($email, '@') === false) return $email;
        [$local, $domain] = explode('@', $email, 2);
        $keep = 2;
        $maskedLocal = strlen($local) <= $keep ? $local : substr($local,0,$keep) . str_repeat('*', max(0, strlen($local)-$keep));
        return $maskedLocal . '@' . $domain;
    }
@endphp
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ url('assets/js/slick.min.js')}}"></script>
    <script src="{{ url('assets/js/aos.js')}}"></script>
    <script src="{{ url('assets/js/menu.js')}}"></script>
    <script src="{{ url('assets/js/external.js')}}"></script>

   <script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.otp-digit');
    const hidden = document.getElementById('otp-hidden');
    const resendBtn = document.getElementById('resend-otp');
    const timerSpan = document.getElementById('resend-timer');
    let resendCooldown = 120; // seconds
    let timerId;

  
    inputs[0].focus();
    inputs.forEach((input, idx) => {
        input.addEventListener('input', (e) => {
            const val = e.target.value.replace(/\D/g,'').slice(0,1);
            e.target.value = val;
            if (val && idx < inputs.length -1) {
                inputs[idx+1].focus();
            }
            syncHidden();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && idx > 0) {
                inputs[idx-1].focus();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text').trim();
            if (!/^\d{1,6}$/.test(paste)) return;
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].value = paste[i] || '';
            }
            syncHidden();
        });
    });

    function syncHidden() {
        let combined = Array.from(inputs).map(i => i.value).join('');
        hidden.value = combined;
    }


    document.getElementById('otp-form').addEventListener('submit', function (e) {
        syncHidden();
        if (hidden.value.length !== 6) {
            e.preventDefault();
            alert('Please enter the full 6-digit OTP.');
        }
    });

    
    resendBtn.addEventListener('click', function () {
        if (resendBtn.disabled) return;
resendBtn.disabled = true;
    resendBtn.style.pointerEvents = "none";
    timerSpan.textContent = " (Sending...)";
        fetch("{{ route('otp.resend') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                startCooldown();
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(() => alert('Failed to resend. Try again.'));
    });

    function startCooldown() {
        let remaining = resendCooldown;
        resendBtn.disabled = true;
        resendBtn.style.pointerEvents = "none";
        updateTimer(remaining);

        timerId = setInterval(() => {
            remaining--;
            updateTimer(remaining);
            if (remaining <= 0) {
                clearInterval(timerId);
                resendBtn.disabled = false;
                resendBtn.style.pointerEvents = "auto";
                timerSpan.textContent = '';
            }
        }, 1000);
    }

    function updateTimer(sec) {
        timerSpan.textContent = ` (Wait ${sec}s)`;
    }
});
</script>


  </body>
</html>
<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
                    <div class="padding_eight_all bg-white shadow rounded-4">
                        <div class="heading_s1 text-center mb-4">
                            <h3 class="mb-3">Enter Verification Code</h3>
                            <p class="text-muted">We’ve sent a code to your email</p>
                        </div>

                        <div class="form-group mb-3">
                            <label for="code" class="form-label">Verification Code</label>
                            <input id="code" type="text" class="form-control" placeholder="Enter the code">
                        </div>

<!-- Toast-like alert (custom) -->
<div id="otpToast" class="mb-3 d-none w-100" style="background-color: #dc3545; color: #fff; border-radius: 5px;">
    <div class="text-center p-2" id="toastMessage">Invalid OTP</div>
</div>



                        <div class="form-group mb-3">
                            <button onclick="verify()" type="submit" class="btn btn-fill-out btn-block w-100">Confirm</button>
                        </div>

                        <div class="text-center text-muted">
                            <small>OTP expires in <span id="countdown">5:00</span></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  function showToast(message) {
    const toastEl = document.getElementById('otpToast');
    const toastMsg = document.getElementById('toastMessage');
    toastMsg.textContent = message;
    toastEl.classList.remove('d-none');

    // Auto-hide after 2 second
    setTimeout(() => {
        toastEl.classList.add('d-none');
    }, 2000);
}


    // Countdown
    let countdownTime = 5 * 60; // 5 minutes
    const countdownDisplay = document.getElementById("countdown");
    const interval = setInterval(() => {
        const minutes = Math.floor(countdownTime / 60);
        const seconds = countdownTime % 60;
        countdownDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        countdownTime--;

        if (countdownTime < 0) {
            clearInterval(interval);
            sessionStorage.removeItem("email");
            window.location.href = "/login";
        }
    }, 1000);

    async function verify() {
        const code = document.getElementById('code').value.trim();
        const email = sessionStorage.getItem('email');

        document.getElementById('otpToast').classList.add('d-none');

        if (code.length === 0) {
            showToast("Code is required.");
            return;
        }

        try {
            $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
            let res = await axios.get(`/VerifyLogin/${email}/${code}`);
            if (res.status === 200) {
                const redirect = sessionStorage.getItem("last_location") || "/";
                window.location.href = redirect;
            } else {
                throw new Error("Invalid OTP");
            }
        } catch (error) {
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
            showToast("Wrong OTP. Please try again.");
        }
    }
</script>

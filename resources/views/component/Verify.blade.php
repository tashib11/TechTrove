<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini py-2">
    <div class="container">
        <div class="row align-items-center justify-content-center" style="min-height: 40px;">
            <div class="col-md-6 text-center">
                <ol class="breadcrumb m-0 p-0 justify-content-center">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="mx-2">/</li>
                    <li><a href="#">This Page</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>


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
                        <div id="otpToast" class="mb-3 d-none w-100"
                            style="background-color: #dc3545; color: #fff; border-radius: 5px;">
                            <div class="text-center p-2" id="toastMessage">Invalid OTP</div>
                        </div>



                        <div class="form-group mb-3">
                            <button id="verifyBtn" type="submit"
                                class="btn btn-fill-out btn-block w-100">Confirm</button>
                        </div>


                        <div class="text-center mt-3">
                            <button id="resendBtn" class="btn btn-sm btn-outline-secondary" disabled>Resend
                                Code</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // TOAST HELPER
    function showToast(message) {
        const toastEl = document.getElementById('otpToast');
        const toastMsg = document.getElementById('toastMessage');
        toastMsg.textContent = message;
        toastEl.classList.remove('d-none');
        setTimeout(() => toastEl.classList.add('d-none'), 1500);
    }

    // BUTTON LOADING STATE
    function setButtonLoading(button, isLoading) {
        if (isLoading) {
            const spinner = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
            button.setAttribute("data-original-text", button.innerHTML);
            button.innerHTML += spinner;
            button.disabled = true;
        } else {
            button.innerHTML = button.getAttribute("data-original-text");
            button.disabled = false;
        }
    }

    // BACKOFF STORAGE HANDLER
    function getResendMeta() {
        const meta = sessionStorage.getItem("resend_meta");
        return meta ? JSON.parse(meta) : { attempts: 0, lastTime: 0 };
    }

    function setResendMeta(attempts, lastTime) {
        sessionStorage.setItem("resend_meta", JSON.stringify({ attempts, lastTime }));
    }

    function clearResendMeta() {
        sessionStorage.removeItem("resend_meta");
    }

    //
    const resendBtn = document.getElementById("resendBtn");

    function startBackoffCountdown() {
        let { attempts, lastTime } = getResendMeta();
        const now = Date.now();// in milliseconds

        // On first load, initialize lastTime
        if (lastTime === 0) {
            lastTime = now;
            setResendMeta(attempts, lastTime);
        }

        const delaySeconds = Math.min(60 * Math.pow(2, attempts), 900); // 1m → 2m → … → 15m
        const delayMillis = delaySeconds * 1000;
        const unlockTime = lastTime + delayMillis;

        let remaining = Math.floor((unlockTime - now) / 1000);

        if (remaining <= 0) {
            resendBtn.disabled = false;
            resendBtn.textContent = "Resend Code";
            return;
        }

        resendBtn.disabled = true;
        resendBtn.textContent = `Resend Code in ${remaining}s`;

        const interval = setInterval(() => {
            remaining = Math.floor((unlockTime - Date.now()) / 1000);
            if (remaining <= 0) {
                clearInterval(interval);
                resendBtn.disabled = false;
                resendBtn.textContent = "Resend Code";
            } else {
                resendBtn.textContent = `Resend Code in ${remaining}s`;
            }
        }, 1000);// 1s interval to update time
    }

    // RESEND OTP
    resendBtn.addEventListener("click", async () => {
        const email = sessionStorage.getItem("email");

        if (!email) {
            showToast("Session expired. Redirecting...");
            setTimeout(() => window.location.href = "/login", 1000);
            return;
        }

        resendBtn.disabled = true;
        resendBtn.textContent = "Sending...";

        try {
            const res = await fetch(`/UserLogin/${email}`);
            if (res.status === 200) {
                showToast("OTP sent successfully.");
                const { attempts } = getResendMeta();
                setResendMeta(attempts + 1, Date.now());
                startBackoffCountdown();
            } else {
                throw new Error("Failed to resend");
            }
        } catch (err) {
            showToast("Could not resend OTP. Try again.");
            resendBtn.disabled = false;
            resendBtn.textContent = "Resend Code";
        }
    });

    // VERIFY OTP
    document.getElementById('verifyBtn').addEventListener('click', async (e) => {
        e.preventDefault();

        const btn = e.currentTarget;
        setButtonLoading(btn, true);

        const code = document.getElementById('code').value.trim();
        const email = sessionStorage.getItem('email');

        if (!code) {
            showToast("Code is required.");
            setButtonLoading(btn, false);
            return;
        }

        try {
            const res = await fetch(`/VerifyLogin/${email}/${code}`);
            if (res.status === 200) {
                clearResendMeta(); // reset backoff on success
                const redirect = sessionStorage.getItem("last_location") || "/";
                window.location.href = redirect;
            } else {
                throw new Error("Invalid OTP");
            }
        } catch {
            showToast("Wrong OTP. Try again.");
        } finally {
            setButtonLoading(btn, false);
        }
    });

    // START COUNTDOWN ON PAGE LOAD
    window.addEventListener("DOMContentLoaded", () => {
        startBackoffCountdown();
    });
</script>

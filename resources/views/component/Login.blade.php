<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini py-2">
    <div class="container">
        <div class="row align-items-center justify-content-center" style="min-height: 40px;">
            <div class="col-md-6 text-center">
                <ol class="breadcrumb m-0 p-0 justify-content-center">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="mx-2">&gt;</li>
                    <li>Login</li>
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
                            <h3 class="mb-3">Login to Your Account</h3>
                            <p class="text-muted">Enter your email address to proceed</p>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="text" class="form-control" name="email" placeholder="Enter your email">
                            <small id="emailError" class="text-danger d-none">Please enter a valid email.</small>
                        </div>

                        <div class="form-group mb-3">
                            <button id="loginBtn" type="submit" class="btn btn-fill-out btn-block w-100">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        font-weight: 500;
    }
    .btn-fill-out {
        padding: 10px 0;
        font-size: 1rem;
    }
</style>


<script>
    function isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

  document.querySelector('#loginBtn').addEventListener('click', async (e) => {
    e.preventDefault();

    const btn = e.currentTarget;
    setButtonLoading(btn, true);

    const email = document.getElementById('email').value.trim();
    const emailError = document.getElementById('emailError');
    emailError.classList.add('d-none');

    if (email.length === 0 || !isValidEmail(email)) {
        emailError.classList.remove('d-none');
        setButtonLoading(btn, false);
        return;
    }

    // Optimistically store email and redirect BEFORE waiting
    sessionStorage.setItem('email', email);
    window.location.href = "/verify";

    // Fire-and-forget request; user is already going to /verify
    fetch(`/UserLogin/${email}`)
        .then(res => {
            if (!res.ok) {
                console.error("Login initiation failed");
            }
        })
        .catch(err => {
            console.error("Login request failed", err);
        });
});



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
</script>

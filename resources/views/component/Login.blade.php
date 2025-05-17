
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
                            <button onclick="Login()" type="submit" class="btn btn-fill-out btn-block w-100">Next</button>
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

    async function Login() {
        const email = document.getElementById('email').value.trim();
        const emailError = document.getElementById('emailError');

        // Reset error visibility
        emailError.classList.add('d-none');

        if (email.length === 0 || !isValidEmail(email)) {
            emailError.textContent = "Please enter a valid email.";
            emailError.classList.remove('d-none');
            return;
        }

        try {
            $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
            let res = await axios.get("/UserLogin/" + email);
            if (res.status === 200) {
                sessionStorage.setItem('email', email);
                window.location.href = "/verify";
            } else {
                throw new Error("Login failed");
            }
        } catch (error) {
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
            emailError.textContent = "Something went wrong. Please try again.";
            emailError.classList.remove('d-none');
        }
    }
</script>

<div class="container mt-4">
    <div class="card p-4 shadow rounded">
        <h4>User Profile</h4>

        <form id="profileForm">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" class="form-control" name="cus_name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text" class="form-control" name="cus_phone" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Address</label>
                    <input type="text" class="form-control" name="cus_add" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>City</label>
                    <input type="text" class="form-control" name="cus_city" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>State</label>
                    <input type="text" class="form-control" name="cus_state" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Country</label>
                    <input type="text" class="form-control" name="cus_country" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Save Profile</button>
        </form>
    </div>
</div>

<script>
const userId = localStorage.getItem('id'); // Adjust as needed

async function ProfileDetails() {
    try {
        let res = await axios.get('/ReadProfile', {
            headers: {
                'id': userId
            }
        });

        if (res.data && res.data['data']) {
            const profile = res.data['data'];
            Object.keys(profile).forEach(key => {
                if (document.querySelector(`[name="${key}"]`)) {
                    document.querySelector(`[name="${key}"]`).value = profile[key];
                }
            });
        }
    } catch (err) {
        console.warn("Profile not found or error occurred");
    }
}

document.getElementById("profileForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    let data = {};
    formData.forEach((value, key) => data[key] = value);

    try {
        let res = await axios.post('/CreateProfile', data, {
            headers: {
                'id': userId
            }
        });

        Swal.fire({
            icon: 'success',
            title: 'Profile Saved',
            text: res.data['msg'],
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then(() => {
            let lastLocation = sessionStorage.getItem("last_location");
            if (lastLocation) {
                sessionStorage.removeItem("last_location");
                window.location.href = lastLocation;
            } else {
                window.location.href = "/"; // or dashboard/home page
            }
        });

    }  catch (err) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Error saving profile'
        });
    }
});

</script>

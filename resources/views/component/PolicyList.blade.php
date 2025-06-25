<style>
    #policy h1, #policy h2, #policy h3 {
        margin-top: 1rem;
        font-weight: 600;
    }
    #policy p {
        line-height: 1.8;
        font-size: 1rem;
        color: #333;
    }
</style>

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1><span id="policyName"></span></h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" id="breadcrumbLabel">Policy</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION BREADCRUMB -->

<!-- START SECTION POLICY CONTENT -->
<div class="my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-11">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4" id="policy">
                        {{-- <div class="text-center text-muted">Loading policy...</div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION POLICY CONTENT -->

<script>
       const searchParams = new URLSearchParams(window.location.search);
        const type = searchParams.get('type');

        const policyTitles = {
            about: "About Us",
            refund: "Refund Policy",
            terms: "Terms & Conditions",
            "how to buy": "How to Buy",
            contact: "Contact Information",
            complain: "Customer Complaint Guide"
        };

        const title = policyTitles[type] || "Policy";
        // $("#policyName").text(type);
        $("#policyName").text(title);
        $("#breadcrumbLabel").text(title);
    async function Policy(){


        try {
            const res = await axios.get("/PolicyByType/" + type);
            const des = res.data.data['des'] || "<p class='text-danger'>No  description available.</p>";
            $("#policy").html(des);
        } catch (err) {
            $("#policy").html("<p class='text-danger'>Failed to load . Please try again later.</p>");
            console.error(err);
        }
    }

</script>

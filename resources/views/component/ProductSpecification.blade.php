{{-- <!-- Insert this below the product display row (right after the closing </div> of .row) -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details-tab-pane" type="button" role="tab" aria-controls="details-tab-pane" aria-selected="true">Details</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review-tab-pane" type="button" role="tab" aria-controls="review-tab-pane" aria-selected="false">Review</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="review_create-tab" data-bs-toggle="tab" data-bs-target="#review_create-tab-pane" type="button" role="tab" aria-controls="review_create-tab-pane" aria-selected="false">Add Review</button>
                </li>
            </ul>

            <div class="tab-content pt-3" id="myTabContent">
                <!-- Product Description from backend -->
                <div class="tab-pane fade show active" id="details-tab-pane" role="tabpanel" aria-labelledby="details-tab" tabindex="0">
                    <div id="p_details"></div>
                </div>

                <!-- Customer Reviews List -->
                <div class="tab-pane fade" id="review-tab-pane" role="tabpanel" aria-labelledby="review-tab" tabindex="0">
                    <ul id="reviewList" class="list-group"></ul>
                </div>

                <!-- Add Review Form -->
                <div class="tab-pane fade" id="review_create-tab-pane" role="tabpanel" aria-labelledby="review_create-tab" tabindex="0">
                    <div class="mb-3">
                        <label for="reviewScore" class="form-label">Rating (0-100%)</label>
                        <input type="number" id="reviewScore" class="form-control" max="100" min="0" placeholder="Enter rating percentage">
                    </div>
                    <div class="mb-3">
                        <label for="reviewTextID" class="form-label">Review</label>
                        <textarea id="reviewTextID" class="form-control" rows="3" placeholder="Write your review here..."></textarea>
                    </div>
                    <button onclick="AddReview()" class="btn btn-primary">Submit Review</button>
                </div>
            </div>
        </div>
    </div>
</div> --}}

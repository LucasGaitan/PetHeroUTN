<div class="modal fade" id="reviewForm" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Owner Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo FRONT_ROOT ?>Reservation/concludedReservationForReview" method="POST" class="row g-3">
                    <label for="review">Make your Review</label>
                    <input type="hidden" name="idReservation" value="<?php echo $idReservation ?>" >
                    <input type="number" name="stars" min="1" max="5" required>
                    <textarea class="textarea" name="comment" rows="4" cols="50" maxlength="100" required></textarea>
                    <button class="btn mt-5" data-bs-dismiss="modal" aria-label="Close" style="background-color:#b41d78; color:#fff" type="sumbit">Done !</button>
                </form>
            </div>
        </div>
    </div>
</div>
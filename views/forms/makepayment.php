<div class="modal fade" id="makepayment" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-b" id="exampleModalToggleLabel">Start Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo FRONT_ROOT ?>Reservation/makePayment" class="row g-2 justify-content-center" method="post">
                    <div>
                        <p class="d-flex justify-content-center fw-bf fs-5 border-bottom pb-3">Make a payment to:  <?php echo $name; echo ' '; echo $lastName ?></p>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer01" class="form-label">Card number</label>
                        <input type="number"  class="form-control" id="validationServer01" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer01" class="form-label">Card owner name</label>
                        <input type="text"  class="form-control" id="validationServer01" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer02" class="form-label">Expiration date</label>
                        <input type="date"  class="form-control " id="validationServer02" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer01" class="form-label">CVC</label>
                        <input type="number"  class="form-control" id="validationServer01" value="" min="100" max="9999" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <input type="hidden" name="idReservation" value="<?php echo $id_reservation ?>" >
                    <div class="d-grid gap-2 col-10">
                        <button class="btn" style="background-color:#b41d78; color:#fff" type="submit">Make payment !</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmReservationForm" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Confirm Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo FRONT_ROOT ?>Reservation/ConfirmReservation" method="POST" class="row g-3">

                    <center>
                        <img src="<?php echo ASSETS_PATH ?>/undraw_booking_re_gw4j.svg" alt="" style="width: 350px">
                        <br>
                        <br>
                        <br>
                        <p>
                            Are you sure to confirm the reservation?
                        </p>
                    </center>
                    <input type="hidden" name="idReservation" value="<?php echo $idReservation?>" >
                    <div class="container">
                        <div class="row">
                            <div class="d-grid gap-2 col-6">
                                <button class="btn mt-5" style="background-color:#b41d78; color:#fff" type="submit">YES
                                </button>
                            </div>
                            <div class="d-grid gap-2 col-6">
                                <button type="button" class="btn mt-5" data-bs-dismiss="modal" aria-label="Close" style="background-color:#b41d78; color:#fff">NO
                                </button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
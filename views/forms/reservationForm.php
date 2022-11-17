<div class="modal fade" id="reservationForm" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-b" id="exampleModalToggleLabel">Create Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo FRONT_ROOT ?>Reservation/ReservationForm" class="row g-2 justify-content-center" method="post">
                    <div>
                        <p class="d-flex justify-content-center fw-bf fs-5 border-bottom pb-3">Guardian Selected <?php echo $userGuardian ?></p>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer01" class="form-label">Start date</label>
                        <input type="date" name="startDate" class="form-control" id="validationServer01" value="" max="<?php echo $endDate ?>" min="<?php echo $startDate ?>" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer02" class="form-label">End date</label>
                        <input type="date" name="endDate" class="form-control " id="validationServer02" value="" max="<?php echo $endDate ?>" min="<?php echo $startDate ?>" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div>
                        <label for="id_animal" class="form-label">Select your pet</label>
                        <select class="form-select" aria-label="Animal Type" name="id_animal" required>
                            <option value=""></option>
                            <?php
                            foreach ($myPets as $value) {
                                ?>
                                <option value="<?php echo $value->getIdAnimal() ?>"><?php echo $value->getName() ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="idGuardian" value="<?php echo $idGuardian?>" >
                    <div class="d-grid gap-2 col-10">
                        <button class="btn" style="background-color:#b41d78; color:#fff" type="submit">Make reservation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
?>

<div class="modal fade" id="postulationForm" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-b" id="exampleModalToggleLabel">Add Postulation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo FRONT_ROOT ?>Guardian/postulationForm" class="row g-2 justify-content-center" method="post">
                    <div class="col-md-6">
                        <label for="validationServer01" class="form-label">Start date</label>
                        <input type="date" name="startDate" class="form-control" id="validationServer01" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer02" class="form-label">End date</label>
                        <input type="date" name="endDate" class="form-control " id="validationServer02" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer02" class="form-label">Hours per day available</label>
                        <input type="number" name="hoursPerDay" class="form-control " id="validationServer02" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer02" class="form-label">Description</label>
                        <input maxlength="100" type="text" name="description" class="form-control " id="validationServer02" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="d-grid gap-2 col-10">
                        <button class="btn" style="background-color:#b41d78; color:#fff" type="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
?>

<div class="modal fade" id="dogForm" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-b" id="exampleModalToggleLabel">Add Dog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo FRONT_ROOT ?>Dog/dogForm" class="row g-2 justify-content-center" method="post">
                        <div class="col-md-6">
                            <label for="validationServer01" class="form-label">Name</label>
                            <input type="text" name="dogName" class="form-control" id="validationServer01" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer02" class="form-label">Age</label>
                            <input type="number" name="age" class="form-control " id="validationServer02" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select" aria-label="Dog Size" name="size">
                                <option selected>Select a dog size</option>
                                <option value="small">Small</option>
                                <option value="medium">Medium</option>
                                <option value="big">Big</option>
                            </select>
                        </div>
                    <div class="d-grid gap-2 col-10">
                        <button class="btn" style="background-color:#b41d78; color:#fff" type="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
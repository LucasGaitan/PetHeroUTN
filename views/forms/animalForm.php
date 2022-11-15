<div class="modal fade" id="animalForm" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-b" id="exampleModalToggleLabel">Add Pet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo FRONT_ROOT ?>Animal/animalForm" class="row g-2 justify-content-center"
                      method="post" enctype="multipart/form-data" >
                    <div class="col-6">
                        <label for="validationServer01" class="form-label">Name</label>
                        <input type="text" name="animalName" class="form-control" id="validationServer01" value=""
                               required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="validationServer02" class="form-label">Age</label>
                        <input type="number" name="age" class="form-control" min="0" max="25" id="validationServer02" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-6 mt-4">
                        <select class="form-select" aria-label="Animal Type" name="breed">
                            <option selected>Select animal type/breed</option>
                            <?php
                            foreach ($animalBreeds as $value) {
                                ?>
                                <option value="<?php echo $value["id_animal_breed"] ?>"><?php echo $value["animalBreeds"] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-6 mt-4">
                        <select class="form-select" aria-label="Animal Size" name="size">
                            <option selected>Select animal size</option>
                            <?php
                            foreach ($animalSizes as $value) {
                                ?>
                                <option value="<?php echo $value["id_animal_size"] ?>"><?php echo $value["size"] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="validationServer03" class="form-label">Photo</label>
                        <input accept="image/png,image/jpeg" type="file" name="photo" class="form-control "
                               id="validationServer02" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="validationServer04" class="form-label">Vaccination Plan</label>
                        <input accept="image/png,image/jpeg" type="file" name="vaccinationPlan" class="form-control "
                               id="validationServer02" value=""
                               required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="validationServer05" class="form-label">Video</label>
                        <input type="url" name="video" class="form-control " id="validationServer05" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="validationServer06" class="form-label">Observations</label>
                        <input type="text" name="observations" class="form-control " id="validationServer06" value=""
                               required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="d-grid gap-2 col-10 mt-5">
                        <button class="btn" style="background-color:#b41d78; color:#fff" type="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
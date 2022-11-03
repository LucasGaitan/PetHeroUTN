<div class="modal fade" id="guardianForm" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Guardian Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo FRONT_ROOT ?>User/guardianForm" method="POST" class="row g-3">
                    <center>
                        <img src="<?php echo ASSETS_PATH ?>/undraw_selection_re_ycpo.svg" alt="" style="width: 350px">
                    </center>
                    <div class="col-md-6">
                        <select class="form-select" aria-label="Default select example" name="dogTypeExpected">
                            <option selected>Select a dog type expected</option>
                            <option value="1">Small</option>
                            <option value="2">Medium</option>
                            <option value="3">Big</option>
                        </select>
                    </div>
                    <div class="col-md-6">

                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" name="salaryExpected" placeholder="Salary Expected">
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn mt-5" style="background-color:#b41d78; color:#fff" type="submit">Submit form
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
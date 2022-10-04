<div class="modal fade" id="ownerForm" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Owner Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo FRONT_ROOT ?>User/ownerForm" method="POST" class="row g-3">

                    <center>
                        <img src="<?php echo ASSETS_PATH ?>/undraw_confirmation_re_b6q5.svg" alt="" style="width: 350px">
                        <br>
                        <p>
                            Are you sure to become an owner?
                        </p>
                    </center>

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
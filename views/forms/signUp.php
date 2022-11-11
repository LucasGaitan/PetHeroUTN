<div class="modal fade" id="signUp" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Sign Up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  action="<?php echo FRONT_ROOT?>Auth/signUp" method="POST" class="row g-3" >
                    <div class="col-md-6">
                        <label for="validationServer01" class="form-label">First name</label>
                        <input type="text" name="firstName" class="form-control" id="validationServer01" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer02" class="form-label">Last name</label>
                        <input type="text" name="lastName" class="form-control " id="validationServer02" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="validationServerEmail" class="form-label">Email</label>
                        <div class="input-group has-validation">
                            <input type="email" name="email" class="form-control" id="validationServerEmail"
                                   aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required>
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="validationServerUsername" class="form-label">Username</label>
                        <div class="input-group has-validation">
                            <input type="text" name="username" class="form-control" id="validationServerUsername"
                                   aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required>
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                Please choose a username.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="validationServer03" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="validationServer03"
                               aria-describedby="validationServer03Feedback" required>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            Please provide a valid password.
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="validationServer03" class="form-label">Confirm Password</label>
                        <input type="password" name="password2" class="form-control" id="validationServer03"
                               aria-describedby="validationServer03Feedback" required>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            Please provide a valid password.
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn" style="background-color:#b41d78; color:#fff" type="submit">Submit form
                        </button>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <div class="row justify-content-center">
                    <p class="col-md-12 text-center">Already have an account?</p>
                    <button class="btn col-md-6 " style="background-color:#b41d78; color: #fff;"
                            data-bs-target="#signIn"
                            data-bs-toggle="modal" data-bs-dismiss="modal">Sign In
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once("./views/forms/signUp.php");
?>

<div class="modal fade" id="signIn" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
   <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalToggleLabel">Sign In</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form class="row g-3">
               <div class="col-md-12">
                  <label for="validationServerUsername" class="form-label">Username</label>
                  <div class="input-group has-validation">
                     <input type="text" class="form-control" id="validationServerUsername" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required>
                     <div id="validationServerUsernameFeedback" class="invalid-feedback">
                        Please choose a username.
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <label for="validationServer03" class="form-label">Password</label>
                  <input type="password" class="form-control" id="validationServer03" aria-describedby="validationServer03Feedback" required>
                  <div id="validationServer03Feedback" class="invalid-feedback">
                     Please provide a valid password.
                  </div>
               </div>
               <div class="d-grid gap-2">
                  <button class="btn btn-primary " type="submit">Login</button>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <div class="d-grid gap-2 col-6 mx-auto">
               <button class="btn btn-primary mt-3 mb-3" data-bs-target="#signUp" data-bs-toggle="modal" data-bs-dismiss="modal">Sign Up</button>
            </div>
         </div>
      </div>
   </div>
</div>
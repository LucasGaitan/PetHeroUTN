<div class="modal fade" id="signIn" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
   <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title fw-b" id="exampleModalToggleLabel">Sign In</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form action="<?php echo FRONT_ROOT?>Auth/signIn" class="row g-2 justify-content-center" method="post">
               <div class="col-md-10">
                  <label for="validationServerUsername" class="form-label">Username</label>
                  <div class="input-group has-validation">
                     <input type="text" name="username"  class="form-control" id="validationServerUsername"
                        aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required>
                     <div id="validationServerUsernameFeedback" class="invalid-feedback">
                        Please choose a username.
                     </div>
                  </div>
               </div>
               <div class="col-md-10">
                  <label for="validationServer03" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="validationServer03"
                     aria-describedby="validationServer03Feedback" required>
                  <div id="validationServer03Feedback" class="invalid-feedback">
                     Please provide a valid password.
                  </div>
               </div>
               <div class="d-grid gap-2 col-10">
                  <button class="btn" style="background-color:#b41d78; color:#fff" type="submit">Login</button>
               </div>
            </form>
         </div>

         <div class="modal-footer justify-content-center">
            <div class="row justify-content-center">
               <p class="col-md-12 text-center">New to Pet Hero?</p>
               <button class="btn col-md-6 " style="background-color:#b41d78; color: #fff;" data-bs-target="#signUp"
                  data-bs-toggle="modal" data-bs-dismiss="modal">Sign Up</button>
            </div>
         </div>
         
      </div>
   </div>
</div>
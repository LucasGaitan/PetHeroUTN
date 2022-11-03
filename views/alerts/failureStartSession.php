<?php
require_once(VIEWS_PATH."/forms/signUp.php");
?>

<div class="modal fade" id="failureStartSession" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-b" id="exampleModalToggleLabel">Sign In</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Incorrect username or password, please try again.</p>
            </div>
        </div>
    </div>
</div>
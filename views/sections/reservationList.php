<section class="cardsContainer">
    <?php

    require_once(VIEWS_PATH."forms/confirmReservationForm.php");

    if ($startDate !== null && $endDate !== null) {

        if($reservations != null)
        {
            foreach ($reservations as $value) {
            ?>
            <div class="reservationCard__container">

                <a href="<?php echo FRONT_ROOT ?>Reservation/reservationSelected?idReservation=<?php echo $value["id_reservation"] ?>" class="reservationCard">

                    <div class="reservationCard__content">
                           
                        <p class="reservationCard__title"><?php echo $value["ownerName"] ?></p>
                        <p class="reservationCard__animal"><?php echo $value["animalType"] ?> / <?php echo $value["animalBreed"] ?> / <?php echo $value["animalSize"] ?></p>
                        <p class="reservationCard__date"><?php echo $value["startDate"] ?> / <?php echo $value["endDate"] ?></p>

                        <?php if ($value["reservationConcluded"] == 0){ ?>
                            <p class="reservationCard__state"><?php if ($value["reservationState"] == 1) {
                             echo "Confirmed";
                        } else {
                            echo "Not Confirmed";
                        } ?></p><?php
                        }else { ?>
                            <p class="reservationCard__state"><?php if ($value["reservationConcluded"] == 1) {
                                echo "Concluded";
                            } else {
                                echo "Not Concluded";
                            } ?></p>
                        <?php } ?>

               
                    </div>
                </a>

                    <div class="reservationCard__button">
                        <a class="reservationCard__button__link" data-bs-toggle="modal" data-bs-target="#confirmReservationForm"><img class="reservationCard__button__img" src="<?php echo ASSETS_PATH?>/accept.png" alt=""></a>
                    </div>
               
            </div>
            <?php
            }?>
            <?php
        }
        else
        {
            ?>
           <p class="makeReservation__title">You have no reservations available</p>
           <?php
        }

    }else{
        ?>

        <form action="<?php echo FRONT_ROOT ?>Guardian/setWorkDates" class="workDates" method="post">
                    <p class="workDates__title">You need to update your Work Dates:</p>
                    <div class="col-6">
                        <label for="validationServer01" class="form-label">Start date</label>
                        <input type="date" name="startDate" class="form-control" id="validationServer01" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="validationServer02" class="form-label">End date</label>
                        <input type="date" name="endDate" class="form-control " id="validationServer02" value="" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-2 mt-3">
                        <button class="workDates__btn btn col-12" style="background-color:#b41d78; color:#fff" type="submit">Confirm Dates</button>
                    </div>
        </form><?php
     
    }
    ?>

    <div class="cardsContainer__corner cardsContainer__corner--1"></div>
    <div class="cardsContainer__corner cardsContainer__corner--2"></div>

</section>


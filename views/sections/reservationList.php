<?php
require_once(VIEWS_PATH."forms/confirmReservationForm.php");
use Controllers\ReservationController;

$reservationController = new ReservationController();

$reservations = $reservationController->getAllReservationsByGuardianId();
?>

<!--<form action="<?php //echo FRONT_ROOT ?>Owner/FilterDates" class="row g-2 justify-content-center"
      method="post">
    <div class="col-6">
        <label for="formFile" class="form-label">From date</label>
        <input class="form-control" name="startDate" type="date" id="formFile">
    </div>
    <div class="col-6">
        <label for="formFile" class="form-label">To date</label>
        <input class="form-control" name="endDate" type="date" id="formFile">
    </div>
    <div class="d-grid gap-2 col-10 mt-5">
        <button class="btn" style="background-color:#b41d78; color:#fff" type="submit">Filter</button>
    </div>
</form>-->

<!--<table  class="table table-bordered table-hover" id="userTable">-->
<!--    <thead>-->
<!--    <tr>-->
<!--        <th>Owner</th>-->
<!--        <th>Animal Type</th>-->
<!--        <th>Animal Breed</th>-->
<!--        <th>Animal Size</th>-->
<!--        <th colspan="2">Available between</th>-->
<!--        <th>State</th>-->
<!--        <th>Concluded</th>-->
<!--    </tr>-->
<!--    </thead>-->
<!---->
<!--    <tbody>-->
<!--    --><?php
//
//        foreach ($reservations as $value)
//        {
//            ?>
<!--                <tr >-->
<!--                   <td>--><?php //echo $value["ownerName"]?><!-- </td>-->
<!--                    <td>--><?php //echo $value["animalType"]?><!-- </td>-->
<!--                    <td>--><?php //echo $value["animalBreed"]?><!-- </td>-->
<!--                    <td>--><?php //echo $value["animalSize"]?><!-- </td>-->
<!--                    <td>--><?php //echo $value["startDate"]?><!-- </td>-->
<!--                    <td>--><?php //echo $value["endDate"]?><!-- </td>-->
<!--                    <td>--><?php //if($value["reservationState"] == 1)
//                        {
//                            echo "Confirmed";
//                        }else{
//                            echo "Not Confirmed";
//                        }?><!-- </td>-->
<!--                    <td>--><?php //if($value["reservationConcluded"] == 1)
//                        {
//                            echo "Yes";
//                        }else{
//                        echo "No";
//                        }?><!-- </td>-->
<!---->
<!---->
<!--                </tr>-->
<!--            --><?php
//        }
//    ?>
<!--    </tbody>-->
<!--</table>-->

<section class="cardsContainer">
    <?php

//    var_dump($_SESSION['user']->getStartDate());
//    var_dump($_SESSION['user']->getEndDate());
//    echo '<pre>';
//    var_dump($this->guardianDAO->bringStartAndEndDates($_SESSION['user']->getIdGuardian()));
//    echo '</pre>';

    if ($_SESSION['user']->getStartDate() !== null && $_SESSION['user']->getEndDate() !== null) {

        if($reservations != null)
        {
            foreach ($reservations as $value) {
            ?>
            <div class="reservationCard__container">

                <a href="<?php echo FRONT_ROOT ?>Reservation/reservationSelected?idReservation=<?php echo $value["id_reservation"] ?>" class="reservationCard">

                    <div class="reservationCard__content">
                           
                        <p class="reservationCard__title"><?php echo $value["ownerName"] ?></p>
                        <p class="reservationCard__animal"><?php echo $value["animalType"] ?> / <?php echo $value["animalBreed"] ?> / <?php echo $value["animalSize"] ?></p>
                        <p class="reservationCard__date"><?php echo $value["startDate"] ?> / <?php echo $value["startDate"] ?></p>

                        <p class="reservationCard__state"><?php if ($value["reservationState"] == 1) {
                             echo "Confirmed";
                        } else {
                            echo "Not Confirmed";
                        } ?></p>
               
                    </div>
                </a>

                    <div class="reservationCard__button">
                        <a href="" class="reservationCard__button__link"><img class="reservationCard__button__img" src="<?php echo ASSETS_PATH?>/trash.png" alt=""></a>
                    </div>
               
            </div>
            <?php
            }?>
            <section class="confirmReservation">
            <?php

                if (isset($idReservation)) {
            ?>
                <p class="confirmReservation__title">You selected: <span class="confirmReservation__title--name"> <?php echo $idReservation; ?> </span></p>
                <a class="confirmReservation__buttom" data-bs-toggle="modal" data-bs-target="#confirmReservation">Confirm Reservation</a><?php
                } else {
            ?>
                <p class="confirmReservation__title">You must have to select a Reservation to confirm!</p><?php
            }
    ?>
</section><?php
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
                    <p class="workDates__title">You have to update your Work Dates:</p>
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


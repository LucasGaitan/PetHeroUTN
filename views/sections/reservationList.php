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
    foreach ($reservations as $value) {
        ?>
        <div class="reservationCard__container">
            <a href="<?php echo FRONT_ROOT?>Reservation/reservationSelected?idReservation=<?php echo $value["id_reservation"] ?>"
               class="reservationCard">
                <div class="reservationCard__content">
                    <p class="reservationCard__title"><?php echo $value["ownerName"] ?></p>
                    <p class="reservationCard__title"><?php echo $value["animalType"] ?>/<?php echo $value["animalBreed"] ?>/ <?php echo $value["animalSize"]?></p>
                    <p class="reservationCard__date"><?php echo $value["startDate"] ?>
                        / <?php echo $value["startDate"] ?></p>
                    <p class="reservationCard__salary"><?php if ($value["reservationState"] == 1) {
                            echo "Confirmed";
                        } else {
                            echo "Not Confirmed";
                        } ?></p>
                    <p class="reservationCard__salary"><?php if ($value["reservationConcluded"] == 1) {
                            echo "Yes";
                        } else {
                            echo "No";
                        } ?></p>
                </div>
            </a>
        </div>
        <?php
    }
    ?>

    <div class="cardsContainer__corner cardsContainer__corner--1"></div>
    <div class="cardsContainer__corner cardsContainer__corner--2"></div>
</section>
<section class="confirmReservation">
    <?php

    if (isset($idReservation)) {
        ?>
        <p class="confirmReservation__title">You selected: <span
                    class="confirmReservation__title--name"> <?php echo $idReservation; ?> </span></p>
        <a class="confirmReservation__buttom" data-bs-toggle="modal" data-bs-target="#confirmReservation">Confirm
            Reservation</a><?php
    } else {
        ?>
        <p class="confirmReservation__title">You must have to select a Reservation to confirm!</p><?php
    }
    ?>
</section>


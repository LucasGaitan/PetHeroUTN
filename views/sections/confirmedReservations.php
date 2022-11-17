<section class="cardsContainer">
    <?php
    require_once(VIEWS_PATH."forms/makepayment.php");

    if(isset($listConfirmedReservations))
    {
        foreach ($listConfirmedReservations as $value)
        {
            ?>
            <div class="guardianCard__container">
                <a href="<?php echo FRONT_ROOT?>Reservation/confirmedReservationSelected?idReservation=<?php echo $value["id_reservation"] ?>" class="guardianCard">
                    <div class="guardianCard__content">
                        <p class="guardianCard__title"><?php echo $value["firstName"]?> <?php echo $value["lastName"] ?></p>
                        <p class="guardianCard__date"><?php echo $value["startDate"]?> / <?php echo $value["endDate"] ?></p>
                        <p class="guardianCard__salary"><?php echo "$" . $value["payment"] ?></p>
                    </div>
                </a>
            </div>
            <?php
        }
    }
    else
    {
        ?> <p class="makeReservation__title">No confirmed reservations yet</p><?php
    }
    ?>

    <div class="cardsContainer__corner cardsContainer__corner--1"></div>
    <div class="cardsContainer__corner cardsContainer__corner--2"></div>
</section>

<section class="makeReservation">
    <?php

    if(isset($selectConfirmed))
    {
        ?>
        <p class="makeReservation__title">You selected: <span class="makeReservation__title--name"> <?php echo $name; echo ' '; echo $lastName; ?> </span> </p>
        <a class="makeReservation__buttom" data-bs-toggle="modal" data-bs-target="#makepayment">Start payment</a><?php
    }else{
        ?>
        <p class="makeReservation__title">You must have to select a Confirmed Reservation!</p><?php
    }
    ?>
</section>
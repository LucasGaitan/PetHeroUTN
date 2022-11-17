<section class="cardsContainer">
    <?php
    require_once(VIEWS_PATH."forms/concludedReservationForm.php");

    if(isset($listConfirmedReservationsForConcluded))
    {
        foreach ($listConfirmedReservationsForConcluded as $value)
        {
            ?>
            <div class="guardianCard__container">
                <a href="<?php echo FRONT_ROOT?>Reservation/selectForConcludeReservation?idReservation=<?php echo $value["id_reservation"] ?>" class="guardianCard">
                    <div class="guardianCard__content">
                        <p class="guardianCard__title"><?php echo $value["firstName"]?> <?php echo $value["lastName"] ?></p>
                        <p class="guardianCard__date"><?php echo $value["startDate"]?> / <?php echo $value["endDate"] ?></p>
                    </div>
                </a>

                <div class="reservationCard__button" style="<?php if(isset($idReservation) && $value["id_reservation"] == $idReservation){ ?>display: block<?php }else{ ?>display: none<?php } ?>">
                    <a class="reservationCard__button__link" data-bs-toggle="modal" data-bs-target="#concludedReservationForm"><img class="reservationCard__button__img" src="<?php echo ASSETS_PATH?>/accept.png" alt=""></a>
                </div>

            </div>
            <?php
        }
    }
    else
    {
        ?>
        <p class="makeReservation__title">No reserves to conclude</p>
        <?php
    }
    ?>

    <div class="cardsContainer__corner cardsContainer__corner--1"></div>
    <div class="cardsContainer__corner cardsContainer__corner--2"></div>
</section>
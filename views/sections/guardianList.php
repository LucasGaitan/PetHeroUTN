<section class="filterForm">

    <form action="<?php echo FRONT_ROOT ?>Owner/FilterDates" class="row g-2 justify-content-center"
          method="post">
        <div class="d-flex col-5">
            <label for="formFile" class="form-label p-2">From:</label>
            <input class="form-control" name="startDate" type="date" id="formFile">
        </div>
        <div class="d-flex col-5">
            <label for="formFile" class="form-label p-2">To:</label>
            <input class="form-control" name="endDate" type="date" id="formFile">
        </div>
        <div class="d-flex justify-content-start align-items-center col-2">
            <button class="btn filterForm__btn" style="background-color:#b41d78; color:#fff" type="submit">Filter</button>
        </div>
    </form>

</section>

<section class="cardsContainer">
    <?php
    require_once(VIEWS_PATH."forms/reservationForm.php");
    if(isset($guardiansFiltered))
    {
        foreach ($guardiansFiltered as $value)
        {
            ?>
            <div class="guardianCard__container">
                <a href="<?php echo FRONT_ROOT?>Reservation/guardianSelected?idGuardian=<?php echo $value->getIdGuardian() ?>&userGuardian=<?php echo $value->getUsername() ?>" class="guardianCard">
                    <div class="guardianCard__content">
                        <p class="guardianCard__content__title"><?php echo $value->getFirstName()?> <?php echo $value->getLastName()?></p>
                        <p class="guardianCard__content__date"><?php echo $value->getStartDate()?> / <?php echo $value->getEndDate()?></p>
                        <p class="guardianCard__content__salary"><?php echo "$" . $value->getSalaryExpected()?></p>
                    </div>
                </a>
            </div>
            <?php
        }
    }
    else
    {
        if(isset($listGuardian))
        {
            foreach ($listGuardian as $value)
            {
                ?>
                <div class="guardianCard__container">
                    <a href="<?php echo FRONT_ROOT?>Reservation/guardianSelected?idGuardian=<?php echo $value->getIdGuardian() ?>&userGuardian=<?php echo $value->getUsername() ?>&startDate=<?php echo $value->getStartDate()?>&endDate=<?php echo $value->getEndDate()?>" class="guardianCard">
                        <div class="guardianCard__content">
                            <p class="guardianCard__title"><?php echo $value->getFirstName()?> <?php echo $value->getLastName()?></p>
                            <p class="guardianCard__date"><?php echo $value->getStartDate()?> / <?php echo $value->getEndDate()?></p>
                            <p class="guardianCard__salary"><?php echo "$" . $value->getSalaryExpected()?></p>
                        </div>
                    </a>
                </div>
                <?php
            }
        }
        else{
            ?> <p class="makeReservation__title">No guardians exist yet</p><?php
        }

    }
    ?>

    <div class="cardsContainer__corner cardsContainer__corner--1"></div>
    <div class="cardsContainer__corner cardsContainer__corner--2"></div>
</section>
<section class="makeReservation">
<?php

    if(isset($userGuardian))
    {
        ?>
        <p class="makeReservation__title">You selected: <span class="makeReservation__title--name"> <?php echo $userGuardian; ?> </span> </p>
        <a class="makeReservation__buttom" data-bs-toggle="modal" data-bs-target="#reservationForm">Start reservation</a><?php
    }else{
        ?>
        <p class="makeReservation__title">You must have to select a Guardian!</p><?php
    }
?>
</section>



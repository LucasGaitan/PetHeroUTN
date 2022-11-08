<?php

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

<table  class="table table-bordered table-hover" id="userTable">
    <thead>
    <tr>
        <th>Owner</th>
        <th>Animal Type</th>
        <th>Animal Breed</th>
        <th>Animal Size</th>
        <th colspan="2">Available between</th>
        <th>State</th>
        <th>Concluded</th>


    </tr>
    </thead>

    <tbody>
    <?php

        foreach ($reservations as $value)
        {
            ?>
                <tr >
                   <td><?php echo $value["ownerName"]?> </td>
                    <td><?php echo $value["animalType"]?> </td>
                    <td><?php echo $value["animalBreed"]?> </td>
                    <td><?php echo $value["animalSize"]?> </td>
                    <td><?php echo $value["startDate"]?> </td>
                    <td><?php echo $value["endDate"]?> </td>
                    <td><?php if($value["reservationState"] == 1)
                        {
                            echo "Confirmed";
                        }else{
                            echo "Not Confirmed";
                        }?> </td>
                    <td><?php if($value["reservationConcluded"] == 1)
                        {
                            echo "Yes";
                        }else{
                        echo "No";
                        }?> </td>


                </tr>
            <?php
        }
    ?>
    </tbody>
</table>




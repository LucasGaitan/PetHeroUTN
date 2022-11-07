<?php

require_once(VIEWS_PATH."forms/reservationForm.php");

use DAO\GuardianDAO as GuardianDAO;
use DAO\OwnerDAO as OwnerDAO;

$guardianDAO = new GuardianDAO();

$listGuardian = $guardianDAO->getAll();

?>

<form action="<?php echo FRONT_ROOT ?>Owner/FilterDates" class="row g-2 justify-content-center"
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
</form>

<table  class="table table-bordered table-hover" id="userTable">
    <thead>
    <tr>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th colspan="2">Available between</th>
        <th>Salary Expected</th>
    </tr>
    </thead>

    <tbody>
    <?php

    if(isset($guardiansFiltered))
    {
        foreach ($guardiansFiltered as $value)
        {
            ?>
            <a>
                <tr style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#reservationForm">
                    <td><a href="<?php echo FRONT_ROOT?>Reservation/guardianSelected?idGuardian=<?php echo $value->getIdGuardian() ?>&userGuardian=<?php echo $value->getUsername() ?>"><?php echo $value->getUsername()?></a></td>
                    <td><?php echo $value->getFirstName()?> </td>
                    <td><?php echo $value->getLastName()?> </td>
                    <td><?php echo $value->getStarDate()?> </td>
                    <td><?php echo $value->getEndDate()?> </td>
                    <td><?php echo $value->getSalaryExpected()?> </td>
                </tr>
            </a>
            <?php
        }
    }
    else
    {
        foreach ($listGuardian as $value)
        {
            ?>
            <a>
                <tr >
                    <td><a href="<?php echo FRONT_ROOT?>Reservation/guardianSelected?idGuardian=<?php echo $value->getIdGuardian() ?>&userGuardian=<?php echo $value->getUsername() ?>"><?php echo $value->getUsername()?></a></td>
                    <td><?php echo $value->getFirstName()?> </td>
                    <td><?php echo $value->getLastName()?> </td>
                    <td><?php echo $value->getStarDate()?> </td>
                    <td><?php echo $value->getEndDate()?> </td>
                    <td><?php echo $value->getSalaryExpected()?> </td>
                </tr>
            </a>
            <?php
        }
    }
    ?>
    </tbody>
</table>

<?php

    if(!isset($userGuardian))
    {
        echo '<p>You have not selected any user</p>';
    }
    else
    {
        echo '<p>You have selected the user: </p>'; echo $userGuardian;
        echo '<p>If you want to start a reservation click here:</p>';
        echo '<button style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#reservationForm">Start reservation</button>';

    }
?>



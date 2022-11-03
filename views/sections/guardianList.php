<?php

use DAO\GuardianDAO as GuardianDAO;

$guardianDAO = new GuardianDAO();
$listGuardian = $guardianDAO->getAll();
?>

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
    foreach ($listGuardian as $value)
    {
        ?>
        <tr>
            <td><?php echo $value->getUsername()?> </td>
            <td><?php echo $value->getFirstName()?> </td>
            <td><?php echo $value->getLastName()?> </td>
            <td><?php echo $value->getStarDate()?> </td>
            <td><?php echo $value->getEndDate()?> </td>
            <td><?php echo $value->getSalaryExpected()?> </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>



<?php

use DAO\GuardianDAO as GuardianDAO;
use DAO\OwnerDAO as OwnerDAO;

$guardianDAO = new GuardianDAO();

$listGuardian = $guardianDAO->getAll();

?>

<table  class="table table-bordered table-hover" id="userTable">
    <thead>
    <tr>
        <th>
            Username
        </th>
        <th>
            First Name
        </th>
        <th>
            Last Name
        </th>
    </tr>
    </thead>

    <tbody>
    <?php
    foreach ($listGuardian as $value)
    { ?>
        <tr>
            <td><?php echo $value->getUsername()?> </td>
            <td><?php echo $value->getFirstName()?> </td>
            <td><?php echo $value->getLastName()?> </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>



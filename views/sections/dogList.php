<?php
use DAO\OwnerDAO as OwnerDAO;

$ownerDAO = new OwnerDAO();

$listOwner = $ownerDAO->getAll();
foreach ($listOwner as $value)
{
    if ($value->getUsername() == $_SESSION['loggedUser']->getUsername()){
        $dogArray = $value->getDogs();
    }
}
?>

<table  class="table table-bordered table-hover" id="dogTable">
    <thead>
    <tr>
        <th>
            Name
        </th>
        <th>
            Age
        </th>
        <th>
            Size
        </th>
    </tr>
    </thead>

    <tbody>
    <?php
    foreach ($dogArray as $value)
    { ?>
        <tr>
            <td><?php echo $value->getName()?> </td>
            <td><?php echo $value->getAge()?> </td>
            <td><?php echo $value->getSize()?> </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>

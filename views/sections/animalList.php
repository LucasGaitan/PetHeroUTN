<?php

use DAO\OwnerDAO as OwnerDAO;
use DAO\AnimalDAO as AnimalDAO;

$ownerDAO = new OwnerDAO();

$animalDAO = new AnimalDAO();

$petArray = $ownerDAO->getPets($_SESSION["user"]->getIdOwner());

?>

<table class="table table-bordered table-hover" id="animalTable">
    <thead>
    <tr>
        <th>
            Name
        </th>
        <th>
            Age
        </th>
        <th>
            Type
        </th>
        <th>
            Breed
        </th>
        <th>
            Size
        </th>
        <th>
            Observations
        </th>
    </tr>
    </thead>

    <tbody>
    <?php
    if (isset($petArray)) {
        foreach ($petArray as $value) { ?>
            <tr>
                <td><?php echo $value->getName() ?> </td>
                <td><?php echo $value->getAge() ?> </td>
                <td><?php echo $animalDAO->getTypeById($value->getIdAnimalBreed()) ?> </td>
                <td><?php echo $animalDAO->getBreedById($value->getIdAnimalBreed()) ?> </td>
                <td><?php echo $animalDAO->getSizeById($value->getIdAnimalSize()) ?> </td>
                <td><?php echo $value->getObservations() ?> </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>

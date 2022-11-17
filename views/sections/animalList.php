<section class="container__tabla">

    <h2 class="tabla__title">My Pets</h2>

    <table class="tabla" id="animalTable">

        <thead class="tabla__head">

        <tr class="tabla__head__row">

            <th class="tabla__head__row__h tabla__head__row__h--izq">
                Name
            </th>
            <th class="tabla__head__row__h">
                Age
            </th>
            <th class="tabla__head__row__h">
                Type
            </th>
            <th class="tabla__head__row__h">
                Breed
            </th>
            <th class="tabla__head__row__h">
                Size
            </th>
            <th class="tabla__head__row__h tabla__head__row__h--obv">
                Observations
            </th>

        </tr>

        </thead>

        <tbody class="tabla__body">

        <?php if (isset($petArray)){
        foreach ($petArray as $value) { ?>
        <tr class="tabla__body__row">
            <td class="tabla__body__row__d"><?php echo $value->getName() ?> </td>
            <td class="tabla__body__row__d"><?php echo $value->getAge() ?> </td>
            <td class="tabla__body__row__d"><?php echo $value->getType() ?> </td>
            <td class="tabla__body__row__d"><?php echo $value->getBreed() ?> </td>
            <td class="tabla__body__row__d"><?php echo $value->getSize() ?> </td>
            <td class="tabla__body__row__d"><?php echo $value->getObservations() ?> </td>
        </tr>
        <?php
            }
        }
        ?>
        </tbody>
    </table>
</section>


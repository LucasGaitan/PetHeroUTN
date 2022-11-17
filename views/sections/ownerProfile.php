<section class="profile">

    <section class="profile__header">

        <div class="profile__header__imgcont">

            <img class="profile__header__img" src="<?php echo ASSETS_PATH ?>/petOwner.png" alt="">

        </div>

        <div class="profile__header__content">

            <h1 class="profile__header__content__title"><?php echo $firstName . " " . $lastName ?></h1>
            <p class="profile__header__content__subtitle">Pet Owner</p>

        </div>

        <img class="profile__header__config" src="<?php echo ASSETS_PATH ?>/config.png" alt="">

    </section>

    <section class="profile__body">

        <section class="profile__body__pets container">

            <h2 class="profile__body__pets__title">My Pets</h2>

            <div class="profile__body__pets__content row">
                <?php
                    if (isset($petArray) && count($petArray) > 0) {
                        foreach ($petArray as $value) {
                            ?>
                            <div class="profile__body__pets__card col-6 m-3">
                                <div class="profile__body__pets__card__imgCont">
                                    <img class="profile__body__pets__card__img"
                                         src="<?php echo FRONT_ROOT . UPLOADS_PATH ?>/animalPhoto/<?php echo $value->getPhoto() ?>"
                                         alt="">
                                </div>
                                <div class="profile__body__pets__card__content">
                                    <p class="profile__body__pets__card__content__name"><?php echo $value->getName() ?></p>
                                    <p class="profile__body__pets__card__content__breed"><?php echo $value->getBreed() ?></p>
                                    <p class="profile__body__pets__card__content__age&size"><?php echo $value->getAge() . "y/o" ?>
                                        / <?php echo $value->getSize() ?></p>
                                </div>
                            </div>
                            <?php
                        } ?><?php
                    } else {
                        ?> <p class="profile__body__pets__content__fail">You dont have Pets already!</p><?php
                    }
                ?>
            </div>

        </section>

        <section class="profile__body__reservations">

            <h2 class="profile__body__reservations__title">My Reservations</h2>

            <div class="profile__body__reservations__content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse repudiandae, enim tempore laboriosam
                    nam, eos in adipisci possimus animi suscipit necessitatibus alias reprehenderit non, asperiores
                    dolorem quisquam tempora quis repellendus. Saepe, ratione facilis corporis molestiae accusantium cum
                    illo labore quis sit deleniti eligendi unde assumenda adipisci obcaecati. Voluptate laudantium, nemo
                    ratione ipsam mollitia deserunt! Eos eius repellendus rerum dicta veniam accusamus in illo
                    doloremque. Fuga illum nesciunt doloribus? Asperiores laboriosam nulla possimus magnam architecto
                    totam debitis iure tenetur sint hic, officia quod molestiae voluptatibus dolor praesentium,
                    doloremque accusantium. Quia recusandae illo praesentium facilis dicta in exercitationem! Voluptatum
                    nulla ut quibusdam animi, repellendus atque velit beatae architecto quod molestias consequuntur
                    nesciunt voluptates cum maxime nisi voluptatibus. Blanditiis itaque tenetur deserunt maxime
                    obcaecati saepe! Libero cupiditate unde esse corrupti dolor omnis vel! Amet, eligendi, impedit
                    accusamus iste eaque eius omnis ab obcaecati necessitatibus sint culpa corrupti reprehenderit,
                    officiis laudantium? Fugit laboriosam voluptatibus repudiandae expedita magnam reiciendis sunt
                    temporibus nulla nostrum? Ratione, mollitia odit? Consectetur quisquam obcaecati voluptatum ullam?
                    Nihil, optio perferendis accusantium omnis repellendus hic possimus ipsam commodi quod quam iure,
                    accusamus consequuntur ab! Corrupti, quibusdam corporis incidunt eos libero vel magni non alias
                    laudantium exercitationem. Quia eligendi officiis exercitationem voluptatem velit?Lorem ipsum dolor
                    sit amet consectetur adipisicing elit. Esse repudiandae, enim tempore laboriosam nam, eos in
                    adipisci possimus animi suscipit necessitatibus alias reprehenderit non, asperiores dolorem quisquam
                    tempora quis repellendus. Saepe, ratione facilis corporis molestiae accusantium cum illo labore quis
                    sit deleniti eligendi unde assumenda adipisci obcaecati. Voluptate laudantium, nemo ratione ipsam
                    mollitia deserunt! Eos eius repellendus rerum dicta veniam accusamus in illo doloremque. Fuga illum
                    nesciunt doloribus? Asperiores laboriosam nulla possimus magnam architecto totam debitis iure
                    tenetur sint hic, officia quod molestiae voluptatibus dolor praesentium, doloremque accusantium.
                    Quia recusandae illo praesentium facilis dicta in exercitationem! Voluptatum nulla ut quibusdam
                    animi, repellendus atque velit beatae architecto quod molestias consequuntur nesciunt voluptates cum
                    maxime nisi voluptatibus. Blanditiis itaque tenetur deserunt maxime obcaecati saepe! Libero
                    cupiditate unde esse corrupti dolor omnis vel! Amet, eligendi, impedit accusamus iste eaque eius
                    omnis ab obcaecati necessitatibus sint culpa corrupti reprehenderit, officiis laudantium? Fugit
                    laboriosam voluptatibus repudiandae expedita magnam reiciendis sunt temporibus nulla nostrum?
                    Ratione, mollitia odit? Consectetur quisquam obcaecati voluptatum ullam? Nihil, optio perferendis
                    accusantium omnis repellendus hic possimus ipsam commodi quod quam iure, accusamus consequuntur ab!
                    Corrupti, quibusdam corporis incidunt eos libero vel magni non alias laudantium exercitationem. Quia
                    eligendi officiis exercitationem voluptatem velit?</p>
            </div>

        </section>

    </section>

    <div class="profile__corner profile__corner--1"></div>
    <div class="profile__corner profile__corner--2"></div>

</section>
    
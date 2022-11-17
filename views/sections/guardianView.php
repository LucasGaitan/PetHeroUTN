<!DOCTYPE html>

<html lang="en" xmlns:html="http://www.w3.org/1999/html">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital@1&display=swap" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="<?php echo ASSETS_PATH ?>/favicon.ico">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">

    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/plug-ins/f3e99a6c02/integration/bootstrap/3/dataTables.bootstrap.css%22%3E">

    <link rel="stylesheet" href="<?php echo CSS_PATH ?>/main.css">

</head>

<body>

    <main class="template">

        <section class="section__templateNav">

            <nav class="templateNav">

                <section class="templateNav__button templateNav__button--profile">
                    <img class="templateNav__icon" src="<?php echo ASSETS_PATH ?>/profile.png" alt="">
                    <a class="templateNav__link" href="<?php echo FRONT_ROOT ?>Guardian/showActionMenu?value=1">Profile</a>
                </section>

                <section class="templateNav__button">
                    <img class="templateNav__icon" src="<?php echo ASSETS_PATH ?>/ticket.png" alt="">
                    <a class="templateNav__link" href="<?php echo FRONT_ROOT ?>Guardian/showActionMenu?value=2">View Reservations</a>
                </section>

                <section class="templateNav__button templateNav__button--close">
                    <img class="templateNav__icon" src="<?php echo ASSETS_PATH ?>/close.png" alt="">
                    <a class="templateNav__link" href="<?php echo FRONT_ROOT ?>Auth/logOut">Log Out</a>
                </section>

            </nav>

        </section>

        <section class="template__content">
        
            <?php
            if (isset($alert)) { ?>
            <div class="alert alert-<?php echo $alert["type"]?>" role="alert">
                <?php echo $alert["text"]?>
            </div>
            <?php }
            if (isset($val)) {

                        switch ($val) {

                            case 1:
                                require_once(VIEWS_PATH . "sections/guardianProfile.php");
                                break;

                            case 2:
                                require_once(VIEWS_PATH . "sections/reservationList.php");
                                break;

                        }

                    }else {
                        require_once(VIEWS_PATH . "sections/guardianProfile.php");    
                    }
            ?>
        
        </section>

        <aside class="template__aside"></aside>

    </main>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10-dev/js/jquery.dataTables.js%22%3E"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/plug-ins/f3e99a6c02/integration/bootstrap/3/dataTables.bootstrap.js%22%3E"></script>
    <script src="https://kit.fontawesome.com/9682b774cb.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
</body>
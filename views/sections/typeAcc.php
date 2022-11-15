<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital@1&display=swap" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="<?php echo ASSETS_PATH?>/favicon.ico">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
    <link rel="stylesheet" href="<?php echo CSS_PATH?>/main.css">

    <title>Pet Hero | Type Acc</title>

</head>

<body>
<?php
require_once(VIEWS_PATH."forms/guardianForm.php");
require_once(VIEWS_PATH."forms/ownerForm.php");
?>

    <main class="secMain">

        <section class="secMain__container">
            <?php
        if (isset($alert)) { ?>
            <div class="alert alert-<?php echo $alert["type"] ?>" role="alert">
                <?php echo $alert["text"] ?>
            </div>
        <?php } ?>

            <section class="secMain__owner">

                <img src="<?php echo ASSETS_PATH?>/Owner.png" alt="" class="secMain__owner__image">
                <a  class="secMain__owner__link" data-bs-toggle="modal" data-bs-target="#ownerForm">Be a Owner!</a>

            </section>

            <section class="secMain__guardian">

                <img src="<?php echo ASSETS_PATH?>/guardian.png" alt="" class="secMain__guardian__image">
                <a class="secMain__guardian__link"  data-bs-toggle="modal" data-bs-target="#guardianForm">Be a Guardian!</a>

                <div class="secMain__guardian__div">
                    <p class="secMain__guardian__div--p">Make<br>Your<br>Choice</p>
                </div>

            </section>

        </section>

    </main>

</body>
<script src="https://kit.fontawesome.com/9682b774cb.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</html>
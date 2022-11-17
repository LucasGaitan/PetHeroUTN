<!DOCTYPE html>

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

  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>

<body>

<?php
require_once(VIEWS_PATH."forms/signUp.php");
require_once(VIEWS_PATH."forms/signIn.php");
?>

  <header class="header">
      <?php  if (isset($alert)) {
          ?>
          <div class="alert alert-<?php echo $alert["type"]?>" role="alert">
              <?php echo $alert["text"]?>
          </div>
      <?php } ?>


      <nav class="header__nav">

      <a href="#"><img class="header__icon" src="<?php echo ASSETS_PATH?>/dogHero.png" alt=""></a>

      <ul class="header__list">
        <li class="header__item"><a class="header__link" href="#guardians">Guardians</a></li>
        <li class="header__item"><a class="header__link" href="#owners">Owners</a></li>
        <li class="header__item"><a class="header__link" href="#reviews">Reviews</a></li>
        <li class="header__item"><a class="header__link" href="#us">About Us</a></li>
      </ul>

      <section class="header__section">

        <a class="header__signIn" data-bs-toggle="modal" data-bs-target="#signIn" >Sign In</a>
        <a class="header__signUp" data-bs-toggle="modal" data-bs-target="#signUp">Sign Up</a>

      </section>

    </nav>

    <section class="header__body">

      <section class="header__body__content" data-aos="zoom-in" data-aos-delay="500">

        <h1 class="header__title">Welcome to <br>Pet Hero!</h1>

        <div class="header__title__button">
          <a href="#" class="header__title__button--text">Be a Hero</a>
        </div>


      </section>

      <section class="header__body__img">

        <img src="<?php echo ASSETS_PATH?>/mainImage.png" alt="">

      </section>

      <svg class="header__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#b41d78" fill-opacity="1" d="M0,224L720,160L1440,32L1440,320L720,320L0,320Z"></path>
      </svg>

    </section>

    <div class="header__arrow"></div>

  </header>
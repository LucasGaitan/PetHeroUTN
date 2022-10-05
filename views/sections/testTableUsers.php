<?php
use DAO\GuardianDAO as GuardianDAO;
use DAO\OwnerDAO as OwnerDAO;

$guardianDAO = new GuardianDAO();

$listGuardian = $guardianDAO->getAll();

$ownerDAO = new OwnerDAO();

$listOwner = $ownerDAO->getAll();

$list = array_merge($listOwner, $listGuardian);

?>

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

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/plug-ins/f3e99a6c02/integration/bootstrap/3/dataTables.bootstrap.css%22%3E">

</head>

<body>

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
        foreach ($list as $value)
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



<script type="text/javascript" src="https://cdn.datatables.net/1.10-dev/js/jquery.dataTables.js%22%3E"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/f3e99a6c02/integration/bootstrap/3/dataTables.bootstrap.js%22%3E"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
</body>



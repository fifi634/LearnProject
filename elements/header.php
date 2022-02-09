<?php 
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "functions" . DIRECTORY_SEPARATOR . "menu.php";
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "functions" . DIRECTORY_SEPARATOR . "auth.php"; 
    $_SESSION ?? session_start(); //pour compteurs de vues et administration
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?? 'fifi production' ?> </title>

        <!-- Styles Boostrap / CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="<?php dirname(__DIR__) . DIRECTORY_SEPARATOR . "style.css"?>" rel="stylesheet">

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="" sizes="180x180">
        <link rel="icon" href="" sizes="32x32" type="image/png">
        <link rel="icon" href="" sizes="16x16" type="image/png">
        <link rel="manifest" href="">
        <link rel="mask-icon" href="" color="#7952b3">
        <link rel="icon" href="">
        <meta name="" content="#7952b3">
    </head>

    <!-- Menu -->
    <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <?= nav_menu('nav-link') ?>
            </ul>   
            <ul class="nav nav-pills dropdown">
                <button style="margin-left: 0.5rem" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"> <?= isset($_SESSION['user']) ? $_SESSION['user'] : "administration" ?></button>
                <div class="dropdown-menu">
                    <?php if(auth()): ?>
                        <a class="dropdown-item" href="/administration/admin.php">admin</a>
                        <a class="dropdown-item" href="/administration/logout.php">se déconnecter</a>
                    <?php else: ?>
                        <a class="dropdown-item" href="/administration/login.php">se connecter</a>
                    <?php endif ?>
                </div>
            </ul>
    </header>
    <body>
<?php 
    require_once 'elements/header.php';
    
    $aDeviner = 150;
    $error = null;
    $succes = null;
    $value = null;

    if (isset($_GET['chiffre'])) {
        if ($_GET['chiffre']>$aDeviner) {
            $error = $_GET['chiffre']." est trop grand";
        } elseif ($_GET['chiffre']<$aDeviner) {
            $error = $_GET['chiffre']." est trop petit"; 
        } else {
            $succes = "Bravo, je pensais bien au chiffre ".$aDeviner;
        }
        $value = $_GET['chiffre'];
    }
?>

<h2>Devinez le chiffre auquelle je pense ! </h2>

<?php if ($error): ?>
    <div class="alert alert-danger"><?=$error?></div>
    <?php elseif ($succes): ?>
    <div class="alert alert-success"><?=$succes?></div>
<?php endif ?>

<form action="/jeu.php" method="GET">
    <div class="form-group">
        <input type="number" class="form-control" name="chiffre" placeholder="Entrez un chiffre entre 0 et 500" value="<?= $value ?>">
        <button style="margin-top: 0.5rem" type="submit" class="btn btn-primary">Deviner</button>
    </div>
</form>


<?php require_once 'elements/footer.php'?>
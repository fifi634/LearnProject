<?php
    $title='contact';
    require_once 'elements/header.php';
    require_once 'elements/config.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'creneaux.php';

    //définie heure avec fuseau horaire
    date_default_timezone_set("Europe/Paris");
    $heure = (int)($_GET['heure'] ?? (int)date('G'));
    $jour = (int)($_GET['jour'] ?? date('N')-1);
    //définie les creneaux d'ouverture
    $creneaux = CRENEAUX[$jour];
    //Etat d'ouverture
    $ouvert = in_creneaux($heure, $creneaux);
    $color = $ouvert ? 'green' : 'red';
    ;
    
?>


<div class="row">
    <div class="col-md-8">
        <h1> Nous conctacter</h1>
        <p> 
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita cumque consequuntur, animi, nulla veniam nisi ex voluptatibus, a id hic mollitia molestiae ad similique numquam doloremque. Dolore ullam unde suscipit!
        </p>
    </div>

    <div class="col-md-4">
        <h3>Horaire d'ouvertures</h3>
        <form action="contact.php" method=GET>
            <div class="from-group">
                <?= select('jour', $jour, JOURS)?>
            </div>

            <div class="form-group">
                <input class="form-control" name="heure" type="number" min="0" max="23" value="<?=$heure?>">   
            </div>
           <BR>
            <button type="submit" class="btn btn-primary">Serons-nous ouvert ?</button>
        </form> 
        <BR> 
        <?php if ($ouvert): ?>
            <div class="alert alert-success">
                Nous seront ouvert :)
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                Nous seront fermé :(
            </div>  
        <?php endif ?>           

        <ul>
            <?php foreach (JOURS as $k => $jour):?>
                <li 
                    <?php if ($k+1 === (int)date('N')): ?>
                        style="color:<?= $color ?>">
                    <?php endif ?>
                    <strong><?= $jour ?></strong> : 
                    <?= creneaux_html(CRENEAUX[$k])?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
<?php require 'elements/footer.php'?>
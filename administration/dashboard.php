<?php
    require '../vendor/autoload.php';
    use Fifi\Counter\Dashcount;

    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'auth.php';

    $globalcounter = new Dashcount(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Compteur de vues' . DIRECTORY_SEPARATOR . "counter");
    $global = $globalcounter->gcount();

    $years = (int)date('Y');
    $selectyears = empty($_GET['years']) ? NULL : (int)$_GET['years'];
    $month = [
        '1' => 'Janvier',
        '2' => 'Février',
        '3' => 'Mars',
        '4' => 'Avril',
        '5' => 'Mai',
        '6' => 'Juin',
        '7' => 'Juillet',
        '8' => 'Août',
        '9' => 'Septembre',
        '10' => 'Octobre',
        '11' => 'Novembre',
        '12' => 'Décembre'
    ];

    $totalpage = new Dashcount(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Compteur de vues' . DIRECTORY_SEPARATOR . 'page ');
    $page = $totalpage->totalpage();
    $selectmonth = empty($_GET['month']) ? NULL : (int)$_GET['month'];
     
    //$selectmonth_letter
    if (empty($_GET['month'])) {
        $selectmonth_letter = NULL;
    } else {
        foreach($month as $k => $mois) {
            if($k === $selectmonth) {
                $selectmonth_letter = $mois;
            }
        }
    }

    $pagemonth = $globalcounter->pagemonth($selectyears, $selectmonth);
    $detailpage = $globalcounter->detailpage($selectyears, $selectmonth);
    $visitmonth = $globalcounter->visitmonth($selectyears, $selectmonth); 
    
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "elements" . DIRECTORY_SEPARATOR . "header.php";
?>


<h1>Les stats de votre site</h1>   
<div class="row">
    <div class="col-md-4 card-body">
        <div class="list-group">
            <?php for($i=0; $i<5; $i++): ?>
                <a class="list-group-item <?=$years-$i === $selectyears ?'active':'' ?>" href="dashboard.php?years=<?= $years - $i ?>">
                    <?= $years - $i ?>
                </a>
                <?php if($years - $i === $selectyears):?>
                    <div class="list-group">
                        <?php foreach($month as $j => $mois):?>
                            <a class="list-group-item <?=$j === $selectmonth ? 'active' : '' ?>" href="dashboard.php?years=<?=$selectyears?>&month=<?=$j?>">
                                <?=$mois?>
                            </a>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            <?php endfor ?>          
        </div>
    </div>
    <div class="col-md-2">
    </div>
    <div class="col-md-6 card">
        <h5>Compteurs généraux</h5>
        <div style="padding:1em">
            <p>
                Votre site compte <strong><?= $global ?></strong> visite<?php if($global>1): ?>s<?php endif ?>.
            </p>
            <p>
                <strong><?= $page ?></strong> page<?php if($page>1): ?>s<?php endif ?> on été généré<?php if($page>1): ?>s<?php endif ?>  sur votre site.
            </p>
        </div>
        <p>
            <?php if($selectmonth != NULL): ?>
                <h5>Compteur mois</h5>
                <div style="padding:1em">
                    <p>
                        Pour le mois de <strong><?= $selectmonth_letter ?> <?= $selectyears ?></strong>, il y a eu <strong><?= $pagemonth ?></strong> page<?= $pagemonth > 1 ? 's': '' ?> générée<?= $pagemonth > 1 ? 's' : '' ?> 
                    </p>
                    <p>
                        Pour le mois de <strong><?= $selectmonth_letter?> <?= $selectyears ?></strong>, il y a eu <strong><?= $visitmonth ?></strong> visiteur<?= $visitmonth > 1 ? 's' : '' ?>
                    </p>
                </div>
                <?php if(!empty($detailpage)): ?>
                    <table class="table">
                        <thread>
                            <th>Jour</th>
                            <th>Pages générées</th>
                        </thread>
                        <tbody>
                            <?php foreach($detailpage as $detail): ?>
                            <tr>
                                <td><?= $detail['day'] ?></td>
                                <td><?= $detail['visits'] ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="margin:auto">
                        <strong>Aucune visite</strong>
                    </p>           
                <?php endif ?>
            <?php else: ?>
                <p>
                   Selectionner une année et un mois pour connaître le nombre de pages générées et le nombre de visiteurs pour le mois séléctionné.     
                </p>
            <?php endif ?>
        </p>
    </div>
</div>


<? require_once __DIR__ . DIRECTORY_SEPARATOR . "elements" . DIRECTORY_SEPARATOR . "footer.php" ?>
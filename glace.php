<?php
    require 'vendor/autoload.php';
    use Fifi\Form;

    $title = 'la glace';
    require_once 'elements/header.php'; 
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Form.php';


    //Checkbox
    $parfums = [    
        'Fraise' => 4,
        'Chocolat' => 5,
        'Vanille' => 3
    ];
    //Radio
    $glaces = [
        'Pot' => 2,
        'Cornet' => 3
    ];
    //Checkbox
    $extras = [
        'Pépite de chocolat' => 1,
        'Chantilly' => 0.5
    ];

    // Edition facture
    $total = 0;
    $ingredient = [];
    foreach (['parfum', 'glace', 'extra'] as $name) {
        if (isset($_GET[$name])) {
            $list = $name . 's';
            $choice = $_GET[$name];
            if (is_array($choice)) {
                foreach($choice as $value) {
                    $ingredient[] = $value;
                    $total += $$list[$value];
                }
            }
        }
    } 
?>
<div class="row">
    <div class="col-md-4">
        <div class="card-body">
            <div class="card-title">Composition de votre glace</div>
            <ul>
                <?php foreach ($ingredient as $item):?>
                <li><?=$item?></li> 
                <?php endforeach?>
            </ul>
            <br>
            <p> <strong>Votre glace coûtera : </strong><?=$total?>€</p>
        </div>
    </div>
    <div class="col-md-8">
        <h3>Veuillez composer votre glace :</h3>
        <br/>
        <form action="/glace.php" method="GET">
            <h6>Quel(s) sera(ont) vo(s)tre parfum(s)?</h6>
            <?php foreach($parfums as $value => $price): ?>
                <div class=checkbox>
                    <label>
                        <?= Form::checkbox('parfum', $value, $_GET) ?>
                        <?= $value ?> : <?= $price ?>€
                    </label>
                </div>
            <?php endforeach ?>
            <br>
            <h6>Comment voulez-vous votre glace ?</h6>
            <?php foreach($glaces as $value => $price): ?>
                <div class=radio>
                    <label>
                        <?= Form::radio('glace', $value, $_GET) ?>
                        <?= $value ?> : <?= $price ?>€
                    </label>
                </div>
            <?php endforeach ?>
            <br>
            <h6>Voulez-vous un p'tit supplément ?</h6>
            <?php foreach($extras as $value => $price): ?>
                <div class=checkbox>
                    <label>
                        <?= Form::checkbox('extra', $value, $_GET) ?>
                        <?= $value ?> : <?= $price ?>€
                    </label>
                </div>
            <?php endforeach ?>
            <br>
            <div>
                <button type='submit' class="btn btn-primary">voir le prix</button>
                <button type="reset" class="btn btn-secondary" onclick="location.href='/glace.php'" >recommencer</button>
            </div>  
        </form>
    </div>
</div>

<?php require_once 'elements/footer.php'?>
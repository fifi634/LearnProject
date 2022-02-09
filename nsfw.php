<?php
    $age = NULL;
    //DESTRUCTION DU COOKIE
    if(isset($_GET['action']) && $_GET['action'] === 'killcookie') 
    {
        $age = null;
        if(isset($_POST['yborn'])) 
        {
            $_POST['yborn'] = null;
        }
    }

    //CALCUL DE L'AGE
    if(isset($_POST['yborn'])) {
        $birthday = (int)$_POST['yborn'];
        $age = (int)date('Y') - $birthday;
    }
    require_once "elements/header.php";
?>

<h1>Not Safe For Work</h1>
<p>
    Vous vous apprétez à voir une image de Q. En quelle année êtes-vous né(e) ? 
</p>
<div class="row form-group">
    <div class="col-md-4">
        <form action="nsfw.php" method="post">
            <input type=number class="form-control" name="yborn" min="1919" max=2010 placeholder="Entrer votre années de naissance" value="<?php if(isset($_POST['yborn'])):?><?= $_POST['yborn']?><?php endif ?>">       
    </div>
    <div class="col">
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form> <!-- Ok, c'est pas fou comment c'est écrit mais j'ai pas mieux pour mettre le bouton envoyer à côté du formulaire -->
    </div>
    <div class="col">
        <a href="nsfw.php?action=killcookie">Je suis un ouf et je retente ma chance.</a>
    </div>
</div>

<?php if(isset($age) && $age < 18):?>
    <?= '<br><div class="alert alert-danger">Tu as '.$age.' ans, retournes chez ta mère !</div>'?>
<?php elseif($age === NULL) :?>
    <?= " " ?>
<?php elseif(isset($age) && isset($_SESSION['age']) && $age === (int)$_SESSION['age'] && $age > 18): ?>
    <?= '<br><div class="alert alert-success">Tu as '.$age.' ans. Eclates-toi !</div>'?>
    <?= '<img src="/data/image-de-q.jpg" alt="image de la lettre Q">'?>
<?php elseif(isset($age) && !isset($_SESSION['age'])): ?>
    <?= '<br><div class="alert alert-danger">Il faut créer un compte ou vous connecter pour vérifier votre majorité.</div>'?>
<?php elseif(isset($age) && $age != $_SESSION['age']): ?>
    <?= '<br><div class="alert alert-danger">Votre âge ne correspond pas avec les informations que nous avons sur votre compte.</div>'?>
<?php endif ?>

<?php require_once 'elements/footer.php'?>
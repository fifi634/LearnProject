<?php
    $title='la news letter';
    require 'elements/header.php';

    //masquer le formulaire newsletter du footer
    $noform = true;

    $email = (string)NULL;
    $valids = [];
    $link = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . "Mailing List" . DIRECTORY_SEPARATOR . date('Y-m-d') . ".txt";
    $list = fopen($link, 'a+');
    
    if (isset($_POST["email"])) {
        $email = implode($_POST["email"]);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            $valids[] = $email;
            fwrite($list, $email.PHP_EOL);
            echo "<div class='alert alert-success'>T'es inscrits, tu vas recevoir beaucoup trop de mail ".$email.", déso </div>";
        }
    }
?>

<h1>S'inscrire à la news letter</h1>
<p>
    Envies de recevoir toutes nos nouveautés pas mail ?<br/>
    Ne vous inquiétez pas, on vous envoie uniquement une vingtaines de mails par jour ;)
 </p>

<form action="newsletter.php" method="POST">
    <div class="form-group row">
        <div class="col-md-4">
            <h3>Entrez votre e-mail:</h3>
        </div>
        <div class="col-md-6">
            <input type="email" class="form-control" name="email[]">
            <br>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
            <button type="reset" class="btn btn-secondary" onclick="location.href='/newsletter.php'">Recommencer</button>
        </div>
    </div>
</form>

<?php require_once 'elements/footer.php'?>

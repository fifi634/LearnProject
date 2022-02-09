<?php
    include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'header.php';
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'auth.php';
    
    $error = NULL;

    //vérif si deja connecter
    if(auth()) 
    {
        header('Location: /administration/admin.php');
        exit('loged, redirection failed');
    }

    //OUVERTURE BASE DE DONNEE
    $pdo = new PDO('sqlite:../data/user.db', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    if(isset($_POST['nickname']))
    {
        $logid = htmlentities($_POST['nickname']);
        $logpass = htmlentities($_POST['pass']);

        try 
        {
            //RECUPERATION DU LOG UTILISATEUR DE LA BASE DE DONNEE
            $query = $pdo->prepare('SELECT * FROM user  WHERE nickname = ? ');
            $query->execute([$logid]);
            $user = $query->fetch();

            //vérif id
            if($user && password_verify($logpass, $user['pass'])) 
            {
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $user['id'];
                $_SESSION['success'] = null;
                $_SESSION['age'] = $user['age'];
                $_SESSION['user'] = $user['nickname'];
                header('Location: /administration/admin.php');
                exit('login ok, redirection failed');
            } 
            else
            {
                $error = 'Identifiant ou mot de passe incorrect';
            }
        }
        catch(PDOException $e)
        {
            $error = $e->getMessage();
        }
    }

    //message d'erreur si formulaire vide
    if(empty($_POST['nickname']) || empty($_POST['pass'])) 
    {
        $error = 'Avez-vous un compte ?';
    }    
?>

<?php if($error): ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php endif ?>

<h1>Connexion</h1>
    <div class="row form-group">
        <form action="" method="post">
            <input style="margin: 1em" class="form-control" type="text" name="nickname"  placeholder="entrez votre pseudonyme" required>
            <input style="margin: 1em" classs="form-control" type="password" name="pass" placeholder="tapez votre mot de passe" required >
            <br>
            <button style="margin: 1em" type="submit" class="btn btn-primary">se connecter</button>
        </form>
    </div>
    <a style="margin:1em" href="/administration/registration.php">créer un compte</a>

<?php require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'footer.php' ?>

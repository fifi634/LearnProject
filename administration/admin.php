<?php     
    include_once '../elements/header.php';

    $error = null;
    $success = null;

    //DECONNEXION
    if (isset($_GET['action']) && $_GET['action'] === 'deco') 
    {
        unset($_COOKIE['user']);
        setcookie('user', '', time()-30);
        header('Location: /administration/logout.php');
        exit();
    }

    //MODIFIER LE COMPTE
    if(isset($_GET['action']) && $_GET['action'] === 'modif')
    {
        header('Location: /administration/registration.php');
        exit();
    }

    //OUVERTURE BASE DE DONNEE
    $pdo = new PDO('sqlite:../data/user.db', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);

    //SUPPRIMER LE COMPTE
    if(isset($_SESSION['id']) && isset($_GET['action']) && $_GET['action'] === 'suppr')
    {
        $query = $pdo->prepare('DELETE FROM user WHERE id= :id');
        $query->execute([
            'id' => $_SESSION['id']
        ]);
        header('Location: /administration/logout.php');
        exit('user deleted, redirection and deconection failed');
    }

    //AFFICHAGE PUIS RESET MESSAGE SUCCCES
    if($_SESSION['success'] != null)
    {
        $success = $_SESSION['success'];
        $_SESSION['success'] = null;
    }    

    try
    {
        //RECUP DONNEE UTILISTAEUR POUR AFFICHAGE
        if(isset($_SESSION['id']))
        {
            $query = $pdo->prepare('SELECT * FROM user WHERE id= :id');
            $query->execute([
                'id' => $_SESSION['id']
                ]);
            $user = $query->fetch();
            $profil = [
                'nickname' => $user->nickname,
                'name' => $user->name,
                'firstname' => $user->firstname,
                'age' => $user->age,
            ];
        }
    }
    catch(PDOException $e)
    {
        $error = $e->getMessage();
    }
?>

<!-- Message d'Erreur -->
<?php if($error): ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php endif ?>

<!-- Message de succès -->
<?php if($success): ?>
    <div class="alert alert-success">
        <?= $success ?>
    </div>
<?php endif ?>

<!-- FORMULAIRE OU AFFICHE DONNEES UTILISATEUR -->
<?php if (isset($profil)):?>
    <h1>Bonjour <?= $profil['nickname'] ?></h1>
    <a style="border-right : 1px solid #000000, " href="admin.php?action=deco">Se déconnecter</a>
    <a class="text-secondary" href="admin.php?action=modif">Modifier le compte</a>
    <a class="text-danger" href="admin.php?action=suppr">Supprimer le compte</a>
    <br><br>
    <h4>Votre profil :</h4>
    <p>
        <strong>Pseudo</strong> : <?= $profil['nickname'] ?><br>
        <strong>Nom : </strong> <?= $profil['name'] ?><br>
        <strong>Prénom : </strong> <?= $profil['firstname'] ?><br>
        <strong>Age : </strong> <?= $profil['age'] ?>
    </p>
    <a href="/administration/dashboard.php">Voir les statistiques</a>
<?php else: ?>
    <?php header('Location: /administration/login.php') ?>
<?php endif ?>

<?php include_once '../elements/footer.php'?>
<?php     
    include_once '../elements/header.php';

    $error = null;

    //OUVERTURE BASE DE DONNEE
    $pdo = new PDO('sqlite:../data/user.db', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
    
        try 
        {
            //creation utilisateur dans BASE DE DONNEE
            if(isset($_POST['create']))
            {
                $query = $pdo->prepare('INSERT INTO user (nickname, name, firstname, age, pass) VALUES (:nickname, :name, :firstname, :age, :pass)');
                $query->execute([
                    'nickname' => (string)htmlentities($_POST['nickname']),
                    'name' => (string)htmlentities($_POST['name']),
                    'firstname' => (string)htmlentities($_POST['firstname']),
                    'age' => (int)htmlentities($_POST['age']),
                    'pass' => password_hash(htmlentities($_POST['pass']), PASSWORD_DEFAULT, ['cost' => 14])
                ]);

                //CREATION SESSION
                $query = $pdo->prepare('SELECT * FROM user WHERE id= :id');
                $query->execute([
                    'id' => $pdo->lastInsertId()
                ]);
                $user = $query->fetch();
                $_SESSION['age'] = $user->age;
                $_SESSION['id'] = $user->id;
                $_SESSION['auth'] = true;

                //REDIRECTION CAR OK
                $_SESSION['success'] = 'compte créé';
                header('Location: /administration/admin.php');
                exit('used create, redirection failed');            
            } 

            //MODIF DONNEE UTILISATEUR
            if(isset($_POST['modif']))
            {
                $query = $pdo->prepare('UPDATE user SET nickname = :nickname, name = :name, firstname = :firstname, age = :age, pass = :pass WHERE id = :id');
                $query->execute([
                    'nickname' => htmlentities($_POST['nickname']),
                    'name' => (string)htmlentities($_POST['name']),
                    'firstname' => (string)htmlentities($_POST['firstname']),
                    'age' => (int)htmlentities($_POST['age']),
                    'pass' => password_hash(htmlentities($_POST['pass']), PASSWORD_DEFAULT, ['cost' => 14]),
                    'id' => (int)$_SESSION['id']
                ]);

                //REDIRECTION CAR OK
                $_SESSION['success'] = "compte modifié";
                header('Location: /administration/admin.php');
                exit('modif ok, redirection failed');    
            }   

            //RECUP DONNEE UTILISTAEUR POUR MODIF
            if(isset($_SESSION['id']))
            {
                $query = $pdo->prepare('SELECT * FROM user WHERE id= :id');
                $query->execute([
                    'id' => $_SESSION['id']
                    ]);
                $user = $query->fetch();
                $_POST = [
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

<!-- messages d'alerte -->
<?php if($error): ?>
        <div class="alert alert-danger">
            Il y a un problème, veuillez transmettre ce message à votre webmaster : <br> <?= $error ?>
        </div>
<?php endif ?>

<!-- FORMULAIRE CREATION/MODIF COMPTE -->
<h1>Profil</h1>
<div class='row form-group'>
    <form action='' method='POST'>
        <h4>Pseudo : </h4>
        <input type=text class='form-control' name='nickname' placeholder='Entrer votre pseudo' value='<?php if(isset($_POST['nickname'])):?><?= $_POST['nickname']?><?php endif ?>' required>
        <h4>Nom</h4>
        <input type=text class='form-control' name='name' placeholder='Entrer votre nom' value='<?php if(isset($_POST['name'])):?><?= $_POST['name']?><?php endif ?>'>
        <h4>Prénom</h4>
        <input type='text' class='form-control' name='firstname' placeholder='Entrer votre prénom' value='<?php if(isset($_POST['firstname'])):?><?= $_POST['firstname']?><?php endif?>'>
        <h4>Age</h4>
        <input type='number' class='form-control' name='age' placeholder='Entrer votre âge' value='<?php if(isset($_POST['age'])):?><?=$_POST['age']?><?php endif ?>' required>
        <br>
        <h4>Mot de passe</h4>
        <input type='password' class="form-control" name='pass' placeholder='tapez votre mot de passe' required>
        <br>
        <?php if(isset($_SESSION['id'])): ?>
            <button type='submit' name="modif" class='btn btn-primary'>Modifier</button>
        <?php else: ?>
            <button type='submit' name="create" class='btn btn-primary'>Créer</button>   
        <?php endif ?>  
    </form>
</div>

<? include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'footer.php'?>
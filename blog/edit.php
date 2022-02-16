<?php 
    $pdo = new PDO('sqlite:../data/dataBlog.db', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
    $error = null;
    $success = null;

    try 
    {
        //modification article
        if(isset($_POST['name'], $_POST['content']))
        {
            $query = $pdo->prepare('UPDATE posts SET name= :name, content= :content WHERE id= :id');
            $query->execute([
                'name' => $_POST['name'],
                'content' => $_POST['content'],
                'id' => $_GET['id']
            ]);
            $success = 'Votre article à bien été modifié';
        }
        //suppression article
        if(isset($_POST['delete']))
        {
            $query = $pdo->prepare('DELETE FROM posts WHERE id= :id');
            $query->execute([
                'id' => $_GET['id']
            ]);
            header('Location: /blog');
            exit('Article supprimé');
        }
        //affichage article
        $query = $pdo->prepare('SELECT * FROM posts WHERE id= :id');
        $query->execute([
            'id' => $_GET['id']
        ]);
        $post = $query->fetch();
    } catch(PDOException $e)
    {
        $error = $e->getMessage();
    }

    $title = "Le blog - édition";
    require '../elements/header.php'; 
?>

<div class="container">
    <!-- messages d'alerte -->
    <?php if($success): ?>
        <div class="alert alert-success">
            <?= $success ?>
        </div>
    <?php endif ?>
    <?php if($error): ?>
        <div class="alert alert-danger">
            Il y a un problème, veuillez transmettre ce message à votre webmaster : <?= $error ?>
        </div>
    <?php endif ?>
    <!-- formulaire d'édition article -->
    <div style="margin-bottom: 2em;">
        <h3>Edition de l'article</h3>
        <a href="/blog/blog.php">Annuler les modifications / Revenir au blog</a>
    </div>

    <form action="" method="POST">
        <div class="form-group" style="margin-bottom: 0.5rem">
            <input type="text" class="form-control" name="name" value="<?= htmlentities($post->name) ?>">
        </div>
        <div class="form-group" style="margin-bottom: 0.5rem">
            <textarea name="content" cols="30" rows="10" class="form-control"><?= $post->content ?></textarea>
        </div>
        <button class="btn btn-primary">Sauvgarder</button>
        <button class="btn btn-danger" name="delete">Supprimer</button>
    </form>

</div>

<?php require '../elements/footer.php'; ?>  
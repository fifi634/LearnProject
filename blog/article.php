<?php 
    require_once '../class/blog/Post.php';
    require_once '../class/blog/Opendata.php';

    $pdo = new PDO('sqlite:../data/dataBlog.db', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);

    $error = null;

    try 
    {
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

    $title = "Le blog";
    require '../elements/header.php'; 
?>

<div class="container">
    <!-- messages d'alerte -->
    <?php if($error): ?>
        <div class="alert alert-danger">
            Il y a un problème, veuillez transmettre ce message à votre webmaster : <br> <?= $error ?>
        </div>
    <?php else: ?>
        <!-- affichage de l'article -->
        <h3><?= $post->name ?></h3>
        <p class="small text-muted">Ecrit le <?= date('d/m/y à H:i', $post->created_at) ?></p>
        <p>
            <a href="/blog/blog.php">Revenir au listing</a>
            <a href="/blog/edit.php?id=<?= $post->id ?>" class="text-muted">modifier l'article</a>
        </p>
        <p><?= nl2br(htmlentities($post->content)) ?></p>
    <?php endif ?>
</div>

<?php require '../elements/footer.php' ?>  
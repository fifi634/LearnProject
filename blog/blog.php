<?php 
    require '../vendor/autoload.php';
    use Fifi\Blog\Post;

    /* test ouverture database par class :
    use Fifi\Blog\Opendata;
    $pdo = new Opendata('../data/dataBlog.db');
    $pdo = $pdo->getPDO();*/

    $pdo = new PDO('sqlite:../data/dataBlog.db', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);

    $error = null;

    try 
    {
        if(isset($_POST['name'], $_POST['content']))
        {
            $query = $pdo->prepare('INSERT INTO posts (name, content, created_at) VALUES (:name, :content, :created)');
            $query->execute([
                'name' => $_POST['name'],
                'content' => $_POST['content'],
                'created' => time(),
            ]);
            header('Location: /blog/edit.php?id=' . $pdo->lastInsertId());
            exit();
        }
        $query = $pdo->query('SELECT * FROM posts');
        /** @var Post[] : cette variable est un tableau d'article */
        $posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class); //Post::class pour utiliser Post en chaine de caractère pour namespace
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
        <!-- aperçus d'article -->
        <h3>Extrait de vos articles :</h3>
        <ul>
            <?php foreach($posts as $post): ?>
                <h4><a href="/blog/article.php?id=<?= $post->id ?>"><?= htmlentities($post->name) ?></a></h4>
                <div class="small text-muted">
                    Ecrit le <?= $post->created_at->format('d/m/Y à H:i')?>
                </div>
                <a href="/blog/edit.php?id=<?= $post->id ?>" class="text-muted">modifier l'article</a>
                <p>
                    
                </p>
                <p>
                    <!-- récupére 150 caractères par article -->
                    <?= nl2br(htmlentities($post->getExcerpt())) ?>
                </p>
                <hr>
            <?php endforeach ?>
        </ul>
        <!-- création d'article -->
        <h3>Nouvelle article :</h3>
        <form action="" method="POST">
            <div class="form-group" style="margin-bottom: 0.5rem">
                <input type="text" class="form-control" name="name" placeholder="<?php if(empty($_POST['name'])): ?><?= 'Ecrivez votre titre' ?><?php else: ?><?= htmlentities($_POST['name']) ?><?php endif ?>">
            </div>
            <div class="form-group" style="margin-bottom: 0.5rem">
                <textarea name="content" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <button class="btn btn-primary">Sauvgarder</button>
        </form>
    <?php endif ?>
</div>

<?php require '../elements/footer.php' ?>  
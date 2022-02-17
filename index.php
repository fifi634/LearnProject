<?php
    //Météo
    declare(strict_types=1);
    require 'vendor/autoload.php';
    use \Fifi\Exceptions\{
        CurlException,
        HTTPException};
    use Fifi\OpenWeather;

    $error = null;
    $weather = new OpenWeather('10a0d52e9d44e34de519064bcf7ee006');
    try 
    {
        $forecast = $weather->getForecast('42.7057991028','3.0085299015');
        $today = $weather->getToday('42.7057991028','3.0085299015');
    } 
    catch (CurlException $e) 
    {
        exit($e->getMessage()); 
    } 
    catch (HTTPException | Error $e) 
    {
        $error = $e->getCode() . ' :  ' . $e->getMessage(); 
    }

    $title = "Les betas de fifi";
    require 'elements/header.php';
?>

<div class="container">
    <div class="row row justify-content-center">          
        <div class="col-md-8">
            <h1>Bienvenue sur le site des "betas" de fifi</h1>
            <p>
            Bonjour, je m'appelle Philippe et je suis en plein apprentissage du code informatique. Je me sers de se site comme un support. Bientôt je pourrai vous régaler en PHP, JavaScript, Saas, MySQL ...  <br> 
            </p>
            <p>
                Ce site est mon labaratoire, mon site-école. Vous y trouverez des fonctionnalités que je développe au cours de mon apprentissage.<br>
            </p>
            <p>
                Bonne visite :)
            </p>
        </div>

        <aside class="col-md-4 card">
            <?php if($error): ?>
                <div class="alert alert-danger">    
                    <?= "Il y a un problème avec l'API de la météo, merci de transmettre ce message à votre webmaster : <br>" . $error ?>
                </div>
            <?php else: ?>
                <div class="container">
                    <h3>La météo à<br> Canet-en-Roussillon</h3>
                    <ul>
                        <li>En ce moment : <?= $today['description'] ?>, <?= $today['temp']?>°c</li>
                        <?php foreach($forecast as $day): ?>
                            <li><?= $day['date']->format('d/m/Y') ?> : <?= $day['description'] ?>, <?= $day['temp']?>°c</li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>
        </aside>
    </div>
</div>

<?php require 'elements/footer.php' ?>
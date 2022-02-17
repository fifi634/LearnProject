<?php
    declare(strict_types=1);
    require 'vendor/autoload.php';

    use Fifi\Exceptions\{
        CurlException,
        HTTPException
    };
    use Fifi\OpenWeather;

    $error = null;
    $weather = new OpenWeather('10a0d52e9d44e34de519064bcf7ee006');

    try 
    {
        $forecast = $weather->getForecast('42.7057991028','3.0085299015');
        $today = $weather->getToday('42.7057991028','3.0085299015');
    } catch (CurlException $e) {
        exit($e->getMessage()); 
    } catch (HTTPException | Error $e) {
        $error = $e->getCode() . ' :  ' . $e->getMessage(); 
    }
    
    $title = "Météo";    
    require '../elements/header.php';
?>

<?php if($error): ?>
    <div class="alert alert-danger">    
        <?= 'Il y a un problème, merci de transmettre ce message à votre webmaster : <br>' . $error ?>
    </div>
<?php else: ?>
    <div class="container">
        <h1>Canet-en-Roussillon</h1>
        <ul>
        <li>En ce moment : <?= $today['description'] ?>, <?= $today['temp']?>°c</li>
            <?php foreach($forecast as $day): ?>
                <li><?= $day['date']->format('d/m/Y') ?> : <?= $day['description'] ?>, <?= $day['temp']?>°c</li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<?php require '../elements/footer.php' ?>
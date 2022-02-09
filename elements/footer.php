    </body>

    <?php 
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'menu.php';
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'counter' . DIRECTORY_SEPARATOR . 'Counter.php';
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'counter' . DIRECTORY_SEPARATOR . 'Dashcount.php';
    ?>

    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <div class="row">
                    <!-- Statistiques -->
                    <?php
                        //Compteur pages vue par jour
                        $daycount = new Counter(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Compteur de vues' . DIRECTORY_SEPARATOR . "page " . date('Y-m-d'));
                        $daycount->increment();
                        $vues = $daycount->recover();

                        //compteur journalier pour dashboard
                        $daystat = new Dashcount(dirname(__DIR__) . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "Compteur de vues" . DIRECTORY_SEPARATOR . "stat ". date('Y-m-d'));
                        $daystat->daystat();

                        //compteur visiteurs par session (1 visite pour tout le site)
                        $globalcount = new Dashcount($link = dirname(__DIR__) . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "Compteur de vues" . DIRECTORY_SEPARATOR . "counter");
                        $globalcount->gcount();  
                        $visit = $globalcount->recover();                        
                    ?>
                    <p>
                        Il y a eu <strong><?=$visit?></strong> visiteur<?php if($visit > 1):?>s<?php endif ?> sur ce site.
                    </p>
                    <p>
                        Aujourd'hui, <strong><?= $vues ?></strong> page<?php if($vues > 1):?>s<?php endif ?> ont été vue.
                    </p>
                    <span class="text-muted">&copy; 2021 la fifi production</span>
                </div>
            </div>
            <!-- newsletter -->
            <div class="row">
                <?php if(!isset($noform)):?>
                    <div class="col-md-6">
                        <form action="newsletter.php" method="POST" class='form-inline'>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email[]" placeholder="Entrer votre mail" required>
                                <br>
                                <button type="submit" class="btn btn-primary">s'inscrire à la newsletter</button>
                            </div>
                        </form>
                    </div>
                <?php endif ?>
                <!-- Footer Navigation --> 
                <div class="col">
                    <h5>Navigation</h5>
                    <ul class= "list-unstyled text-small">
                        <?= nav_menu ();?>
                    </ul>
                </div>
            </div>
            <!-- bootstrap -->
            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"/></svg></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"/></svg></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"/></svg></a></li>
            </ul>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
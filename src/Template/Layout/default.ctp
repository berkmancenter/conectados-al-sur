<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conectados al Sur</title>
    
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('foundation/foundation.min.css') ?>
    <?= $this->Html->css('app.css') ?>

    
    <!-- 
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    -->
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar" role="navigation">
        <div class="top-bar-title">
            <span data-responsive-toggle="responsive-menu" data-hide-for="medium">  
                <button class="menu-icon light" type="button" data-toggle></button>
            </span>
            <!-- <h1><a href=""><?= $this->fetch('title') ?></a></h1> -->
            <strong class="top-bar-actual-title">Conectados al Sur</strong>
        </div>
        <div id="responsive-menu">
            <div class="top-bar-left">
            </div>
            <div class="top-bar-right">
                <ul class="dropdown menu" data-dropdown-menu>
                    <li>
                        <a href="#">Actions</a>
                        <ul class="menu vertical">
                            <?= $this->fetch('available-actions') ?>
                        </ul>
                    </li>
                    <li><a href="#">Conectado como Tester</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <?= $this->Flash->render() ?>
    <div class="row fullwidth page-content ">
    <?= $this->fetch('content') ?>
    </div>
    
    <footer>
        <div class="row fullwidth">
            <div class="small-12 columns footer-imgdiv">
                <?= 
                $this->Html->image('LOGO_CAS_ALPHA.png',
                [
                    "alt" => "LOGO_CAS",
                    "width" => 300,
                    "class" => "footer-image"
                ])?>
            </div>
        </div>
        <div class="row fullwidth">
            <div class="small-12 columns footer-infodiv">
                <ul class="menu">
                    <li><a href="#">LEGAL</a></li>
                    <li><a href="#">CONTACT</a></li>
                    <li><a href="#">Social Networks</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <?= $this->Html->script('foundation/jquery.js') ?>
    <?= $this->Html->script('foundation/what-input.js') ?>
    <?= $this->Html->script('foundation/foundation.min.js') ?>
    <?= $this->Html->script('app.js') ?>
</body>
</html>

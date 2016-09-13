<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conectados al Sur</title>
    
    <?= $this->Html->meta('icon') ?>

    <!-- 
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    -->
    <?= $this->Html->css('foundation/foundation.min.css') ?>
    <?= $this->Html->css('foundation-icons/foundation-icons.css') ?>
    <?= $this->Html->css('app.css') ?>

    <?= $this->Html->script('foundation/jquery.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div id="outer-container">
        
        <!-- header -->
        <nav class="top-bar" role="navigation">
            <div class="top-bar-title">
                <span data-responsive-toggle="responsive-menu" data-hide-for="medium">  
                    <button class="menu-icon light" type="button" data-toggle></button>
                </span>
                DVINE WEB-APP
            </div>
            <div id="responsive-menu">
                <div class="top-bar-left">
                </div>
                <div class="top-bar-right">
                    <ul class="dropdown menu" data-dropdown-menu>
                        <?= $this->fetch('available-actions') ?>
                        <!-- <?php if (isset($instance_namespace)): ?> -->
                        <li>
                            <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'login', 'cas']) ?>>Sign In</a>
                        </li>
                        <li>
                            <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout', 'cas']) ?>>Sign Out</a>
                        </li>
                        <li>
                            <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'add', $instance_namespace]) ?>>Sign Up</a>
                        </li>
                        <!-- <?php endif; ?> -->
                    </ul>
                </div>
            </div>
        </nav>

        <!-- page content -->
        <div id="content">
            <?= $this->Flash->render() ?>
            <?= $this->Flash->render('auth') ?>
            <?= $this->fetch('content') ?>
        </div>

        <!-- footer -->
        <footer>
            
            <?php if (
                isset($instance_namespace) &&
                isset($instance_logo) && 
                !empty($instance_logo)):  
            ?>
                <div class="row expanded">
                    <div class="small-12 columns footer-imgdiv">
                        <span class="footer-logo-helper"></span>
                        <?= 
                            $this->Html->image('/' . $instance_logo , [
                                'alt'   => 'Instance Logo',
                                'class' => "footer-logo"
                            ])
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row expanded footer-infodiv">
                <div class="small-12 medium-3 columns footer-infoitem">
                    <ul class="menu">
                        <li class="menu-text">© 2016 dvine</li>
                    </ul>
                </div>
                <div class="small-12 medium-3 columns footer-infoitem">
                    <ul class="menu">
                        <li><a class="button" href="#">Creative Commons??</a></li>
                    </ul>
                </div>
                <div class="small-12 medium-3 columns footer-infoitem">
                    <ul class="menu">
                        <li><a class="button" href="#">Privacy Policy??</a></li>
                    </ul>
                </div>
                <div class="small-12 medium-3 columns footer-infoitem">
                    <ul class="menu">
                        <li><?= $this->Html->link(__('Contact'), "#", ['class' => 'button']) ?></li>
                    </ul>
                </div>
            </div>
        </footer>

        <?= $this->Html->script('foundation/what-input.js') ?>
        <?= $this->Html->script('foundation/foundation.min.js') ?>
        <?= $this->Html->script('app.js') ?>
    </div>
</body>
</html>

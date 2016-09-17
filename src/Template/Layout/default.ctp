<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dvine app</title>
    
    <?= $this->Html->meta('icon') ?>

    <!-- 
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    -->
    <?= $this->Html->css('foundation/foundation.min.css') ?>
    <?= $this->Html->css('foundation-icons/foundation-icons.css') ?>
    <?= $this->Html->css('app.css') ?>
    <?= $this->Html->css('app_items.css') ?>

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
                    <?php if (isset($instance_namespace) && isset($instance_name)): ?>
                        <a href=
                            <?= $this->Url->build(
                            [
                                'controller' => 'Instances',
                                'action' => 'preview',
                                $instance_namespace
                            ])?>
                            >
                            <?= h($instance_name) ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="top-bar-right">
                    <ul class="dropdown menu" data-dropdown-menu>
                        <?= $this->fetch('available-actions') ?>
                        <?php if (isset($auth_user)): ?>
                            <li>
                                <a href="#"><i class='fi-torso size-16'></i></a>
                                <ul class="menu vertical">
                                    <li class="menu-text" id="top-bar-username-li"><span><?php echo $auth_user['email'] ?></span>
                                    </li>
                                    <li>
                                        <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $auth_user_namespace, $auth_user['id']]) ?>>Your profile</a>
                                    </li>
                                    <?php if (
                                            $auth_user['role_id'] > 0 &&
                                            isset($instance_namespace) &&
                                            $instance_namespace != "sys"
                                        ): ?>
                                    <li>
                                        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'view', $instance_namespace]) ?>>Settings</a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if ($auth_user['role_id'] == 2): ?>
                                    <li>
                                        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'index']) ?>>DVINE Settings</a>
                                    </li>
                                    <?php endif; ?>
                                    <li id="top-bar-logout-li">
                                        <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout', $auth_user_namespace]) ?>>Sign Out</a>
                                    </li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <?php if (isset($instance_namespace)): ?>
                                <li>
                                    <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'add', $instance_namespace]) ?>>Sign Up</a>
                                </li>
                                <li>
                                    <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'login', $instance_namespace]) ?>>Sign In</a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
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
                        <li><a class="button" href="#"><?= __("Creative Commons") ?></a></li>
                    </ul>
                </div>
                <div class="small-12 medium-3 columns footer-infoitem">
                    <ul class="menu">
                        <li><a class="button" href="#"><?= __("Privacy Policy") ?></a></li>
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

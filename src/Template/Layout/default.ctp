<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dvine app</title>
    
    <?= $this->Html->meta('icon') ?>

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
                <?php if (isset($instance)): ?>
                    <a href=
                    <?= $this->Url->build(['controller' => 'Instances','action' => 'preview', $instance->namespace])
                    ?>
                    >
                    <?= h($instance->name) ?>
                    </a>
                <?php endif; ?>                
            </div>
            <div id="responsive-menu">
                <div class="top-bar-right">
                    <ul class="dropdown menu" data-dropdown-menu>
                        <li>
                            <a href=<?= $lang_new_url ?>> <?= __d('template', "Language: ") ?> <span id="current-lang-button"><?= $lang_current ?></span> | <span id="lang-button"><?= $lang_alternative ?></span></a>
                        </li>
                        <?= $this->fetch('available-actions') ?>
                        <?php if (isset($auth_user)): ?>
                            <li>
                                <a href="#"><i class='fi-torso size-16'></i></a>
                                <ul class="menu vertical">
                                    <li class="menu-text" id="top-bar-username-li"><span><?php echo $auth_user['email'] ?></span>
                                    </li>
                                    <li>
                                        <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $auth_user['id']]) ?>> <?= __d('template', 'My profile') ?></a>
                                    </li>
                                    <?php if (
                                            isset($instance) &&
                                            $instance->namespace != $this->App->getAdminNamespace() &&
                                            $this->App->isAdmin($auth_user['id'], $instance->id)
                                        ): ?>
                                    <li>
                                        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'view', $instance->namespace]) ?>> <?= __d('template', 'Settings') ?> </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if ($this->App->isSysadmin($auth_user['id'])): ?>
                                    <li>
                                        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'index']) ?>> <?= __d('template', 'DVINE Settings') ?> </a>
                                    </li>
                                    <?php endif; ?>
                                    <li id="top-bar-logout-li">
                                        <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>> <?= __d('template', 'Sign Out') ?> </a>
                                    </li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>> <?= __d('template', 'Sign Up') ?> </a>
                            </li>
                            <li>
                                <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>> <?= __d('template', 'Sign In') ?> </a>
                            </li>
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
                isset($instance) &&
                !empty($instance->logo)):  
            ?>
                <div class="row expanded">
                    <div class="small-12 columns footer-imgdiv">
                        <span class="footer-logo-helper"></span>
                        <?= 
                            $this->Html->image('/' . $instance->logo , [
                                'alt'   => 'Instance Logo',
                                'class' => "footer-logo"
                            ])
                        ?>
                    </div>
                </div>

                <script>
                    var curr_padding = parseInt($("#content").css("padding-bottom"));
                    var img_div_height = parseInt($(".footer-imgdiv").css("height"));
                    $("#content").css("padding-bottom", curr_padding + img_div_height);
                    // console.log(curr_padding);
                    // var new_padding = $("#content").css("padding-bottom");
                    // console.log(new_padding);
                    

                </script>

            <?php endif; ?>

            <div class="row expanded footer-infodiv">
                <div class="small-12 medium-3 columns footer-infoitem">
                    <ul class="menu">
                        <li class="menu-text">© 2016 dvine</li>
                    </ul>
                </div>
                <div class="small-12 medium-3 columns footer-infoitem">
                    <ul class="menu">
                        <li><a class="button" href="#"><?= __d('template', "Creative Commons") ?></a></li>
                    </ul>
                </div>
                <div class="small-12 medium-3 columns footer-infoitem">
                    <ul class="menu">
                        <li><a class="button" href="#"><?= __d('template', "Privacy Policy") ?></a></li>
                    </ul>
                </div>
                <div class="small-12 medium-3 columns footer-infoitem">
                    <ul class="menu">
                        <li><?= $this->Html->link(__d('template', 'Contact'), "#", ['class' => 'button']) ?></li>
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


<style type="text/css">
#lang-button {
    text-transform: lowercase;
    font-weight: normal;
}
#current-lang-button {
    text-transform: uppercase;
    font-weight: bold;
}
</style>
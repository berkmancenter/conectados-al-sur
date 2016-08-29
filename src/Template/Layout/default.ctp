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
                dvine web-app
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
                        <li>
                            <a href="#"><i class="fi-torso"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- page content -->
        <div id="content">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>

        <!-- footer -->
        <footer>
            <div class="row fullwidth">
                <?php if (isset($instance_namespace) && ($instance_namespace != "cas") && isset($instance_logo) && !empty($instance_logo)):  ?>
                    <div class="small-12 columns footer-imgdiv-optional">
                    <?= 
                        $this->Html->image('/' . $instance_logo , ['alt' => 'Instance Logo', "class" => "footer-image"])
                    ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row fullwidth">
                <div class="small-12 columns footer-imgdiv">
                    <?= 
                    $this->Html->image('LOGO_CAS_ALPHA.png',
                    [
                        "alt" => "LOGO_CAS",
                        "class" => "footer-image"
                    ])?>
                </div>
            </div>
            <div class="row fullwidth footer-infodiv">
                <div class="small-12 medium-3 columns footer-infoitem">
                    <ul class="menu">
                        <li class="menu-text">© 2016 dvine</li>
                    </ul>
                </div>
                <div class="small-4 medium-3 columns footer-infoitem text-center">
                    <a class="button" href="#">All rights reserved??</a></li>
                </div>
                <div class="small-4 medium-3 columns footer-infoitem text-center">
                    <a class="button" href="#">Privacy Policy??</a>
                </div>
                <div class="small-4 medium-3 columns footer-infoitem text-center">
                    <?= $this->Html->link(__('Contact'), "#", ['class' => 'button']) ?>
                </div>
                       
                        <!-- <li><a href="#">Social Networks. Put FB, Twitter Here!</a></li> -->
                        <!-- 
                        authorship information
                        Tip: Contact information inside a <footer> element should go inside an <address> tag. 
                        -->
            </div>
        </footer>

        <?= $this->Html->script('foundation/jquery.js') ?>
        <?= $this->Html->script('foundation/what-input.js') ?>
        <?= $this->Html->script('foundation/foundation.min.js') ?>
        <?= $this->Html->script('app.js') ?>
    </div>
</body>
</html>

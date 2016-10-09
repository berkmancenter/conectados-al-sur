<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    <div class="row">
        <div class="small-12 column home-title">
            <h3> <span id="home-title-b">dvine</span> <span id="home-title-l">Web App</span></h3>
        </div>
    </div>
    <div class="row">
        <div class="small-12 column home-text">
            <?php if ($lang_current == "en"): ?>
                <!-- ENGLISH VERSION -->

                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean mollis auctor interdum. Duis ut dolor felis. Nam scelerisque cursus dictum. Nunc in scelerisque felis. Cras vitae diam vitae urna laoreet semper. Donec ut dui ac felis semper euismod. Vivamus et turpis ut est posuere mollis sed et diam. Integer mattis condimentum vulputate.
                </p>

                <p>Quisque in eros vel arcu auctor fringilla. Morbi lorem leo, luctus sit amet arcu vitae, volutpat dapibus leo. Proin rhoncus facilisis vehicula. Aenean finibus enim eros, in fermentum dolor accumsan quis. Praesent eget lorem porttitor, auctor tortor eu, luctus nulla. Aliquam volutpat eu sem eu laoreet. Duis rhoncus blandit nulla non laoreet. </p>

            <?php else: ?>
                <!-- SPANISH VERSION -->

                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean mollis auctor interdum. Duis ut dolor felis. Nam scelerisque cursus dictum. Nunc in scelerisque felis. Cras vitae diam vitae urna laoreet semper. Donec ut dui ac felis semper euismod. Vivamus et turpis ut est posuere mollis sed et diam. Integer mattis condimentum vulputate.
                </p>

                <p>Quisque in eros vel arcu auctor fringilla. Morbi lorem leo, luctus sit amet arcu vitae, volutpat dapibus leo. Proin rhoncus facilisis vehicula. Aenean finibus enim eros, in fermentum dolor accumsan quis. Praesent eget lorem porttitor, auctor tortor eu, luctus nulla. Aliquam volutpat eu sem eu laoreet. Duis rhoncus blandit nulla non laoreet. </p>

            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="small-8 small-offset-2 medium-6 medium-offset-3 large-4 large-offset-4 column home-login">
            <?php if (isset($auth_user) && isset($auth_user_instances)): ?>
                
                <div class="orbit" role="region" aria-label="My dvine apps" data-orbit>
                    <ul class="orbit-container">
                        
                        <?php if (count($auth_user_instances) > 1) : ?>
                            <button class="orbit-previous">
                                <span class="show-for-sr"><?= __('Previous App') ?></span>&#9664;&#xFE0E;
                            </button>
                            <button class="orbit-next">
                                <span class="show-for-sr"><?= __('Next App') ?></span>&#9654;&#xFE0E;
                            </button>
                        <?php endif; ?>
                        
                        <?php foreach ($auth_user_instances as $idx=>$instance): ?>
                            <?php if ($idx == 0): ?>
                            <li class="is-active orbit-slide">
                            <?php else: ?>
                            <li class="orbit-slide">
                            <?php endif; ?>
                                <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'preview', $instance->namespace]) ?>>
                                <?php if ($instance->logo): ?>
                                <?= 
                                    $this->Html->image('/' . $instance->logo, [
                                        'alt'   => $instance->namespace,
                                        'class' => "orbit-image"
                                    ])
                                ?>
                                <?php else: ?>
                                <?= 
                                    $this->Html->image('/' . "UNKNOWN.png", [
                                        'alt'   => $instance->namespace,
                                        'class' => "orbit-image"
                                    ])
                                ?>
                                <?php endif; ?>
                                </a>
                                <p class="text-center">
                                    <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'preview', $instance->namespace]) ?>>
                                        <?php if ($lang_current == "en"): ?>
                                        <?= $instance->name ?>
                                        <?php else: ?>
                                        <?= $instance->name_es ?>
                                        <?php endif; ?>
                                    </a>
                                </p>
                                <!-- <figcaption class="orbit-caption"><?= $instance->name ?></figcaption> -->
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <?php if (count($auth_user_instances) > 1) : ?>
                    <nav class="orbit-bullets">        
                        <?php foreach ($auth_user_instances as $idx=>$instance): ?>
                            <?php if ($idx == 0): ?>
                            <button class="is-active" data-slide=<?= $idx ?>>
                                <span class="show-for-sr">
                                    <?php if ($lang_current == "en"): ?>
                                    <?= $instance->name ?>
                                    <?php else: ?>
                                    <?= $instance->name_es ?>
                                    <?php endif; ?>
                                </span>
                                <span class="show-for-sr"><?= __('Current Slide') ?></span>
                            </button>
                            <?php else: ?>
                            <button data-slide=<?= $idx ?>>
                                <span class="show-for-sr">
                                    <?php if ($lang_current == "en"): ?>
                                    <?= $instance->name ?>
                                    <?php else: ?>
                                    <?= $instance->name_es ?>
                                    <?php endif; ?>
                                </span>
                            </button> 
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </nav>
                    <?php endif; ?>
                </div>


            <?php else: ?>
            <div class="button-group large stacked">
                <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>
                     class="secondary button">
                     <?= __d('template', 'Sign In') ?>
                 </a>
                 <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>
                     class="secondary button">
                     <?= __d('template', 'Sign Up') ?>
                 </a>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<style>
    .home-title {
        color: rgb(54,54,55);
        margin-top: 30px;
        margin-bottom: 30px;
    }
    #home-title-b {
        font-family: Futura;
        font-weight: bold;
        font-size: 36px;
    }
    #home-title-l {
        font-family: Futura;
        font-weight: normal;
        font-size: 36px;
    }
    .home-text {
        font-family: Futura;
        font-weight: normal;
        font-size: 16px;
    }

    .home-text p {
        margin: 20px 0px;
    }

    .home-login {
        margin-top: 20px;
    }

    .orbit-image {
        height: 100px;
        width: 400px;
        background-color: #fff;

    }
    .orbit-previous { background-color: rgba(54, 54, 55, 0.5); }
    .orbit-next     { background-color: rgba(54, 54, 55, 0.5); }

    .orbit-slide {
        background-color: rgb(54, 54, 55);
        color: #fff;
    }
    .orbit-slide > p {
        padding: 10px 15px;
    }
    .orbit-slide > p > a {
        color: #fff;
    }
    .orbit-slide > p > a:hover {
        color: #39a0ea;
    }

</style>
<script>
    $("body").css("background-color", "#ed7d31");
    $("#outer-container").css("background-color", "#ed7d31");
    // $("#content").css("padding-bottom", "170px");
</script>
<!-- CSS -->
<?= $this->Html->css('app_orange.css') ?>

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
                <table class="hover" id="home-table" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?= __('Your Apps') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($auth_user_instances)): ?>
                        <?php foreach ($auth_user_instances as $instance): ?>
                            <tr>
                                <td>
                                <a href="<?= $this->Url->build(['controller' => 'Instances', 'action' => 'preview', $instance->namespace]) ?>"
                                >
                                <?php if ($lang_current == "en"): ?>
                                    <?= $instance->name ?>
                                <?php else: ?>
                                    <?= $instance->name_es ?>
                                <?php endif; ?>
                                </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td><?= __('You don\'t have any registered app.') ?></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>

            <?php else: ?>
            <div class="button-group large stacked">
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>"
                     class="secondary button">
                     <?= __d('template', 'Sign In') ?>
                 </a>
                 <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>"
                     class="secondary button">
                     <?= __d('template', 'Sign Up') ?>
                 </a>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<style>
    
    .home-login {
        margin-top: 20px;
    }

    #home-table thead {
        border: 0px ;
    }

    #home-table th {
        text-align: center;
        font-family: Futura;
        font-weight: bold;
        font-size: 16px;
    }

    #home-table td {
        font-family: Futura;
        font-weight: normal;
        font-size: 16px;
        background-color: rgb(54,54,55);
    }
    #home-table td:hover {
        background-color: rgb(63,63,64);
    }

    #home-table {
        color: #fff;
        text-align: center;
        border-collapse:separate;
        border:solid black 10px;
        border-radius:10px;
    }

    #home-table td a {
        color: #fff;
        display: block;
        width: auto;
    }
    #home-table td a:hover {
        color: #39a0ea;
    }

    .home-login a.button {
        background-color: rgb(54,54,55);
        border-radius: 10px;
        margin-bottom: 2px;
        margin-top: 2px;
        border: 5px solid black;
        text-align: center;
        font-family: Futura;
        /*font-weight: bold;*/
    }
    
</style>
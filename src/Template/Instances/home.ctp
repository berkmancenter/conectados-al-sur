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

                <p>DVINE WEB APP is a tool that allows to visualize and geolocalize projects in a given field. It helps to map projects that are being developed in different countries around the world, allowing the visualization of categories, networks and relevant information.</p>

                <p>It includes DOTPLOT, a visualization tool that allows to tell stories about data. DVINE WEB APP and DOTPLOT work together to map and visualize a complex and diverse network of projects and people in an easy and intuitive way.</p>

            <?php else: ?>
                <!-- SPANISH VERSION -->

                <p>DVINE WEB APP es una herramienta que permite visualizar y geolocalizar proyectos a nivel global, en un campo determinado. Ayuda a mapear proyectos realizados o en curso en diferentes países del mundo, permitiendo la visualización de categorías, redes e información relevante.</p>

                <p>Incluye DOTPLOT, una herramienta de visualización que permite contar historias a partir de datos. DVINE WEB APP y DOTPLOT trabajan juntas para mapear y visualizar una compleja y diversa red de proyectos y personas, de una manera fácil e intuitiva.</p>

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
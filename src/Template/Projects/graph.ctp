<style>
.side-nav li
{
    background-color: #ccc;
}

.side-nav li a:not(.button)
{
    color: #000;
}
.side-nav li a:hover:not(.button)
{
    color: red;
}
</style>

<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add', $instance_namespace]) ?> </li>
<?php $this->end(); ?>


<!-- Page Content -->
<div class="fullwidth page-content-with-sidebar">

    <div class="off-convas-wrapper">
        <div class="off-convas-wrapper-inner" data-off-canvas-wrapper>

            <div class="off-canvas position-left" id="offCanvas" data-off-canvas>
                <!-- close button -->
                <button class="close-button" aria-label="Close menu" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>

                <!-- menu -->
                <ul class="vertical menu">
                    <li><a href="#">Lorem.</a></li>
                    <li><a href="#">Facilis.</a></li>
                    <li><a href="#">Sed?</a></li>
                    <li><a href="#">Impedit?</a></li>
                    <li><a href="#">Maxime.</a></li>
                </ul>

            </div>
            <div class="off-cavas-content" data-off-canvas-content>
                <div class="row projects-index fullwidth" data-equalizer="container">
                    <nav class="medium-4 large-3 columns side-nav" id="actions-sidebar" data-equalizer-watch="container">
                        <div class="side-links" data-equalizer="links">
                            <ul class="expanded button-group">
                            <?= $this->Html->link(__('New Project'), [
                                'action' => 'add',
                                 $instance_namespace
                            ], [
                                 'class' => 'secondary button',
                                 'data-equalizer-watch' => 'links'
                            ]) ?>
                            <?= $this->Html->link(__('Map Visualization'), [
                                'action' => 'map', $instance_namespace
                            ], [
                                'class' => 'secondary button',
                                'data-equalizer-watch' => 'links'
                            ]) ?>
                        </ul>
                        </div>
                        <hr>
                        <div class="side-filters">
                            <p id="info-nprojects"></p> <button type="button" class="button" data-toggle="offCanvas">Filter Panel</button>
                        </div>
                        <hr>
                        <div class="side-nav-info">
                            <p id="info-country-label"></p>
                        </div>
                    </nav>
                    <div class="medium-8 large-9 columns projects-graph" data-equalizer-watch="container">
                        <h3>Visualización Gráfica (En construcción ...)</h3>
                        <div class="row">
                            <div class="large-12 medium-12 columns content">
                                <?= $this->Html->image('graph_preview.png', [
                                    'alt' => 'View Projects Graph',
                                    'height' => 800,
                                    'width'  => 800
                                ]) ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
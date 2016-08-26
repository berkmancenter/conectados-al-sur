<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
<?php $this->end(); ?>

<!-- Page Content -->
<!-- <div class="instances view large-12 columns content"> -->
    <div class="row">
        <div class="large-12 small-12 columns">
            <h3><?= h($instance->name) ?></h3>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <?= $this->Text->autoParagraph(h($instance->description)); ?>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <?= $this->Text->autoParagraph(h($instance->description_es)); ?>
        </div>
    </div>
    <div class="row">
        <div class="large-2 small-12 columns"></div>
        <div class="large-2 medium-6 columns">
            <?= $this->Html->image('graph_preview.png', [
                'alt' => 'View Projects Graph',
                'url' => ['controller' => 'Projects', 'action' => 'graph', $instance->namespace],
                'style' => 'border:5px solid black'
            ]) ?>
        </div>
        <div class="large-2 small-12 columns"></div>
        <div class="large-2 medium-6 columns">
            <?= $this->Html->image('map_preview.png', [
                'alt' => 'View Projects Map',
                'url' => ['controller' => 'Projects', 'action' => 'map', $instance->namespace],
                'style' => 'border:5px solid black'
            ]) ?>        
        </div>
        <div class="large-12 small-12 columns"></div>
    </div>
<!-- </div> -->

<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add', $instance_namespace]) ?> </li>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h($instance->name) ?></h3>
    </div>
</div>

<div class="row preview-desc">
    <div class="small-12 columns preview-desc-esp">
        <?= $this->Text->autoParagraph(h($instance->description_es)); ?>
    </div>
    <hr>
    <div class="small-12 columns preview-desc-eng">
        <?= $this->Text->autoParagraph(h($instance->description)); ?>
    </div>
</div>

<div class="row preview-imgs">
    <div class="small-6 columns">
        <?= $this->Html->image('graph_preview.png', [
            'alt' => 'View Map',
            'url' => ['controller' => 'Projects', 'action' => 'graph', $instance->namespace],
            'class' => 'thumbnail'
        ]) ?>
    </div>
    <div class="small-6 columns">
        <?= $this->Html->image('map_preview.png', [
            'alt' => 'View DOTPLOT',
            'url' => ['controller' => 'Projects', 'action' => 'map', $instance->namespace],
            'class' => 'thumbnail'
        ]) ?>        
    </div>
</div>

</div>
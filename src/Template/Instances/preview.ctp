<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<li><?= $this->Html->link(__('Home'), ['controller' => 'Instances', 'action' => 'preview', $instance_namespace]) ?> </li>
<li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add', $instance_namespace]) ?></li>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column preview-title">
        <h3 ><?= h($instance->name) ?></h3>
    </div>
</div>

<div class="row preview-desc">
    <div class="small-12 columns preview-desc-esp">
        <?= $this->Text->autoParagraph(h($instance->description_es)); ?>
    </div>
</div>
<div class="row preview-desc">
    <hr>
</div>
<div class="row preview-desc">
    <div class="small-12 columns preview-desc-eng">
        <?= $this->Text->autoParagraph(h($instance->description)); ?>
    </div>
</div>

<div class="row preview-imgs">
    <div class="small-10 small-offset-1 medium-5 medium-offset-1 columns">
        <?= $this->Html->image('graph_preview.png', [
            'alt' => 'View Map',
            'url' => ['controller' => 'Projects', 'action' => 'graph', $instance->namespace],
            'class' => 'thumbnail'
        ]) ?>
    </div>
    <div class="small-1 medium-0 columns"></div>
    <div class="small-10 small-offset-1 medium-5 medium-offset-1 columns">
        <?= $this->Html->image('map_preview.png', [
            'alt' => 'View DOTPLOT',
            'url' => ['controller' => 'Projects', 'action' => 'map', $instance->namespace],
            'class' => 'thumbnail'
        ]) ?>        
    </div>
    <div class="small-1 medium-6 columns"></div>
</div>

</div>
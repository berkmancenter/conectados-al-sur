<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="instances view large-10 medium-9 columns content">
    <h3><?= h($instance->name) ?></h3>
    <div class="row">
        <!-- <h4><?= __('Description') ?></h4> -->
        <?= $this->Text->autoParagraph(h($instance->description)); ?>
    </div>
    <div class="row">
        <div class="large-6 medium-6 columns content">
            <?= $this->Html->image('graph_preview.png', [
                'alt' => 'View Projects Graph',
                'url' => ['controller' => 'Projects', 'action' => 'graph', $instance->namespace],
                'style' => 'border:5px solid black'
            ]) ?>
        </div>
        <div class="large-6 medium-6 columns content">
            <?= $this->Html->image('map_preview.png', [
                'alt' => 'View Projects Map',
                'url' => ['controller' => 'Projects', 'action' => 'map', $instance->namespace],
                'style' => 'border:5px solid black'
            ]) ?>        
        </div>
    </div>
</div>

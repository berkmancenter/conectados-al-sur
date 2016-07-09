<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Organization Types'), ['controller' => 'OrganizationTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Organization Type'), ['controller' => 'OrganizationTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Stages'), ['controller' => 'ProjectStages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Stage'), ['controller' => 'ProjectStages', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projects index large-9 medium-8 columns content">
    <ul>
        <li class="left">
            <?= $this->Html->image('graph_preview.png', [
                "alt" => "GRAPH PREVIEW",
                'url' => [ 
                    'controller' => 'Projects',
                    'action' => 'graph'
                ]
            ]) ?>
        </li>
        <li class="right">
            <?= $this->Html->image('map_preview.png', [
                "alt" => "MAP PREVIEW",
                'url' => [ 
                    'controller' => 'Projects',
                    'action' => 'map'
                ]
            ]) ?>
        </li>
    </ul>
</div>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $subcontinent->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $subcontinent->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Subcontinents'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Continents'), ['controller' => 'Continents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Continent'), ['controller' => 'Continents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="subcontinents form large-9 medium-8 columns content">
    <?= $this->Form->create($subcontinent) ?>
    <fieldset>
        <legend><?= __('Edit Subcontinent') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('name_es');
            echo $this->Form->input('continent_id', ['options' => $continents]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

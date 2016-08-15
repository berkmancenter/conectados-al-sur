<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $continent->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $continent->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Continents'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Subcontinents'), ['controller' => 'Subcontinents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Subcontinent'), ['controller' => 'Subcontinents', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="continents form large-9 medium-8 columns content">
    <?= $this->Form->create($continent) ?>
    <fieldset>
        <legend><?= __('Edit Continent') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('name_es');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

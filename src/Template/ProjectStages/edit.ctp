<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $projectStage->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $projectStage->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Project Stages'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projectStages form large-9 medium-8 columns content">
    <?= $this->Form->create($projectStage) ?>
    <fieldset>
        <legend><?= __('Edit Project Stage') ?></legend>
        <?php
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

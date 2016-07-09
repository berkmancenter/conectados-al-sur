<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Genres'), ['controller' => 'Genres', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Genre'), ['controller' => 'Genres', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Organization Types'), ['controller' => 'OrganizationTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Organization Type'), ['controller' => 'OrganizationTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('email');
            echo $this->Form->input('password');
            echo $this->Form->input('genre_id', ['options' => $genres]);
            echo $this->Form->input('main_organization');
            echo $this->Form->input('organization_type_id', ['options' => $organizationTypes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

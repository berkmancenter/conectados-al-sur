<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Instances Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Instances'), ['controller' => 'Instances', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Instance'), ['controller' => 'Instances', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Organization Types'), ['controller' => 'OrganizationTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Organization Type'), ['controller' => 'OrganizationTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="instancesUsers form large-9 medium-8 columns content">
    <?= $this->Form->create($instancesUser) ?>
    <fieldset>
        <legend><?= __('Add Instances User') ?></legend>
        <?php
            echo $this->Form->input('role_id', ['options' => $roles]);
            echo $this->Form->input('contact');
            echo $this->Form->input('main_organization');
            echo $this->Form->input('organization_type_id', ['options' => $organizationTypes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

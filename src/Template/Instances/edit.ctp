<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $instance->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $instance->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Instances'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Organization Types'), ['controller' => 'OrganizationTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Organization Type'), ['controller' => 'OrganizationTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="instances form large-9 medium-8 columns content">
    <?= $this->Form->create($instance) ?>
    <fieldset>
        <legend><?= __('Edit Instance') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('name_es');
            echo $this->Form->input('namespace');
            echo $this->Form->input('description');
            echo $this->Form->input('description_es');
            echo $this->Form->input('logo');
            echo $this->Form->input('use_org_types');
            echo $this->Form->input('use_user_genre');
            echo $this->Form->input('use_user_organization');
            echo $this->Form->input('use_proj_cities');
            echo $this->Form->input('use_proj_stage');
            echo $this->Form->input('use_proj_categories');
            echo $this->Form->input('use_proj_description');
            echo $this->Form->input('use_proj_url');
            echo $this->Form->input('use_proj_contribution');
            echo $this->Form->input('use_proj_contributing');
            echo $this->Form->input('use_proj_organization');
            echo $this->Form->input('use_proj_location');
            echo $this->Form->input('use_proj_dates');
            echo $this->Form->input('proj_max_categories');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $project->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $project->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['action' => 'index']) ?></li>
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
<div class="projects form large-9 medium-8 columns content">
    <?= $this->Form->create($project) ?>
    <fieldset>
        <legend><?= __('Edit Project') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('description');
            echo $this->Form->input('url');
            echo $this->Form->input('contribution');
            echo $this->Form->input('contributing');
            echo $this->Form->input('organization');
            echo $this->Form->input('organization_type_id', ['options' => $organizationTypes]);
            echo $this->Form->input('project_stage_id', ['options' => $projectStages]);
            echo $this->Form->input('country_id');
            echo $this->Form->input('city_id', ['options' => $cities]);
            echo $this->Form->input('start_date', ['empty' => true]);
            echo $this->Form->input('finish_date', ['empty' => true]);
            echo $this->Form->input('categories._ids', ['options' => $categories]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

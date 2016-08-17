<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Back to Map'), ['action' => 'map', $instance_namespace]) ?> </li>
        <li><?= $this->Html->link(__('View Project'), ['action' => 'edit', $instance_namespace, $project->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Project'), ['action' => 'delete', $instance_namespace, $project->id], ['confirm' => __('Are you sure you want to delete this project?. This action cannot be undone. Related data will be erased.')]) ?> </li>
    </ul>
</nav>
<div class="projects form large-9 medium-8 columns content">
    <?= $this->Form->create($project) ?>
    <fieldset>
        <legend><?= __('Edit Project') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('description');
            echo $this->Form->input('url');
            echo $this->Form->input('contribution');
            echo $this->Form->input('contributing');
            echo $this->Form->input('organization');
            echo $this->Form->input('organization_type_id', ['options' => $organizationTypes]);
            echo $this->Form->input('project_stage_id', ['options' => $projectStages]);
            echo $this->Form->input('country_id', ['options' => $countries]);
            // echo $this->Form->input('city_id', ['options' => $cities, 'empty' => true]);
            // echo $this->Form->input('latitude');
            // echo $this->Form->input('longitude');
            echo $this->Form->input('start_date', ['empty' => true]);
            echo $this->Form->input('finish_date', ['empty' => true]);
            echo $this->Form->input('categories._ids', ['label' => 'Categories (Hold Ctrl to select more than one)', 'options' => $categories]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Back to Map'), ['action' => 'map', $instance_namespace]) ?> </li>
    </ul>
</nav>
<div class="projects form large-9 medium-8 columns content">
    <?= $this->Form->create($project) ?>
    <fieldset>
        <legend><?= __('Add Project (EN CONSTRUCCION)') ?></legend>
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
            echo $this->Form->input('country_id', ['options' => $countries]);
            // echo $this->Form->input('city_id', ['options' => $cities, 'empty' => true]);
            // echo $this->Form->input('latitude');
            // echo $this->Form->input('longitude');
            echo $this->Form->input('start_date', ['empty' => true]);
            echo $this->Form->input('finish_date', ['empty' => true]);
            echo $this->Form->input('categories._ids', ['options' => $categories]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

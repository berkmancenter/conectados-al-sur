<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Instances'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="instances form large-10 medium-9 columns content">
    <?= $this->Form->create($instance) ?>
    <fieldset>
        <legend><?= __('Add Instance') ?></legend>
        <?php
            echo $this->Form->input('name', ['label' => 'Instance Name']);
            echo $this->Form->input('name_es', ['label' => 'Instance Name (Spanish Version)']);
            echo $this->Form->input('namespace', ['label' => 'App URL']);
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

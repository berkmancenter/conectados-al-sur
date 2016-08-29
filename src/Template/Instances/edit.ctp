<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<li><?= $this->Html->link(__('Home'), ['controller' => 'Instances', 'action' => 'preview', $instance_namespace]) ?> </li>
<li><?= $this->Html->link(__('Back to Instances'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Instance'), ['action' => 'add']) ?></li>
<?php $this->end(); ?>


<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 medium-9 column view-title">
        <h3><?= h($instance->name) ?></h3>
    </div>
    <div class="small-12 medium-3 column view-title">
        <a href=<?= $this->Url->build(['action' => 'view', $instance->namespace]) ?>><i class='fi-magnifying-glass size-36'></i>View</a>
        <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . "DELETE", ['action' => 'delete', $instance->namespace], ['escape' => false], 
                ['confirm' => __('Are you sure you want to delete the "{0}" instance?. This operation cannot be undone. All related data will be erased!', $instance->name)]) ?>
    </div>
</div>



<div class="instances form large-10 medium-9 columns content">
    <?= $this->Form->create($instance) ?>
    <fieldset>
        <legend><?= __('Edit Instance') ?></legend>
        <?php
            echo $this->Form->input('name', ['label' => 'Instance Name']);
            echo $this->Form->input('name_es', ['label' => 'Instance Name (Spanish)']);
            echo $this->Form->input('namespace', ['label' => 'App URL']);
            echo $this->Form->input('description', ['label' => 'Description']);
            echo $this->Form->input('description_es', ['label' => 'Description (Spanish)']);
            echo $this->Form->input('logo', ['label' => 'Enable Main Organization field?']);
            echo $this->Form->input('use_user_genre', ['label' => 'Enable Genre field?']);
            echo $this->Form->input('use_user_organization', ['label' => 'Enable Main Organization field?']);
            echo $this->Form->input('use_proj_categories', ['label' => 'Enable Categories?']);
            echo $this->Form->input('proj_max_categories', ['label' => 'Max. Allowed Categories']);
            echo $this->Form->input('use_org_types', ['label' => 'Enable Organization Type field?']);
            echo $this->Form->input('use_proj_organization', ['label' => 'Enable Organization name field?']);
            echo $this->Form->input('use_proj_cities', ['label' => 'Enable Cities usage?']);
            echo $this->Form->input('use_proj_location', ['label' => 'Enable exact location?']);
            echo $this->Form->input('use_proj_stage', ['label' => 'Enable Project Stage field?']);
            echo $this->Form->input('use_proj_url', ['label' => 'Enable external URL field?']);
            echo $this->Form->input('use_proj_description', ['label' => 'Enable Description field?']);
            echo $this->Form->input('use_proj_contribution', ['label' => 'Enable Contribution field?']);
            echo $this->Form->input('use_proj_contributing', ['label' => 'Enable Contributing field?']);
            echo $this->Form->input('use_proj_dates', ['label' => 'Enable start and finish dates?']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

</div>

<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $instance->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $instance->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Instances'), ['action' => 'index']) ?></li>
    </ul>
</nav>
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

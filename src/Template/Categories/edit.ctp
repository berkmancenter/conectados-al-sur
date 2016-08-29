<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<li><?= $this->Html->link(__('Home'), ['controller' => 'Instances', 'action' => 'preview', $instance_namespace]) ?> </li>
<li><?= $this->Html->link(__('Back to Instance'), ['controller' => 'Instances', 'action' => 'view', $instance_namespace]) ?> </li>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h($instance->name)  ?></h3>
        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]) ?>><i class='fi-home size-36'></i></a>
        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'view', $instance_namespace]) ?>><i class='fi-wrench size-36'></i></a>
        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'map', $instance_namespace]) ?>><i class='fi-map size-36'></i></a>
        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'dots', $instance_namespace]) ?>><i class='fi-web size-36'></i></a>
    </div>
</div>


<div class="row">
    <div class="small-12 column">
        <div class="form">
            <?= $this->Form->create($category) ?>
            <fieldset>
                <h4 class="view-subtitle"><?= __('Edit Category:') ?></h4>
                <?php
                    echo $this->Form->input('name');
                    echo $this->Form->input('name_es');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'warning button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>



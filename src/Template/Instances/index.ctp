<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<li><?= $this->Html->link(__('New Instance'), ['action' => 'add']) ?></li>
<?php $this->end(); ?>

<!-- Page Content -->

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= __('Instances') ?></h3>
    </div>
</div>

<div class="row">
    <div class="small-12 column">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', '#') ?></th>
                    <th><?= $this->Paginator->sort('name', 'Name') ?></th>
                    <th><?= $this->Paginator->sort('name_es', 'Name (Spanish)') ?></th>
                    <th><?= $this->Paginator->sort('namespace', 'Instace URL') ?></th>
                    <th><?= $this->Paginator->sort('logo', 'Logo') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($instances as $instance): ?>
                <tr>
                    <td><?= $this->Number->format($instance->id) ?></td>
                    <td><?= h($instance->name) ?></td>
                    <td><?= h($instance->name_es) ?></td>
                    <td><?= $this->Html->link(['controller' => 'Instances', 'action' => 'preview', $instance->namespace, '_full' => true])?> </td>
                    <td>TO-DO</td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $instance->namespace]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $instance->namespace]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $instance->namespace], 
                            ['confirm' => __('Are you sure you want to delete the "{0}" instance?. This operation cannot be undone. All related data will be erased!', $instance->name)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>        
    </div>
</div>

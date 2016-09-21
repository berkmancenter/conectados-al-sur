<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    
    <div class="row">
        <div class="small-12 column view-title">
            <h3><?= __('Instances') ?></h3>
            <a href=<?= $this->Url->build(['action' => 'add']) ?>><i class='fi-plus size-36'></i>New Instance</a>
        </div>
    </div>

    <div class="row">
        <div class="small-12 column">
            <table class="hover stack" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('name', 'Name') ?></th>
                        <th><?= $this->Paginator->sort('namespace', 'Instace URL') ?></th>
                        <th><?= __('Logo') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($instances as $instance): ?>
                    <tr>
                        <td><?= h($instance->name) ?></td>
                        <td><?= $this->Html->link(['controller' => 'Instances', 'action' => 'preview', $instance->namespace, '_full' => true])?> </td>
                        <td>
                            <?= 
                                $this->Html->image('/' . $instance->logo , ['alt' => 'Instance Logo', "class" => "instances-logo"]);
                            ?>
                        </td>
                        <td class="actions">
                            <a href=<?= $this->Url->build(['action' => 'view', $instance->namespace]) ?>><i class='fi-magnifying-glass size-36'></i></a>
                            <a href=<?= $this->Url->build(['action' => 'edit', $instance->namespace]) ?>><i class='fi-page-edit size-36'></i></a>
                            <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')),
                                    ['action' => 'delete', $instance->namespace],
                                    [
                                        'escape' => false, 
                                        'confirm' => __('Are you sure you want to delete the "{0}" instance?. This operation cannot be undone. All related data will be erased!', $instance->name)
                                    ]
                                )
                                ?>
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

            <h4 class="view-subtitle-related"><?= __('Web App Admins: ') ?></h4>
            <?php if (!empty($sysadmins)): ?>
            <table class="hover stack" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Username') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sysadmins as $user): ?>
                    <tr>
                        <td><?= h($user->name) ?></td>
                        <td><?= h($user->email) ?></td>
                        <td class="actions">
                            <span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="View user">
                            <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $user->id]) ?>><i class='fi-magnifying-glass size-24'></i></a>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>
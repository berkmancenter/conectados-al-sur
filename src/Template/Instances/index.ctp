<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    
    <div class="row">
        <div class="small-12 column view-title">
            <h3><?= __('Admin Panel') ?></h3>
        </div>
    </div>

    <div class="row">
        <div class="small-12 column">

            <h4 class="view-subtitle-related"><?= __('Web apps: ') ?></h4>
            <a href=<?= $this->Url->build(['action' => 'add']) ?>>
                <i class='fi-plus size-36'></i>
                <?= __('New app') ?>
            </a>
            <table class="hover stack" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('name', __('App name')) ?></th>
                        <th><?= $this->Paginator->sort('namespace', __('App URL')) ?></th>
                        <th><?= __('Logo') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($instances as $instance): ?>
                    <tr>
                        <td>
                            <span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="<?= __('View App') ?>">
                                <a href=<?= $this->Url->build(['action' => 'view', $instance->namespace]) ?>>
                                    <?= h($instance->name) ?>
                                </a>
                            </span>
                        </td>

                        <td><?= $this->Html->link(['controller' => 'Instances', 'action' => 'preview', $instance->namespace, '_full' => true])?> </td>
                        <td>
                            <?= 
                                $this->Html->image('/' . $instance->logo , ['alt' => 'Please, provide a logo', "class" => "instances-logo"]);
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

            <h4 class="view-subtitle-related"><?= __('Admins: ') ?></h4>
            <?php if (!empty($sysadmins)): ?>
            <table class="hover stack" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Username') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sysadmins as $user): ?>
                    <tr>
                        <td>
                            <span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="<?= __('View user data') ?>">
                                <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $user->id]) ?>>
                                    <i class='fi-crown size-24'></i>
                                    <?= h($user->name) ?>
                                </a>
                            </span>
                        </td>
                        <td><?= h($user->email) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>


<style type="text/css">
.instances-logo {
    max-width: 200px;
}
</style>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Instance'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Organization Types'), ['controller' => 'OrganizationTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Organization Type'), ['controller' => 'OrganizationTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="instances index large-9 medium-8 columns content">
    <h3><?= __('Instances') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('name_es') ?></th>
                <th><?= $this->Paginator->sort('namespace') ?></th>
                <th><?= $this->Paginator->sort('logo') ?></th>
                <th><?= $this->Paginator->sort('use_org_types') ?></th>
                <th><?= $this->Paginator->sort('use_user_genre') ?></th>
                <th><?= $this->Paginator->sort('use_user_organization') ?></th>
                <th><?= $this->Paginator->sort('use_proj_cities') ?></th>
                <th><?= $this->Paginator->sort('use_proj_stage') ?></th>
                <th><?= $this->Paginator->sort('use_proj_categories') ?></th>
                <th><?= $this->Paginator->sort('use_proj_description') ?></th>
                <th><?= $this->Paginator->sort('use_proj_url') ?></th>
                <th><?= $this->Paginator->sort('use_proj_contribution') ?></th>
                <th><?= $this->Paginator->sort('use_proj_contributing') ?></th>
                <th><?= $this->Paginator->sort('use_proj_organization') ?></th>
                <th><?= $this->Paginator->sort('use_proj_location') ?></th>
                <th><?= $this->Paginator->sort('use_proj_dates') ?></th>
                <th><?= $this->Paginator->sort('proj_max_categories') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($instances as $instance): ?>
            <tr>
                <td><?= $this->Number->format($instance->id) ?></td>
                <td><?= h($instance->name) ?></td>
                <td><?= h($instance->name_es) ?></td>
                <td><?= h($instance->namespace) ?></td>
                <td><?= h($instance->logo) ?></td>
                <td><?= h($instance->use_org_types) ?></td>
                <td><?= h($instance->use_user_genre) ?></td>
                <td><?= h($instance->use_user_organization) ?></td>
                <td><?= h($instance->use_proj_cities) ?></td>
                <td><?= h($instance->use_proj_stage) ?></td>
                <td><?= h($instance->use_proj_categories) ?></td>
                <td><?= h($instance->use_proj_description) ?></td>
                <td><?= h($instance->use_proj_url) ?></td>
                <td><?= h($instance->use_proj_contribution) ?></td>
                <td><?= h($instance->use_proj_contributing) ?></td>
                <td><?= h($instance->use_proj_organization) ?></td>
                <td><?= h($instance->use_proj_location) ?></td>
                <td><?= h($instance->use_proj_dates) ?></td>
                <td><?= $this->Number->format($instance->proj_max_categories) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $instance->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $instance->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $instance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $instance->id)]) ?>
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

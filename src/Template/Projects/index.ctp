<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Organization Types'), ['controller' => 'OrganizationTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Organization Type'), ['controller' => 'OrganizationTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Stages'), ['controller' => 'ProjectStages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Stage'), ['controller' => 'ProjectStages', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projects index large-9 medium-8 columns content">
    <h3><?= __('Projects') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('url') ?></th>
                <th><?= $this->Paginator->sort('organization') ?></th>
                <th><?= $this->Paginator->sort('organization_type_id') ?></th>
                <th><?= $this->Paginator->sort('project_stage_id') ?></th>
                <th><?= $this->Paginator->sort('country_id') ?></th>
                <th><?= $this->Paginator->sort('city_id') ?></th>
                <th><?= $this->Paginator->sort('latitude') ?></th>
                <th><?= $this->Paginator->sort('longitude') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th><?= $this->Paginator->sort('start_date') ?></th>
                <th><?= $this->Paginator->sort('finish_date') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
            <tr>
                <td><?= $this->Number->format($project->id) ?></td>
                <td><?= h($project->name) ?></td>
                <td><?= $project->has('user') ? $this->Html->link($project->user->name, ['controller' => 'Users', 'action' => 'view', $project->user->id]) : '' ?></td>
                <td><?= h($project->url) ?></td>
                <td><?= h($project->organization) ?></td>
                <td><?= $project->has('organization_type') ? $this->Html->link($project->organization_type->name, ['controller' => 'OrganizationTypes', 'action' => 'view', $project->organization_type->id]) : '' ?></td>
                <td><?= $project->has('project_stage') ? $this->Html->link($project->project_stage->name, ['controller' => 'ProjectStages', 'action' => 'view', $project->project_stage->id]) : '' ?></td>
                <td><?= $project->has('country') ? $this->Html->link($project->country->name, ['controller' => 'Countries', 'action' => 'view', $project->country->id]) : '' ?></td>
                <td><?= $project->has('city') ? $this->Html->link($project->city->name, ['controller' => 'Cities', 'action' => 'view', $project->city->id]) : '' ?></td>
                <td><?= $this->Number->format($project->latitude) ?></td>
                <td><?= $this->Number->format($project->longitude) ?></td>
                <td><?= h($project->created) ?></td>
                <td><?= h($project->modified) ?></td>
                <td><?= h($project->start_date) ?></td>
                <td><?= h($project->finish_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $project->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $project->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete # {0}?', $project->id)]) ?>
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

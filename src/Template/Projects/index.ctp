<!-- TODO: aviso si no hay proyectos asignados -->
<!-- TODO: mostrar filtro actual -->
<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    
<div class="row">
    <div class="small-12 column view-title">
        <h3><?= __('Project List') ?></h3>
        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]) ?>><i class='fi-home size-36'></i></a>
        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'map', $instance_namespace]) ?>><i class='fi-map size-36'></i></a>
        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'dots', $instance_namespace]) ?>><i class='fi-web size-36'></i></a>
    </div>
</div>

<div class="row">
    <div class="small-12 column">

        <h4 class="view-subtitle-related"><?= __('Found: ' . count($projects)) ?></h4>
        <a href=<?= $this->Url->build(['action' => 'add', $instance_namespace]) ?>><i class='fi-plus size-36'></i>New Project</a>

        <table class="hover stack" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('organization') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= h($project->name) ?></td>
                    <td><?= h($project->organization) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $instance_namespace, $project->id]) ?>
                    </td>
                    <!-- <td><?= $project->has('user') ? $this->Html->link($project->user->name, ['controller' => 'Users', 'action' => 'view', $project->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($project->instance_id) ?></td>
                    <td><?= h($project->url) ?></td>
                    
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
                     -->
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

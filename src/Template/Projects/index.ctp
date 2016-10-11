<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    
<div class="row">
    <div class="small-12 column view-title">
        <h3><?= __('Project List') ?></h3>
        <?= $this->App->displayInstancePreviewShortcut($instance->namespace) ?>
        <?= $this->App->displayInstanceMapShortcut($instance->namespace) ?>
        <?= $this->App->displayInstanceDotsShortcut($instance->namespace) ?>
    </div>
</div>

<div class="row">
    <div class="small-12 column">

        <h4 class="view-subtitle-related"><?= __('Found: ' . $this->request->params['paging']['Projects']['count'] ) ?></h4>
        <a href="<?= $this->Url->build(['action' => 'add', $instance->namespace]) ?>"><i class='fi-plus size-36'></i>New Project</a>
        <a href="<?= $this->Url->build(['action' => 'exportCsv', $instance->namespace]) . "?" . $filter_query ?>"><i class='fi-arrow-down size-36'></i>Download</a>

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
                        <?= $this->Html->link(__('View'), ['action' => 'view', $instance->namespace, $project->id]) ?>
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
            <p><?= $this->Paginator->counter(
                        __('Page') . ' {{page}} ' . __('of') . ' {{pages}}'
                    )
                ?>
            </p>
        </div>
    </div>
</div>

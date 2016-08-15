<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Project Stage'), ['action' => 'edit', $projectStage->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Project Stage'), ['action' => 'delete', $projectStage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectStage->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Project Stages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Stage'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="projectStages view large-9 medium-8 columns content">
    <h3><?= h($projectStage->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($projectStage->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Name Es') ?></th>
            <td><?= h($projectStage->name_es) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($projectStage->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Projects') ?></h4>
        <?php if (!empty($projectStage->projects)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Instance Id') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Url') ?></th>
                <th><?= __('Contribution') ?></th>
                <th><?= __('Contributing') ?></th>
                <th><?= __('Organization') ?></th>
                <th><?= __('Organization Type Id') ?></th>
                <th><?= __('Project Stage Id') ?></th>
                <th><?= __('Country Id') ?></th>
                <th><?= __('City Id') ?></th>
                <th><?= __('Latitude') ?></th>
                <th><?= __('Longitude') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('Finish Date') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($projectStage->projects as $projects): ?>
            <tr>
                <td><?= h($projects->id) ?></td>
                <td><?= h($projects->name) ?></td>
                <td><?= h($projects->user_id) ?></td>
                <td><?= h($projects->instance_id) ?></td>
                <td><?= h($projects->description) ?></td>
                <td><?= h($projects->url) ?></td>
                <td><?= h($projects->contribution) ?></td>
                <td><?= h($projects->contributing) ?></td>
                <td><?= h($projects->organization) ?></td>
                <td><?= h($projects->organization_type_id) ?></td>
                <td><?= h($projects->project_stage_id) ?></td>
                <td><?= h($projects->country_id) ?></td>
                <td><?= h($projects->city_id) ?></td>
                <td><?= h($projects->latitude) ?></td>
                <td><?= h($projects->longitude) ?></td>
                <td><?= h($projects->created) ?></td>
                <td><?= h($projects->modified) ?></td>
                <td><?= h($projects->start_date) ?></td>
                <td><?= h($projects->finish_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'view', $projects->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Projects', 'action' => 'edit', $projects->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Projects', 'action' => 'delete', $projects->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projects->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

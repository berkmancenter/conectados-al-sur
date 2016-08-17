<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Back to Map'), ['action' => 'map', $instance_namespace]) ?> </li>
        <li><?= $this->Html->link(__('Edit Project'), ['action' => 'edit', $instance_namespace, $project->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Project'), ['action' => 'delete', $instance_namespace, $project->id], ['confirm' => __('Are you sure you want to delete this project?. This action cannot be undone. Related data will be erased.')]) ?> </li>
    </ul>
</nav>
<div class="projects view large-10 medium-9 columns content">
    <h3><?= h($project->name) ?></h3>
    <h4><?= __('Summary:') ?></h4>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $project->has('user') ? $this->Html->link($project->user->name, ['controller' => 'Users', 'action' => 'view', $project->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Url') ?></th>
            <td><?= $this->Html->link($project->url) ?></td>
        </tr>
        <tr>
            <th><?= __('Organization') ?></th>
            <td><?= h($project->organization) ?></td>
        </tr>
        <tr>
            <th><?= __('Organization Type') ?></th>
            <td><?= $project->has('organization_type') ? h($project->organization_type->name) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Project Stage') ?></th>
            <td><?= $project->has('project_stage') ? h($project->project_stage->name) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Country') ?></th>
            <td><?= $project->has('country') ? h($project->country->name) : '' ?></td>
        </tr>
        <!-- <tr>
            <th><?= __('City') ?></th>
            <td><?= $project->has('city') ? h($project->city->name) : '' ?></td>
        </tr> -->
        <!-- <tr>
            <th><?= __('Latitude') ?></th>
            <td><?= $this->Number->format($project->latitude) ?></td>
        </tr>
        <tr>
            <th><?= __('Longitude') ?></th>
            <td><?= $this->Number->format($project->longitude) ?></td>
        </tr> -->
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($project->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($project->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Date') ?></th>
            <td><?= h($project->start_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Finish Date') ?></th>
            <td><?= h($project->finish_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($project->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Project Contribution:') ?></h4>
        <?= $this->Text->autoParagraph(h($project->contribution)); ?>
    </div>
    <div class="row">
        <h4><?= __('Contributing to this project:') ?></h4>
        <?= $this->Text->autoParagraph(h($project->contributing)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Categories') ?></h4>
        <?php if (!empty($project->categories)): ?>
        <table cellpadding="0" cellspacing="0">
            <?php foreach ($project->categories as $categories): ?>
            <tr>
                <td><?= h($categories->name) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

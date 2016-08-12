<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Project'), ['action' => 'edit', $project->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Project'), ['action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete # {0}?', $project->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Organization Types'), ['controller' => 'OrganizationTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Organization Type'), ['controller' => 'OrganizationTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Project Stages'), ['controller' => 'ProjectStages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Stage'), ['controller' => 'ProjectStages', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="projects view large-9 medium-8 columns content">
    <h3><?= h($project->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($project->name) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $project->has('user') ? $this->Html->link($project->user->name, ['controller' => 'Users', 'action' => 'view', $project->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Url') ?></th>
            <td><?= h($project->url) ?></td>
        </tr>
        <tr>
            <th><?= __('Organization') ?></th>
            <td><?= h($project->organization) ?></td>
        </tr>
        <tr>
            <th><?= __('Organization Type') ?></th>
            <td><?= $project->has('organization_type') ? $this->Html->link($project->organization_type->name, ['controller' => 'OrganizationTypes', 'action' => 'view', $project->organization_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Project Stage') ?></th>
            <td><?= $project->has('project_stage') ? $this->Html->link($project->project_stage->name, ['controller' => 'ProjectStages', 'action' => 'view', $project->project_stage->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Country') ?></th>
            <td><?= $project->has('country') ? $this->Html->link($project->country->name, ['controller' => 'Countries', 'action' => 'view', $project->country->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('City') ?></th>
            <td><?= $project->has('city') ? $this->Html->link($project->city->name, ['controller' => 'Cities', 'action' => 'view', $project->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($project->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Latitude') ?></th>
            <td><?= $this->Number->format($project->latitude) ?></td>
        </tr>
        <tr>
            <th><?= __('Longitude') ?></th>
            <td><?= $this->Number->format($project->longitude) ?></td>
        </tr>
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
        <h4><?= __('Contribution') ?></h4>
        <?= $this->Text->autoParagraph(h($project->contribution)); ?>
    </div>
    <div class="row">
        <h4><?= __('Contributing') ?></h4>
        <?= $this->Text->autoParagraph(h($project->contributing)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Categories') ?></h4>
        <?php if (!empty($project->categories)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($project->categories as $categories): ?>
            <tr>
                <td><?= h($categories->id) ?></td>
                <td><?= h($categories->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Categories', 'action' => 'view', $categories->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Categories', 'action' => 'edit', $categories->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Categories', 'action' => 'delete', $categories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categories->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

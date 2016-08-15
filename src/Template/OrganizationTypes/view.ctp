<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Organization Type'), ['action' => 'edit', $organizationType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Organization Type'), ['action' => 'delete', $organizationType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $organizationType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Organization Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Organization Type'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="organizationTypes view large-9 medium-8 columns content">
    <h3><?= h($organizationType->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($organizationType->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Name Es') ?></th>
            <td><?= h($organizationType->name_es) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($organizationType->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Instance Id') ?></th>
            <td><?= $this->Number->format($organizationType->instance_id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Projects') ?></h4>
        <?php if (!empty($organizationType->projects)): ?>
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
            <?php foreach ($organizationType->projects as $projects): ?>
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
    <div class="related">
        <h4><?= __('Related Users') ?></h4>
        <?php if (!empty($organizationType->users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Email') ?></th>
                <th><?= __('Contact') ?></th>
                <th><?= __('Password') ?></th>
                <th><?= __('Role Id') ?></th>
                <th><?= __('Instance Id') ?></th>
                <th><?= __('Genre Id') ?></th>
                <th><?= __('Main Organization') ?></th>
                <th><?= __('Organization Type Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($organizationType->users as $users): ?>
            <tr>
                <td><?= h($users->id) ?></td>
                <td><?= h($users->name) ?></td>
                <td><?= h($users->email) ?></td>
                <td><?= h($users->contact) ?></td>
                <td><?= h($users->password) ?></td>
                <td><?= h($users->role_id) ?></td>
                <td><?= h($users->instance_id) ?></td>
                <td><?= h($users->genre_id) ?></td>
                <td><?= h($users->main_organization) ?></td>
                <td><?= h($users->organization_type_id) ?></td>
                <td><?= h($users->created) ?></td>
                <td><?= h($users->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

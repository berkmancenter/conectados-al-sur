<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit City'), ['action' => 'edit', $city->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete City'), ['action' => 'delete', $city->id], ['confirm' => __('Are you sure you want to delete # {0}?', $city->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cities view large-9 medium-8 columns content">
    <h3><?= h($city->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($city->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($city->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Country Id') ?></th>
            <td><?= $this->Number->format($city->country_id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Projects') ?></h4>
        <?php if (!empty($city->projects)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Url') ?></th>
                <th><?= __('Contribution') ?></th>
                <th><?= __('Contributing') ?></th>
                <th><?= __('Organization') ?></th>
                <th><?= __('Organization Type Id') ?></th>
                <th><?= __('Project Stage Id') ?></th>
                <th><?= __('City Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('Finish Date') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->projects as $projects): ?>
            <tr>
                <td><?= h($projects->id) ?></td>
                <td><?= h($projects->name) ?></td>
                <td><?= h($projects->user_id) ?></td>
                <td><?= h($projects->description) ?></td>
                <td><?= h($projects->url) ?></td>
                <td><?= h($projects->contribution) ?></td>
                <td><?= h($projects->contributing) ?></td>
                <td><?= h($projects->organization) ?></td>
                <td><?= h($projects->organization_type_id) ?></td>
                <td><?= h($projects->project_stage_id) ?></td>
                <td><?= h($projects->city_id) ?></td>
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
        <h4><?= __('Related Countries') ?></h4>
        <?php if (!empty($city->countries)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->countries as $countries): ?>
            <tr>
                <td><?= h($countries->id) ?></td>
                <td><?= h($countries->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Countries', 'action' => 'view', $countries->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Countries', 'action' => 'edit', $countries->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Countries', 'action' => 'delete', $countries->id], ['confirm' => __('Are you sure you want to delete # {0}?', $countries->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

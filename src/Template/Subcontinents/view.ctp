<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Subcontinent'), ['action' => 'edit', $subcontinent->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Subcontinent'), ['action' => 'delete', $subcontinent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subcontinent->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Subcontinents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Subcontinent'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Continents'), ['controller' => 'Continents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Continent'), ['controller' => 'Continents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="subcontinents view large-9 medium-8 columns content">
    <h3><?= h($subcontinent->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($subcontinent->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Name Es') ?></th>
            <td><?= h($subcontinent->name_es) ?></td>
        </tr>
        <tr>
            <th><?= __('Continent') ?></th>
            <td><?= $subcontinent->has('continent') ? $this->Html->link($subcontinent->continent->name, ['controller' => 'Continents', 'action' => 'view', $subcontinent->continent->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($subcontinent->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Countries') ?></h4>
        <?php if (!empty($subcontinent->countries)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Cod A3') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Name Es') ?></th>
                <th><?= __('Subcontinent Id') ?></th>
                <th><?= __('Latitude') ?></th>
                <th><?= __('Longitude') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($subcontinent->countries as $countries): ?>
            <tr>
                <td><?= h($countries->id) ?></td>
                <td><?= h($countries->cod_a3) ?></td>
                <td><?= h($countries->name) ?></td>
                <td><?= h($countries->name_es) ?></td>
                <td><?= h($countries->subcontinent_id) ?></td>
                <td><?= h($countries->latitude) ?></td>
                <td><?= h($countries->longitude) ?></td>
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

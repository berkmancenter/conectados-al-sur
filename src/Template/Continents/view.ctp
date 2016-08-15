<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Continent'), ['action' => 'edit', $continent->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Continent'), ['action' => 'delete', $continent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $continent->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Continents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Continent'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Subcontinents'), ['controller' => 'Subcontinents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Subcontinent'), ['controller' => 'Subcontinents', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="continents view large-9 medium-8 columns content">
    <h3><?= h($continent->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($continent->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Name Es') ?></th>
            <td><?= h($continent->name_es) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($continent->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Subcontinents') ?></h4>
        <?php if (!empty($continent->subcontinents)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Name Es') ?></th>
                <th><?= __('Continent Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($continent->subcontinents as $subcontinents): ?>
            <tr>
                <td><?= h($subcontinents->id) ?></td>
                <td><?= h($subcontinents->name) ?></td>
                <td><?= h($subcontinents->name_es) ?></td>
                <td><?= h($subcontinents->continent_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Subcontinents', 'action' => 'view', $subcontinents->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Subcontinents', 'action' => 'edit', $subcontinents->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Subcontinents', 'action' => 'delete', $subcontinents->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subcontinents->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

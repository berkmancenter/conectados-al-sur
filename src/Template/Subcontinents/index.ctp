<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Subcontinent'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Continents'), ['controller' => 'Continents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Continent'), ['controller' => 'Continents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="subcontinents index large-9 medium-8 columns content">
    <h3><?= __('Subcontinents') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('name_es') ?></th>
                <th><?= $this->Paginator->sort('continent_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subcontinents as $subcontinent): ?>
            <tr>
                <td><?= $this->Number->format($subcontinent->id) ?></td>
                <td><?= h($subcontinent->name) ?></td>
                <td><?= h($subcontinent->name_es) ?></td>
                <td><?= $subcontinent->has('continent') ? $this->Html->link($subcontinent->continent->name, ['controller' => 'Continents', 'action' => 'view', $subcontinent->continent->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $subcontinent->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $subcontinent->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $subcontinent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subcontinent->id)]) ?>
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

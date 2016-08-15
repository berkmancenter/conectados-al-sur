<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Continent'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Subcontinents'), ['controller' => 'Subcontinents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Subcontinent'), ['controller' => 'Subcontinents', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="continents index large-9 medium-8 columns content">
    <h3><?= __('Continents') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('name_es') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($continents as $continent): ?>
            <tr>
                <td><?= $this->Number->format($continent->id) ?></td>
                <td><?= h($continent->name) ?></td>
                <td><?= h($continent->name_es) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $continent->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $continent->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $continent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $continent->id)]) ?>
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

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Categories Project'), ['action' => 'edit', $categoriesProject->project_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Categories Project'), ['action' => 'delete', $categoriesProject->project_id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoriesProject->project_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Categories Projects'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Categories Project'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="categoriesProjects view large-9 medium-8 columns content">
    <h3><?= h($categoriesProject->project_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Project') ?></th>
            <td><?= $categoriesProject->has('project') ? $this->Html->link($categoriesProject->project->name, ['controller' => 'Projects', 'action' => 'view', $categoriesProject->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Category') ?></th>
            <td><?= $categoriesProject->has('category') ? $this->Html->link($categoriesProject->category->name, ['controller' => 'Categories', 'action' => 'view', $categoriesProject->category->id]) : '' ?></td>
        </tr>
    </table>
</div>

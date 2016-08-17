<style>
.side-nav li
{
    background-color: #ccc;
}

.side-nav li a:not(.button)
{
    color: #000;
}
.side-nav li a:hover:not(.button)
{
    color: red;
}
</style>

<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Project'), ['action' => 'add', $instance_namespace]) ?></li>
        <li><?= $this->Html->link(__('Map Visualization'), ['action' => 'map', $instance_namespace]) ?></li>
    </ul>
</nav>
<div class="projects graph large-10 medium-9 columns content">
    <h3>Visualización Gráfica (En construcción ...)</h3>
    <div class="row">
        <div class="large-12 medium-12 columns content">
            <?= $this->Html->image('graph_preview.png', [
                'alt' => 'View Projects Graph',
                'height' => 800,
                'width'  => 800
            ]) ?>
        </div>
    </div>
</div>

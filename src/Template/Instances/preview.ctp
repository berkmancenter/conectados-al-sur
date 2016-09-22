<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column preview-title">
        <h3><?= h($instance->name) ?></h3>
    </div>
</div>

<div class="row preview-desc">
    <div class="small-12 columns">
        <?= $this->Text->autoParagraph(h($instance->description)); ?>
    </div>
</div>

<div class="row preview-imgs">
    <div class="small-10 small-offset-1 medium-5 medium-offset-1 columns">
        <?= $this->Html->image('graph_preview.png', [
            'alt' => 'View Map',
            'url' => ['controller' => 'Instances', 'action' => 'dots', $instance->namespace]
        ]) ?>
    </div>
    <div class="small-1 medium-0 columns"></div>
    <div class="small-10 small-offset-1 medium-5 medium-offset-1 columns">
        <?= $this->Html->image('map_preview.png', [
            'alt' => 'View DOTPLOT',
            'url' => ['controller' => 'Instances', 'action' => 'map', $instance->namespace]
        ]) ?>        
    </div>
    <div class="small-1 medium-6 columns"></div>
</div>

</div>

<style type="text/css">
/* ****************************************************************************
* PREVIEW
**************************************************************************** */

.preview-title {
    margin-top: 30px;
    margin-bottom: 30px;
    text-align: center;
    text-transform: uppercase;
}
.preview-title h3 {
    font-family: Futura;
    font-size: 30px;
}

.preview-desc {
    font-size: 15px;
    text-align: center;
    text-transform: uppercase;
    padding: 0px 0px;
    margin-bottom: 0px;
}
.preview-desc p {
    color: #ed7d31;
    /*color: #39a0ea;    */
}


.preview-imgs {
    margin-top: 50px;
}

/* dont show link outside images on larger screens */
@media only screen 
and (min-width : 700px) {
    .preview-imgs a { display: block; }
}
.preview-imgs a {
    margin-left: auto;
    margin-right: auto;
    height: 0;
}

.preview-imgs img {
    margin-top: 10px;
    border-radius: 100px;
    border: 0px;
    width: 150px;
    height: 150px;
    display: block;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 0px;
    transition-property: box-shadow;
    transition-delay: 0s;
    transition-duration: 0.2s;
    transition-timing-function: ease-out;
}

.preview-imgs img:hover, .preview-imgs img:focus {
    box-shadow: 0 0 0px 7px #46C7F4;
}
</style>

<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column preview-title">
        <?php if ($lang_current == "en"): ?>
        <h3><?= h($instance->name) ?></h3>
        <?php else: ?>
        <h3><?= h($instance->name_es) ?></h3>
        <?php endif; ?>
    </div>
</div>

<div class="row preview-desc">
    <div class="small-12 columns">
        <?php if ($lang_current == "en"): ?>
        <?= $this->Text->autoParagraph(h($instance->description)); ?>
        <?php else: ?>
        <?= $this->Text->autoParagraph(h($instance->description_es)); ?>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="small-12 medium-8 medium-offset-2 columns">
        <div class="row preview-imgs">

            <div class="small-12 medium-6 columns">
                <a href="<?= $this->Url->build(['controller' => 'Instances', 'action' => 'dots', $instance->namespace]) ?>" >
                    <figure>
                        <?= $this->Html->image('graph_preview.png', ['alt' => 'View dotplot']) ?>
                        <figcaption>dots</figcaption>
                    </figure>
                </a>
            </div>

            <div class="small-12 medium-6 columns">
                <a href="<?= $this->Url->build(['controller' => 'Instances', 'action' => 'map', $instance->namespace]) ?>" >
                    <figure>
                        <?= $this->Html->image('map_preview.png', ['alt' => 'View map']) ?>
                        <figcaption><?=  __("map") ?></figcaption>
                    </figure>
                </a>
                </figure>
            </div>

        </div>
    </div>
</div>

    <!-- 
    <div class="small-10 small-offset-1 medium-5 medium-offset-1 columns">
    </div>
    <div class="small-1 medium-0 columns"></div>
    <div class="small-10 small-offset-1 medium-5 medium-offset-1 columns">
    </div>
    <div class="small-1 medium-6 columns"></div>
    -->

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


figcaption {
    margin: 10px 0 0 0;
    font-variant: small-caps;
    font-family: Futura;
    font-weight: bold;
    font-size: 15px;
    color: #39a0ea;
    /*color: #ed7d31;*/
    text-align: center;
}

.preview-imgs {
    margin-top: 50px;
    margin-bottom: 50px;
}

/* stack images on small screens */
@media only screen 
and (min-width : 640px) {
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
    border: 1px solid black;
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
    border: 0px;
    /*box-shadow: 0 0 0px 7px #46C7F4;*/
    box-shadow: 0 0 0px 7px #ed7d31;
}

</style>

<!-- CSS -->
<?= $this->Html->css('app_orange.css') ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    <div class="row">
        <div class="small-12 column home-title">
            <?php if ($lang_current == "en"): ?>
                <h3> <span id="home-title-b">Creative Commons</span> <span id="home-title-l">Licence</span></h3>
            <?php else: ?>
                <h3> <span id="home-title-b">Licencia</span> <span id="home-title-l">Creative Commons</span></h3>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="small-12 column home-text">
            <?php if ($lang_current == "en"): ?>
                <!-- ENGLISH VERSION -->

                <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licencia Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">DVINE WEB APP</span> por <a xmlns:cc="http://creativecommons.org/ns#" href="<?= $this->Url->build('/',["full" => true])?>" property="cc:attributionName" rel="cc:attributionURL"><?= $this->Url->build('/',["full" => true])?></a> se distribuye bajo una <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Licencia Creative Commons Atribución-NoComercial-CompartirIgual 4.0 Internacional</a>.<br />Basada en una obra en <a xmlns:dct="http://purl.org/dc/terms/" href="<?= $this->Url->build('/',["full" => true])?>" rel="dct:source"><?= $this->Url->build('/',["full" => true])?></a>.

            <?php else: ?>
                <!-- SPANISH VERSION -->

                <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licencia Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">DVINE WEB APP</span> por <a xmlns:cc="http://creativecommons.org/ns#" href="<?= $this->Url->build('/',["full" => true])?>" property="cc:attributionName" rel="cc:attributionURL"><?= $this->Url->build('/',["full" => true])?></a> se distribuye bajo una <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Licencia Creative Commons Atribución-NoComercial-CompartirIgual 4.0 Internacional</a>.<br />Basada en una obra en <a xmlns:dct="http://purl.org/dc/terms/" href="<?= $this->Url->build('/',["full" => true])?>" rel="dct:source"><?= $this->Url->build('/',["full" => true])?></a>.


            <?php endif; ?>
        </div>
    </div>
</div>

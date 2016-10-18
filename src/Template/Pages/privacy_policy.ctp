<!-- CSS -->
<?= $this->Html->css('app_orange.css') ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    <div class="row">
        <div class="small-12 column home-title">
            <h3> <span id="home-title-b">Privacy</span> <span id="home-title-l">Policy</span></h3>
        </div>
    </div>
    <div class="row">
        <div class="small-12 column home-text">
            <?php if (false && $lang_current == "en"): ?>
                <!-- ENGLISH VERSION -->

                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean mollis auctor interdum. Duis ut dolor felis. Nam scelerisque cursus dictum. Nunc in scelerisque felis. Cras vitae diam vitae urna laoreet semper. Donec ut dui ac felis semper euismod. Vivamus et turpis ut est posuere mollis sed et diam. Integer mattis condimentum vulputate.
                </p>

                <p>Quisque in eros vel arcu auctor fringilla. Morbi lorem leo, luctus sit amet arcu vitae, volutpat dapibus leo. Proin rhoncus facilisis vehicula. Aenean finibus enim eros, in fermentum dolor accumsan quis. Praesent eget lorem porttitor, auctor tortor eu, luctus nulla. Aliquam volutpat eu sem eu laoreet. Duis rhoncus blandit nulla non laoreet. </p>

            <?php else: ?>
                <!-- SPANISH VERSION -->

                <h4 class="view-subtitle"><?= __('General:') ?></h4>

                <p>Al acceder al sitio <a href="<?= $this->Url->build('/',["full" => true])?>"><?= $this->Url->build('/',["full" => true])?></a> el usuario está aceptando y reconoce que ha revisado y esta de acuerdo con su Política de Privacidad.</p>

                <p>Las políticas de privacidad podrán modificarse y será responsabilidad del usuario la lectura y acatamiento de esta cada vez que ingrese al sitio.</p>

                
                <h4 class="view-subtitle"><?= __('Acceso a la Información:') ?></h4>

                <p>Los contenidos del sitio <a href="<?= $this->Url->build('/',["full" => true])?>"><?= $this->Url->build('/',["full" => true])?></a> tienen carácter de acceso libre gratuito para los usuarios, sin embargo hay información que está limitada para miembros de los proyectos incluidos en la aplicación web.</p>
                
                <p>Para acceder a ellos los usuarios miembros de la comunidad podrán acceder con los nombres de usuario y claves que les correspondan en su calidad de miembros.</p>



                <h4 class="view-subtitle"><?= __('Información de los Usuarios:') ?></h4>

                <p>El sitio recopila datos de los suscriptores, usuarios y/o visitantes que hagan uso de la aplicación web. Esto puede ser a través de procesos informáticos  para realizar registros de actividades (patrones de actividad, navegación y audiencia). Para ello no será necesaria la identificación personal de usuarios y/o visitantes.</p>
                
                <p>No se hace uso comercial de la información recopilada de los usuarios. </p>



                <h4 class="view-subtitle"><?= __('Información a terceros:') ?></h4>

                <p>No se comunicará ni transferirá a terceros los datos personales de sus usuarios sin el consentimiento expreso del titular. Solo tienen acceso a la base de datos completa, los administradores del sitio. No obstante lo anterior, en caso de ser requerido judicialmente se hará entrega de la información solicitada.</p>


                <h4 class="view-subtitle"><?= __('Uso de la información:') ?></h4>

                <p>Al acceder al sitio, el visitante tendrá derecho a revisar toda la información que esté disponible en él, así como descargar bases de datos de carácter público, sólo pudiendo utilizarla para fines particulares, de investigación educativa o social y no comerciales. Sin perjuicio de lo anterior, la veracidad o exactitud de la información volcada por los usuarios sobre sus proyectos, no es responsabilidad de los administradores del sitio.</p>

            <?php endif; ?>
        </div>
    </div>
</div>

<style type="text/css">
.view-subtitle {
    margin-top: 30px;
    font-family: Futura;
    font-weight: bold;
}

.home-text p {
    margin-bottom: 0px;
    margin-top: 10px;
}

</style>

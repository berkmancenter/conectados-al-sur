<!-- CSS -->
<?= $this->Html->css('app_orange.css') ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    <div class="row">
        <div class="small-12 column home-title">
            <?php if ($lang_current == "en"): ?>
                <h3> <span id="home-title-b">Privacy</span> <span id="home-title-l">Policy</span></h3>
            <?php else: ?>
                <h3> <span id="home-title-b">Política </span> <span id="home-title-l">de Privacidad</span></h3>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="small-12 column home-text">
            <?php if ($lang_current == "en"): ?>
                <!-- ENGLISH VERSION -->

                <h4 class="view-subtitle">General:</h4>

                <p>By accessing the site <a href="<?= $this->Url->build('/',["full" => true])?>"><?= $this->Url->build('/',["full" => true])?></a> the user accepts and acknowledges that has reviewed and agree with its Privacy Policy.</p>

                <p>The privacy policies may be amended and is the user responsibility to read and accept them each time he or she enters the site.</p>

                
                <h4 class="view-subtitle">Access to information:</h4>
                
                <p>The contents of the site <a href="<?= $this->Url->build('/',["full" => true])?>"><?= $this->Url->build('/',["full" => true])?></a> is free and open access for users, however there are edition features that is only allowed to registered members.  Registered users can access with their user names and passwords allocated in their membership.</p>



                <h4 class="view-subtitle">User information:</h4>
                
                <p>No commercial use of information collected from users is made. User e-mails are not listed in the site. Only the contact e-mails of their project introduced by users.</p>



                <h4 class="view-subtitle">Information to third parties:</h4>

                <p>Personal e-mails of users, will not be communicated or transferred to third parties without the express consent of the owner.</p>


                <h4 class="view-subtitle">Use of information:</h4>

                <p>By accessing the site, visitors will have the right to review all available information on it, and download databases of public nature, and they can only be used for social and educational or non-commercial research or purposes. Notwithstanding the foregoing, the truth or accuracy of the information overturned by users on their projects, is not responsibility of the administrators of the site.</p>



            <?php else: ?>
                <!-- SPANISH VERSION -->

                <h4 class="view-subtitle">General:</h4>

                <p>Al acceder al sitio <a href="<?= $this->Url->build('/',["full" => true])?>"><?= $this->Url->build('/',["full" => true])?></a> el usuario está aceptando y reconoce que ha revisado y esta de acuerdo con su Política de Privacidad.</p>

                <p>Las políticas de privacidad podrán modificarse y será responsabilidad del usuario la lectura y acatamiento de esta cada vez que ingrese al sitio.</p>

                
                <h4 class="view-subtitle">Acceso a la Información:</h4>

                <p>Los contenidos del sitio <a href="<?= $this->Url->build('/',["full" => true])?>"><?= $this->Url->build('/',["full" => true])?></a> tienen carácter de acceso libre gratuito para los usuarios, sin embargo hay información que está limitada para miembros de los proyectos incluidos en la aplicación web.</p>
                
                <p>Para acceder a ellos los usuarios miembros de la comunidad podrán acceder con los nombres de usuario y claves que les correspondan en su calidad de miembros.</p>



                <h4 class="view-subtitle">Información de los Usuarios:</h4>

                <p>El sitio recopila datos de los suscriptores, usuarios y/o visitantes que hagan uso de la aplicación web. Esto puede ser a través de procesos informáticos  para realizar registros de actividades (patrones de actividad, navegación y audiencia). Para ello no será necesaria la identificación personal de usuarios y/o visitantes.</p>
                
                <p>No se hace uso comercial de la información recopilada de los usuarios. </p>



                <h4 class="view-subtitle">Información a terceros:</h4>

                <p>No se comunicará ni transferirá a terceros los datos personales de sus usuarios sin el consentimiento expreso del titular. Solo tienen acceso a la base de datos completa, los administradores del sitio. No obstante lo anterior, en caso de ser requerido judicialmente se hará entrega de la información solicitada.</p>


                <h4 class="view-subtitle">Uso de la información:</h4>

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

<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    <div class="row">
        <div class="small-12 column home-title">
            <h3> <span id="home-title-b">Contact</span> <span id="home-title-l">Us</span></h3>
        </div>
    </div>
    <div class="row">
        <div class="small-12 column home-text">
            <?php if ($lang_current == "en"): ?>
                <!-- ENGLISH VERSION -->

                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean mollis auctor interdum. Duis ut dolor felis. Nam scelerisque cursus dictum. Nunc in scelerisque felis. Cras vitae diam vitae urna laoreet semper. Donec ut dui ac felis semper euismod. Vivamus et turpis ut est posuere mollis sed et diam. Integer mattis condimentum vulputate.
                </p>

                <p>Quisque in eros vel arcu auctor fringilla. Morbi lorem leo, luctus sit amet arcu vitae, volutpat dapibus leo. Proin rhoncus facilisis vehicula. Aenean finibus enim eros, in fermentum dolor accumsan quis. Praesent eget lorem porttitor, auctor tortor eu, luctus nulla. Aliquam volutpat eu sem eu laoreet. Duis rhoncus blandit nulla non laoreet. </p>

            <?php else: ?>
                <!-- SPANISH VERSION -->

                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean mollis auctor interdum. Duis ut dolor felis. Nam scelerisque cursus dictum. Nunc in scelerisque felis. Cras vitae diam vitae urna laoreet semper. Donec ut dui ac felis semper euismod. Vivamus et turpis ut est posuere mollis sed et diam. Integer mattis condimentum vulputate.
                </p>

                <p>Quisque in eros vel arcu auctor fringilla. Morbi lorem leo, luctus sit amet arcu vitae, volutpat dapibus leo. Proin rhoncus facilisis vehicula. Aenean finibus enim eros, in fermentum dolor accumsan quis. Praesent eget lorem porttitor, auctor tortor eu, luctus nulla. Aliquam volutpat eu sem eu laoreet. Duis rhoncus blandit nulla non laoreet. </p>

            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .home-title {
        color: rgb(54,54,55);
        margin-top: 30px;
        margin-bottom: 30px;
    }
    #home-title-b {
        font-family: Futura;
        font-weight: bold;
        font-size: 36px;
    }
    #home-title-l {
        font-family: Futura;
        font-weight: normal;
        font-size: 36px;
    }
    .home-text {
        font-family: Futura;
        font-weight: normal;
        font-size: 16px;
        text-align: justify;
    }

    .home-text p {
        margin: 20px 0px;
        color: black;
    }

    .top-bar-title {
        color: rgb(54,54,55);
    }
    
</style>
<script>
    $("body").css("background-color", "#ed7d31");
    $("#outer-container").css("background-color", "#ed7d31");
    // $("#content").css("padding-bottom", "170px");
</script>
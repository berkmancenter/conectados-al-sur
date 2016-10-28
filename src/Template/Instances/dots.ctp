
<!-- Page Content -->
<div class="fullwidth page-content-dots">

    <div class="row expanded" id="viz-header-div">
        <div class="small-6 medium-5 columns viz-header-div">
            <form>
                <?php 
                echo $this->Form->input('Filter A', [
                    'label' => __d('dots', 'Order By'),
                    'id' => 'filter_a',
                    'class' => 'header-filter-select',
                    'options' => []
                ]);
                ?>
            </form>
        </div>
        <div class="show-for-medium medium-2 columns viz-header-div">
            <button type="button" class="button" id="switch_button">
                <i class='fi-loop'></i>
            </button>
        </div>
        <div class="small-6 medium-5 columns viz-header-div">
            <form>
                <?php 
                echo $this->Form->input('Filter B', [
                    'label' => __d('dots', 'Compare to'),
                    'id' => 'filter_b',
                    'class' => 'header-filter-select',
                    'options' => []
                ]);
                ?>
            </form>
        </div>
    </div>

    <div class="row expanded" id="viz-dots-row">
        <div class="small-12 columns svg-div" id="svg-left"></div>
        <div class="small-12 columns svg-div" id="svg-right"></div>
    </div>

    <div class="row expanded" id="dots-navbar">
        <div class="small-3 medium-2 large-1 columns" id="dots-left-controls">
            <?= $this->Html->link("<i class='fi-plus'></i>", [
                'controller' => 'Projects',
                'action' => 'add',
                 $instance->namespace
            ], [
                 'class' => 'secondary button',
                 'escape' => false
            ]) ?>
            <?= $this->Html->link("<i class='fi-map'></i>", [
                'controller' => 'Instances',
                'action' => 'map', $instance->namespace
            ], [
                'class' => 'secondary button',
                'escape' => false
            ]) ?>
        </div>
        <div class="small-6 medium-8 large-10 columns" id="dots-middle-controls">
            <p id="info-title"></p>
            <ul id="info-ul"></ul>
        </div>
        <div class="small-3 medium-2 large-1 columns" id="dots-right-controls">
            <button type="button" class="button" id="show-filters-button">
                <!-- <i class='fi-widget'></i> -->
                <?= __d('dots', 'Filters') ?>
            </button>
            <span id="info-nprojects-txt"><?= __d('dots', 'total projects') ?></span>
            <span id="info-nprojects">0</span>
            <?= $this->Html->link(__d('dots', 'View All'), [
                'controller' => 'Projects',
                'action' => 'index', $instance->namespace
            ], [
                'id' => 'dots_project_list_button',
                'target' => '_blank'
            ]) ?>
        </div>
    </div>

    <div class="form" id="filters-div">
        <div class="row expanded">
            <div class="small-12 columns">
                <span id="filters-title"><?= __d('dots', 'Filtering Options') ?></span>
            </div>
        </div>
        <form id="filter-form">
            <div class="row expanded">
                <div class="small-6 medium-4 large-3 columns">
                    <?php 
                    echo $this->Form->input('Organization Type', [
                        // 'class' => 'filter-select',
                        'label' => __d('dots', 'Organization Type'),
                        'id' => 'filter-orgtype',
                        'empty' => '---',
                        'class' => 'filter-input',
                        'options' => $_organization_types]
                        //, 'multiple' => true
                    );
                    ?>
                </div>
                <div class="small-6 medium-4 large-3 columns">
                    <?php 
                    echo $this->Form->input('Category', [
                        // 'class' => 'filter-select',
                        'label' => __d('dots', 'Project Category'),
                        'id' => 'filter-category',
                        'empty' => '---',
                        'class' => 'filter-input',
                        'options' => $_categories]
                    );
                    ?>
                </div>
                <div class="small-6 medium-4 large-3 columns">
                    <?php 
                    echo $this->Form->input('Stage', [
                        // 'class' => 'filter-select',
                        'label' => __d('dots', 'Project Stage'),
                        'id' => 'filter-stage',
                        'empty' => '---',
                        'class' => 'filter-input',
                        'options' => $project_stages_f]
                    );
                    ?>
                </div>
                <div class="small-6 medium-4 large-3 columns">
                    <?php 
                    echo $this->Form->input('Collaborator genre', [
                        // 'class' => 'filter-select',
                        'label' => __d('dots', 'Collaborator Genre'),
                        'id' => 'filter-genre',
                        'empty' => '---',
                        'class' => 'filter-input',
                        'options' => $genres_f]
                    );
                    ?>
                </div>
                <div class="small-6 medium-4 large-3 columns">
                    <?php 
                    echo $this->Form->input('Region', [
                        // 'class' => 'filter-select',
                        'label' => __d('dots', 'Region'),
                        'id' => 'filter-region',
                        'empty' => '---',
                        'class' => 'filter-input',
                        'options' => $continents_f]
                    );
                    ?>
                </div>
                <div class="small-6 medium-4 large-3 columns">
                    <?php 
                    echo $this->Form->input('Country', [
                        // 'class' => 'filter-select',
                        'label' => __d('dots', 'Country'),
                        'id' => 'filter-country',
                        'empty' => '---',
                        'class' => 'filter-input',
                        'options' => []]
                    );
                    ?>
                </div>
                <div class="small-12 large-6 columns">
                    <button type="button" class="hollow button" id="filter-clear"><?= __d('dots', 'Clear Filters') ?></button>
                    <button type="button" class="hollow button" id="filter-apply"><?= __d('dots', 'Apply') ?></button>
                </div>
            </div>
        </form>
    </div>

</div>

<script type="text/javascript">

    ///////////////////////////////////////////////////////////////////////////////
    //////////////////// SERVER DATA //////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////

    // location data
    var _data_continents    = <?php echo json_encode($continents); ?>;
    var _data_subcontinents = <?php echo json_encode($subcontinents); ?>;
    var _data_countries     = <?php echo json_encode($countries); ?>;

    // independent
    var _data_genres         = <?php echo json_encode($genres); ?>;
    var _data_project_stages = <?php echo json_encode($project_stages); ?>;

    // instance
    var _data_projects           = <?php echo json_encode($projects); ?>;
    var _data_categories         = <?php echo json_encode($instance->categories); ?>;
    var _data_organization_types = <?php echo json_encode($instance->organization_types); ?>;
    
    var _filter_options = <?php 
        echo json_encode(
            [
                't' => __d('dots', 'Category'),
                'o' => __d('dots', 'Organization Type'),
                'r' => __d('dots', 'Region'),
                'g' => __d('dots', 'Genre'),
                's' => __d('dots', 'Project Stage'),
            ]
        );
    ?>;
    
    var _language = "<?= $lang_current ?>";

    // console.log(_data_continents);
    // console.log(_data_subcontinents);
    // console.log(_data_countries);
    // console.log(_data_genres);
    // console.log(_data_project_stages);
    // console.log(_data_categories);
    // console.log(_data_organization_types);

</script>


<!-- CSS -->
<?= $this->Html->css('app/dot.css') ?>

<!-- JAVASCRIPT -->
<?= $this->Html->script('d3/d3.min.js') ?>
<?= $this->Html->script('app/dot/defs.js') ?>
<?= $this->Html->script('app/dot/data.js') ?>
<?= $this->Html->script('app/dot/drawer.js') ?>
<?= $this->Html->script('app/dot/logic.js') ?>
<?= $this->Html->script('app/dot/listeners.js') ?>
<?= $this->Html->script('app/dot/dot.js') ?>

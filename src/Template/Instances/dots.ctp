
<!-- Page Content -->
<div class="fullwidth page-content-dots">

    <div id="dots-div">
        <div class="row expanded" id="viz-header-div">
            <form>
                <div class="small-12 medium-5 columns viz-header-div">
                    <?php 
                    echo $this->Form->input('Filter 1', [
                        'label' => __d('dots', 'Order By'),
                        'id' => 'filter-1',
                        'class' => 'header-filter-select',
                        'options' => [
                            'c' => __d('dots', 'Category'),
                            'o' => __d('dots', 'Organization Type'),
                            'r' => __d('dots', 'Region'),
                            'g' => __d('dots', 'Genre'),
                            's' => __d('dots', 'Stage'),
                        ]
                    ]);
                    ?>
                </div>
                <div class="small-12 medium-2 columns viz-header-div">
                    <button type="button" class="button">
                        <i class='fi-loop'></i>
                    </button>
                </div>
                <div class="small-12 medium-5 columns viz-header-div">
                    <?php 
                    echo $this->Form->input('Filter 2', [
                        'label' => __d('dots', 'Merge with'),
                        'id' => 'filter-2',
                        'class' => 'header-filter-select',
                        'options' => [
                            'c' => __d('dots', 'Category'),
                            'o' => __d('dots', 'Organization Type'),
                            'r' => __d('dots', 'Region'),
                            'g' => __d('dots', 'Genre'),
                            's' => __d('dots', 'Stage'),
                        ]
                    ]);
                    ?>
                </div>
            </form>
        </div>
        <div class="row expanded" id="viz-dots-div" data-equalizer="container">
            <div class="small-12 large-6 columns viz-div" id="viz-left"  data-equalizer-watch="container">
                <div class="small-12 columns viz-svg-div" id="svg-left">
                </div>
            </div>
            <div class="small-12 large-6 columns viz-div" id="viz-right" data-equalizer-watch="container">
                <div class="small-12 columns viz-svg-div" id="svg-right">

                </div>
            </div>
        </div>
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
            <p id="info-country-label"></p>
            <ul id="info-country-ul">
            </ul>
        </div>
        <div class="small-3 medium-2 large-1 columns" id="dots-right-controls">
            <button type="button" class="button" id="show-filters-button">
                <i class='fi-widget'></i>
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
    var _data_countries_f   = <?php echo json_encode($countries_f); ?>;

    // independent
    var _data_genres         = <?php echo json_encode($genres); ?>;
    var _data_project_stages = <?php echo json_encode($project_stages); ?>;

    // instance
    var _data_projects           = <?php echo json_encode($projects); ?>;
    var _data_categories         = <?php echo json_encode($instance->categories); ?>;
    var _data_organization_types = <?php echo json_encode($instance->organization_types); ?>;
    

    // console.log(_data_continents);
    // console.log(_data_subcontinents);
    // console.log(_data_countries);
    // console.log(_data_genres);
    // console.log(_data_project_stages);
    // console.log(_data_categories);
    // console.log(_data_organization_types);

    var _language = "<?= $lang_current ?>";
    function _useSpanish() {
        if (_language == "es") {
            return true;
        };
        return false;
    }

    ///////////////////////////////////////////////////////////////////////////////
    //////////////////// GET DATA HELPERS /////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////

    // generic data by id
    function _getDataById(id, data, name) {
        var matches = $.grep(data, 
            function(e){
                return e.id == id;
            }
        );

        if (matches.length >0) {
            return matches[0];
        };
        if (name) { console.log("Attemped to use undefined data '" + name + "' (id:" + id + ")."); };
        return null;   
    }

    // continents
    function getContinentById(id) {
        return _getDataById(id, _data_continents, 'continent');
    }

    // subcontinents
    function getSubcontinentById(id) {
        return _getDataById(id, _data_subcontinents, 'subcontinent');
    }

    // countries
    function getCountryById(id) {
        return _getDataById(id, _data_countries, 'country');
    }

    // genres
    function getGenreById(id) {
        return _getDataById(id, _data_genres, 'genre');
    }

    // project_stages
    function getProjectStageById(id) {
        return _getDataById(id, _data_project_stages, 'project_stage');
    }

    // categories
    function getCategoryById(id) {
        return _getDataById(id, _data_categories, 'category');
    }

    // organization_types
    function getOrganizationTypeById(id) {
        return _getDataById(id, _data_organization_types, 'organization_type');
    }

    // projects
    function getProjectById(id) {
        return _getDataById(id, _data_projects, 'project');
    }

    // console.log(getProjectById(5));
    // console.log(getContinentById(5));
    // console.log(getSubcontinentById(14));
    // console.log(getCountryById(152));
    // console.log(getGenreById(1));
    // console.log(getProjectStageById(1));
    // console.log(getCategoryById(3));
    // console.log(getOrganizationTypeById(1));



    ///////////////////////////////////////////////////////////////////////////////
    //////////////////// PREPARE DATA /////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////
    function filterValidateOrganizationType(project, organization_type_id) {
        if (project.organization_type_id != organization_type_id) {
            return false;
        };
        return true;
    }

    function filterValidateCategory(project, category_id) {
        var has_category = project.categories.reduce(
            function (result, category) {
                match = category.id == category_id;
                return result || match;
            },
            false
        );
        if (!has_category) { return false; }
        return true;
    }

    function filterValidateProjectStage(project, project_stage_id) {
        if (project.project_stage_id != project_stage_id) {
            return false;
        };
        return true;
    }

    function filterValidateUserGenre(project, user_genre_id) {
        if (project.user.genre_id != user_genre_id) {
            return false;
        };
        return true;
    }

    function filterValidateRegion(project, region_id) {
        country = getCountryById(project.country_id);
        if (!country) { return; }
        // console.log(country);

        subcontinent = getSubcontinentById(country.subcontinent_id);
        if (! subcontinent) { return; }
        // console.log(subcontinent);

        if (subcontinent.continent_id != region_id) {
            return false;
        };
        return true
    }

    function filterValidateCountry(project, country_id) {
        if (project.country_id != country_id) {
            return false;
        };
        return true;
    }


    // create map with {country_id, project_ids_array}
    var n_filtered_projects = _data_projects.length;    
    function filterProjectsData(options) {

        var count = 0;

        // object version
        var _map_by_country = {};
        _data_projects.map(function (project, index) {
            // console.log(project);

            if (options.hasOwnProperty('organization_type_id') && !filterValidateOrganizationType(project, options.organization_type_id)) { return; }
            if (options.hasOwnProperty('category_id')          && !filterValidateCategory        (project, options.category_id         )) { return; }
            if (options.hasOwnProperty('project_stage_id')     && !filterValidateProjectStage    (project, options.project_stage_id    )) { return; }
            if (options.hasOwnProperty('user_genre_id')        && !filterValidateUserGenre       (project, options.user_genre_id       )) { return; }
            if (options.hasOwnProperty('region_id')            && !filterValidateRegion          (project, options.region_id           )) { return; }
            if (options.hasOwnProperty('country_id')           && !filterValidateCountry         (project, options.country_id          )) { return; }

            // ----------------------------------------------------------------
            // project is valid!

            count++;

            // append
            if (_map_by_country[project.country_id] != null) {
                return _map_by_country[project.country_id].push(project.id);
            }
            return _map_by_country[project.country_id] = [project.id];
        });

        // array version
        var map_by_country = []
        Object.keys(_map_by_country).map(function(value, index) {
            map_by_country.push({'id':value, 'projects':_map_by_country[value]});
        });
        
        n_filtered_projects = count;
        return map_by_country;
    }


    function getCountryProjectIds(id) {
        country = _getDataById(id, actual_map_by_country, null);
        // console.log(id);
        // console.log(country);
        if (country) {
            return country.projects;
        };
        // console.log("Attemped to get projects from an inexistent country (id:" + id + ").");
        return null;
    }
    // console.log(getCountryProjectIds(152));
    
</script>


<!-- CSS -->
<?= $this->Html->css('app/dot.css') ?>

<!-- JAVASCRIPT -->
<?= $this->Html->script('d3/d3.min.js') ?>
<?= $this->Html->script('app/dot.js') ?>

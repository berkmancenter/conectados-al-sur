
<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content-map">
    <div class="row expanded">
        <div class="small-12 columns" id="map-column">
            <div id="tooltip-container"></div>
            <div id="svg-div">
                <div class="zoom_buttons">
                    <button type="button" class="warning button" data-zoom="+1">Zoom In</button>
                    <button type="button" class="warning button" data-zoom="-1">Zoom Out</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row expanded" id="map-navbar">
        <div class="small-3 medium-2 large-1 columns" id="map-left-controls" data-equalizer="links">
            <ul class="button-group">
            <?= $this->Html->link("<i class='fi-plus size-36'></i>", [
                'controller' => 'Projects',
                'action' => 'add',
                 $instance->namespace
            ], [
                 'class' => 'secondary button',
                 'escape' => false
                 // 'data-equalizer-watch' => 'links'
            ]) ?>
            <?= $this->Html->link("<i class='fi-graph-pie size-36'></i>", [
                'controller' => 'Instances',
                'action' => 'dots', $instance->namespace
            ], [
                'class' => 'secondary button',
                'escape' => false
                // 'data-equalizer-watch' => 'links'
            ]) ?>
            </ul>
        </div>
        <div class="small-6 medium-8 large-10 columns" id="map-middle-controls">
            <span id="info-country-label"></span>
            <ul id="info-country-ul">
            </ul>
        </div>
        <div class="small-3 medium-2 large-1 columns" id="map-right-controls">
            <button type="button" class="button" id="show-filters-button">
                <i class='fi-widget size-36'></i>
            </button>
            <span id="info-nprojects-txt"><?= __('total projects') ?></span>
            <span id="info-nprojects">0</span>
            <?= $this->Html->link(__('View All'), [
                'controller' => 'Projects',
                'action' => 'index', $instance->namespace
            ], [
                'id' => 'map_project_list_button',
                'target' => '_blank'
            ]) ?>
        </div>
    </div>
    <div class="form" id="filters-div">
        <div class="row expanded">
            <div class="small-12 columns">
                <span id="filters-title"><?= __('Filtering Options') ?></span>
            </div>
        </div>
        <form id="filter-form">
            <div class="row expanded">
                <div class="small-6 medium-4 large-3 columns">
                    <?php 
                    echo $this->Form->input('Organization Type', [
                        // 'class' => 'filter-select',
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
                        'id' => 'filter-country',
                        'empty' => '---',
                        'class' => 'filter-input',
                        'options' => []]
                    );
                    ?>
                </div>
                <div class="small-12 large-6 columns">
                    <button type="button" class="hollow button" id="filter-clear">Clear Filters</button>
                    <button type="button" class="hollow button" id="filter-apply">Apply</button>
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


    var topojson_file = <?php echo json_encode($this->Url->build('/files/world-110m.json')); ?>

    // console.log(_data_continents);
    // console.log(_data_subcontinents);
    // console.log(_data_countries);
    // console.log(_data_genres);
    // console.log(_data_project_stages);
    // console.log(_data_categories);
    // console.log(_data_organization_types);

    var height_footer_logo = 0;
    <?php if (isset($instance) &&
              isset($instance->logo) &&
              !empty($instance->logo)): ?>
        height_footer_logo = 80;
    <?php endif; ?>

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
<?= $this->Html->css('app/map.css') ?>


<!-- JAVASCRIPT -->
<?= $this->Html->script('d3/d3.min.js') ?>
<?= $this->Html->script('topojson/topojson.min.js') ?>

<?= $this->Html->script('app/map_drawers.js') ?>
<?= $this->Html->script('app/map_listeners.js') ?>
<?= $this->Html->script('app/map.js') ?>
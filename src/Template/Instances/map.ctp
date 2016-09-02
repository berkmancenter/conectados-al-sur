
<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<li>
    <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'preview', $instance->namespace]) ?>><i class='fi-home size-16'></i></a>
</li>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content-with-sidebar">

    <div class="off-convas-wrapper">
        <div class="off-convas-wrapper-inner" data-off-canvas-wrapper>

            <div class="off-canvas position-left" id="offCanvas" data-off-canvas>
                <button class="close-button" aria-label="Close menu" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="vertical menu">
                    <li><a href="#">Lorem.</a></li>
                    <li><a href="#">Facilis.</a></li>
                    <li><a href="#">Sed?</a></li>
                    <li><a href="#">Impedit?</a></li>
                    <li><a href="#">Maxime.</a></li>
                </ul>
            </div>

            <div class="off-cavas-content" data-off-canvas-content>
                <div class="row projects-index expanded" data-equalizer="container">
                    <nav class="medium-4 large-3 columns side-nav" id="actions-sidebar" data-equalizer-watch="container">
                        <div class="side-links" data-equalizer="links">
                            <ul class="expanded button-group">
                            <?= $this->Html->link(__('New Project'), [
                                'controller' => 'Projects',
                                'action' => 'add',
                                 $instance->namespace
                            ], [
                                 'class' => 'secondary button',
                                 'data-equalizer-watch' => 'links'
                            ]) ?>
                            <?= $this->Html->link(__('Graph Visualization'), [
                                'controller' => 'Instances',
                                'action' => 'dots', $instance->namespace
                            ], [
                                'class' => 'secondary button',
                                'data-equalizer-watch' => 'links'
                            ]) ?>
                        </ul>
                        </div>
                        <hr>
                        <div class="side-filters">
                            <p id="info-nprojects"></p> <button type="button" class="button" data-toggle="offCanvas">Filter Panel</button>
                        </div>
                        <hr>
                        <div class="side-nav-info">
                            <p id="info-country-label"></p>
                        </div>
                    </nav>
                    <div class="medium-8 large-9 columns projects-map" data-equalizer-watch="container">
                        <div id="tooltip-container"></div>
                        <div id="svg-map">
                            <div class="zoom_buttons">
                                <button type="button" class="warning button" data-zoom="+1">Zoom In</button>
                                <button type="button" class="warning button" data-zoom="-1">Zoom Out</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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


    var topojson_file = <?php echo json_encode($this->Url->build('/files/world-110m.json')); ?>

    // console.log(_data_continents);
    // console.log(_data_subcontinents);
    // console.log(_data_countries);
    // console.log(_data_genres);
    // console.log(_data_project_stages);
    // console.log(_data_categories);
    // console.log(_data_organization_types);



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

    // create map with {country_id, project_ids_array}
    function getCountryProjectsMap() {
        
        // object version
        var _map_by_country = {};
        _data_projects.map(function (project, index) {
            if (_map_by_country[project.country_id] != null) 
                return _map_by_country[project.country_id].push(index);
            return _map_by_country[project.country_id] = [index];
        });

        // array version
        var map_by_country = []
        Object.keys(_map_by_country).map(function(value, index) {
            map_by_country.push({'id':value, 'projects':_map_by_country[value]});
        })

        // console.log(_map_by_country);
        // console.log(map_by_country);
        return map_by_country;
    }

    function getCountryProjectIds(id) {
        country = _getDataById(id, _data_map_by_country, null);
        if (country) {
            return country.projects;
        };
        // console.log("Attemped to get projects from an inexistent country (id:" + id + ").");
        return null;
    }
    var _data_map_by_country = getCountryProjectsMap();
    
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
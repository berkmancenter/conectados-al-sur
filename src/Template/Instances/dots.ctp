
<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<li>
    <a href="<?= $this->Url->build(['controller' => 'Instances', 'action' => 'preview', $instance->namespace]) ?>"><i class='fi-home size-16'></i></a>
</li>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

    <div class="row expanded" data-equalizer="container">
        <div class="small-12 medium-6 columns viz-div" id="viz-left"  data-equalizer-watch="container">
            <div id="svg-left">
                
            </div>
        </div>
        <div class="small-12 medium-6 columns viz-div" id="viz-right" data-equalizer-watch="container">
            <div id="svg-right">
                
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

</script>

<!-- CSS -->
<?= $this->Html->css('app/dot.css') ?>


<!-- JAVASCRIPT -->
<?= $this->Html->script('d3/d3.min.js') ?>
<?= $this->Html->script('app/dot.js') ?>
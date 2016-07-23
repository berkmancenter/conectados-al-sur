<style>

/* = = = = = = = = = = = =  map = = = = = = = = = = = = */

.svg-background {
  /*fill: #3399ff;*/
  fill: lightblue;
}

.country {
  fill: #ddffcc;
}

.country-boundary {
  fill: none;
  stroke: gray;
  stroke-dasharray: 3,4;
  stroke-linejoin: round;
  stroke-width: 1.5px;
}

.country-coastline {
  fill: none;
  stroke: #aaa;
  stroke-linejoin: round;
  stroke-width: 1.5px;
}

#country_tooltip_text {
    fill: black;    
}
#country_tooltip_rect {
    fill: white;
    stroke: gray;
}

/* - - - - - - side-bar - - - - - - */
.side-nav li
{
    background-color: #ccc;
}

.side-nav li a:not(.button)
{
    color: #000;
}
.side-nav li a:hover:not(.button)
{
    color: red;
}
</style>


<?= $this->Html->script('d3/d3.min.js') ?>
<?= $this->Html->script('topojson/topojson.min.js') ?>
<?= $this->Html->script('jquery-3.0.0.min') ?>

<!-- The view title -->
<?= $this->assign('title', 'Projects Map') ?>

<div class="projects index large-9 medium-8 columns content">
    <div id="tooltip-container"></div>
    <div id="svg-map"></div>
</div>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Graph Visualization'), ['action' => 'graph']) ?></li>
    </ul>
    <div class="side-nav-info">
        <p id="info-nprojects"></p>        
    </div>
</nav>


<script>

// d3 hook
// moves a child element to the front
// useful when displaying ocluded data
d3.selection.prototype.moveToFront = function() {
  return this.each(function(){
    this.parentNode.appendChild(this);
  });
};




var projects = <?php echo json_encode($projects); ?>;
//console.log(projects);

// create map with {country_id, project_ids_array}
var _map_by_country = {};
projects.map(function (project, index) {
    if (_map_by_country[project.country_id] != null) 
        return _map_by_country[project.country_id].push(index);
    return _map_by_country[project.country_id] = [index];
});
var map_by_country = []
Object.keys(_map_by_country).map(function(value, index) {
    map_by_country.push({'id':value, 'projects':_map_by_country[value]});
})
//console.log(map_by_country);

d3.select("#info-nprojects")
    .text("# projects: " + projects.length);


// classical margin convention
var availableWidth  = document.getElementById('svg-map').clientWidth;
var availableHeight = document.getElementById('svg-map').clientHeight;
var margin = {top: 0, right: 0, bottom: 0, left: 0},
    width  = availableWidth - margin.left - margin.right,
    height = 700 - margin.top  - margin.bottom;

// zooming behavior
var zoom = d3.zoom()
    .scaleExtent([0.5, 5])
    .translateExtent([[-400, -500], [2500, 900]])
    .on("zoom", zoomed);

// gep projector
var projection = d3.geoEquirectangular()
    .scale(500)
    .translate([1000, 200]);

// geo path helper
var path = d3.geoPath()
    .projection(projection);

// svg viewport
var svg = d3.select("#svg-map")
    .append("svg")
        .attr("width" , width  + margin.left + margin.right )
        .attr("height", height + margin.top  + margin.bottom)
        .style("border", "2px solid"); // border!

// create inner viewport and enable zooming
var outer_g = svg.append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
    .call(zoom);

// svg background for zomming
outer_g.append("g").attr("class", "svg-g-background")
    .append("rect")
        .attr("class", "svg-background")
        .attr("width", width)
        .attr("height", height);

var g = outer_g.append("g").attr("class", "svg-draws");


// queue file loading and set a callback
d3.queue()
    .defer(d3.json, "files/world-110m.json")
    .defer(d3.csv , "files/cow.csv")
    .await(ready);


var countries_data;
function ready(error, world, cow) {
    if (error) return console.error(error);

    ///// data preparation
    ///////////////////////////////////////////

    // countries of the world (make global)
    countries_data = cow;

    // topojson to geojson
    var countries_geojson = topojson.feature(world, world.objects.countries).features;

    // country boundaries
    // filter to reduce the number of boundaries
    // a,b: features on either side of a boundary
    // a === b : exterior boundaries
    // a !== b : interior boundaries
    var borders = topojson.mesh(world, world.objects.countries,
        function(a, b) { return a !== b; }
    )
    var borders_coast = topojson.mesh(world, world.objects.countries,
        function(a, b) { return a === b; }
    )

    ///// countries
    ///////////////////////////////////////////
    // add countries
    g.selectAll(".country")
            .data(countries_geojson)
        .enter().append("path")
            .attr("class", "country")       // class: "country"
            .attr("id", function(d,i) {     // id   : "country-<codN3>"
                return "country-" + d.id;
            })
            .attr("d", path)
            .on("click", countryClickListener)
            .on("mouseover", countryMouseOverListener)
            .on("mouseout", countryMouseOutListener);

    // add countries country boundaries
    g.append("path")
        .datum(borders)
        .attr("d", path)
        .attr("class", "country-boundary");
    g.append("path")
        .datum(borders_coast)
        .attr("d", path)
        .attr("class", "country-coastline");



    ///// pins
    ///////////////////////////////////////////
    var pins = g.selectAll(".project_pin")
            .data(map_by_country, function(d) { return d.id; })
        .enter().append("circle")
            .attr("class","project_pin")
            .attr("cx", function(d,i) {
                var country_id = d.id;
                var sample_proj_id = d.projects[0];
                var coords = [projects[sample_proj_id].country.longitude, projects[sample_proj_id].country.latitude]
                return projection(coords)[0]; 
            })
            .attr("cy", function(d,i) {
                var country_id = d.id;
                var sample_proj_id = d.projects[0];
                var coords = [projects[sample_proj_id].country.longitude, projects[sample_proj_id].country.latitude]
                return projection(coords)[1];
            })
            .attr("r" , function(d,i) {
                var scale = Math.max(Math.min(d.projects.length, 10)*0.15,1.0);
                return 9*scale;
            })
            .style("fill", function(d,i) {
                var max_projs = 10.0;
                var h_maxcolor = 0;
                var h_mincolor = 60;

                var m = (h_mincolor - h_maxcolor)/(1 - max_projs);
                var n = h_mincolor - m*1;

                var h_value = Math.min(d.projects.length, max_projs);
                h_value = m*h_value + n;
                return "hsl(" + h_value + ", 60%, 50%)";
            })
            .style("stroke", "black")
            .style("stroke-width", 1)
            .on("mouseover", pinMouseOverListener)
            .on("mouseout", pinMouseOutListener);


    ///// tooltip 
    ///////////////////////////////////////////
    var tooltip = g.append("g")
        .attr("class", "country_tooltip")
        .style("opacity", 0);
    tooltip.append("rect")
        .attr("id", "country_tooltip_rect");
    tooltip.append("text")
        .attr("id", "country_tooltip_text");


}


///////////////////////////////////////////////////////////////////////////////
//////////////////// LISTENERS  ///////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

// Zoom Function Event Listener
function zoomed() {
    g.attr("transform", d3.event.transform);

    // update pins
    pin_drawer_zoom_update(d3.event.transform);


    var offsets = [30, -30];
    // d3.select("#country_tooltip_text")
    //     .attr("x", proj_coords[0]+offsets[0])
    //     .attr("y", proj_coords[1]+offsets[1]);

    // d3.select("#country_tooltip_rect")
    //     .attr("transform", d3.zoomIdentity);
        // .attr("x", function(d,i) {
        // //     return 0;
        // //  })
        // .attr("width", function(d,i) {
        //     return d3.select(this).attr("_width")/k;
        // })
        // .attr("height", function(d,i) {
        //     return d3.select(this).attr("_height")/k;
        // });
}

////////// COUNTRY LISTENERS //////////////////////////////////////////////////

function countryClickListener(d) {
    // if (active.node() === this) return countryClickListenerReset();
    // active = d3.select(this).classed("active", true);
}

function countryClickListenerReset() {
    // active.classed("active", false);
    // active = d3.select(null);
}

function countryMouseOverListener(d) {    
    country_drawer_paint_active(d.id);
    tooltip_drawer_draw(d.id);    
}

// todo: no desaparecer en caso de estar sobre el tooltip
function countryMouseOutListener(d) {
    country_drawer_paint_normal(d.id);
    tooltip_drawer_remove();
}



////////// PIN LISTENERS //////////////////////////////////////////////////////

function pinMouseOverListener(d) {
    d3.select(this)
        .moveToFront()
        .transition()
            .style("stroke", "blue")
            .style("stroke-width", 5);
    
    // display info
    var infolist = d3.select(".side-nav-info")
        .append("ul").attr("id","country-info")

    var country_id = d.id;
    var sample_proj_id = d.projects[0];
    var country = projects[sample_proj_id].country;
    var nProjects = d.projects.length;

    infolist.append("li").text("Country: " + country.name_en)
    if (nProjects > 1) {
        infolist.append("li").text("# projects: " + nProjects);
        infolist.append("li").text("# authors: " + 0);
        infolist.append("li").text("last modified: " + 0);
        infolist.append("li").text("# finished: " + 0);
        infolist.append("li").text("# categories: " + 0);
    } else{
        var project = projects[sample_proj_id];
        infolist.append("li").text("# projects: 1");
        infolist.append("li").text("project: " + project.name);
        infolist.append("li").text("url: " + project.url);
        infolist.append("li").text("stage: " + project.project_stage.name);
        infolist.append("li").text("org type: " + project.organization_type.name);
        infolist.append("li").text("org name: " + project.organization);
        infolist.append("li").text("user name: " + project.user.name);
        infolist.append("li").text("user mail: " + project.user.email);
        infolist.append("li").text("user main org: " + project.user.main_organization);
        infolist.append("li").text("proj start date: " + project.start_date.substr(0,10));
        infolist.append("li").text("last modification: " + project.modified.substr(0,10));
        
        var cats = infolist.append("li").text("categories: ")
            .append("ul");

        project.categories.forEach(function(item, index) {
            cats.append("li").text("#" + (index + 1) + ": " + item.name);
        });
    };

    // lookup country information
    tooltip_drawer_draw(d.id);
    country_drawer_paint_active(d.id);
}

// todo: no desaparecer en caso de estar sobre el tooltip
function pinMouseOutListener(d) {
    d3.select(this)
        .transition()
            .style("stroke", "black")
            .style("stroke-width", 1);

    d3.select("#country-info").remove();

    tooltip_drawer_remove();
    country_drawer_paint_normal(d.id);
}


///////////////////////////////////////////////////////////////////////////////
//////////////////// DATA    HELPERS //////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

function getCountryByN3(codN3) {

    // lookup country information
    var matches = $.grep(countries_data, 
        function(e){
            return e.codN3 == codN3;
        }
    );
    // countries codes are unique! so there should be a single match
    // otherwise, returns 'undefined'
    return matches[0];
}




///////////////////////////////////////////////////////////////////////////////
//////////////////// DRAWER  HELPERS //////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////
// COUNTRY HELPERS

// highlights the country
function country_drawer_paint_active(codN3) {
    d3.select("#country-" + codN3)
        .transition()
            .duration(250)
            .style("fill", "#99ff66");
}

// resets the country colour
function country_drawer_paint_normal(codN3) {
    d3.select("#country-" + codN3)
        .transition()
            .duration(250)
            .style("fill", "#ddffcc");
}



//////////////////////////////////////////////////////
// TOOLTIP HELPERS

// draws a tooltip with updated data
function tooltip_drawer_draw(codN3) {

    // retrieve country
    country = getCountryByN3(codN3);

    // centroid coordinates
    var coords = [Number(country.lon), Number(country.lat)];
    var proj_coords = projection(coords);

    // draw tooltip
    var offsets = [30, -30];
    d3.select("#country_tooltip_text")
        // .text(country.codA3 + " " + country.codN3)
        .text(country.codA3)
        .attr("x", proj_coords[0]+offsets[0])
        .attr("y", proj_coords[1]+offsets[1]);

    d3.select("#country_tooltip_rect")
        .attr("x", proj_coords[0]-10+offsets[0])
        .attr("y", proj_coords[1]-20+offsets[1])
        .attr("width", 55)
        .attr("height", 30)
        .attr("_x", proj_coords[0]-10+offsets[0])
        .attr("_y", proj_coords[1]-20+offsets[1])
        .attr("_width", 55)
        .attr("_height", 30);

    d3.select(".country_tooltip")
        .style("opacity", 1)
        .moveToFront();
}

// disapears the tooltip
function tooltip_drawer_remove() {
    d3.select(".country_tooltip")
        .style("opacity", 1e-6);
}


//////////////////////////////////////////////////////
// PIN HELPERS

function pin_drawer_zoom_update(transform) {

    var k = d3.event.transform.k;

    g.selectAll(".project_pin")
        .attr("r" , function(d,i) {
                var scale = Math.max(Math.min(d.projects.length, 10)*0.15,1.0);
                return 9*scale/k;
        })
        .attr("stroke-width" , function(d,i) {
                return 1/k;
        });
}

</script>


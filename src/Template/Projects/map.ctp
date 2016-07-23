<style>

/* = = = = = = = = = = = =  map = = = = = = = = = = = = */

.svg-background {
  fill: #3399ff;
}

.country {
  fill: white;
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

function ready(error, world, names) {
    if (error) return console.error(error);

    // topojson to geojson
    // var land      = topojson.feature(world, world.objects.land);
    var countries = topojson.feature(world, world.objects.countries);

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

    // add feature property 'name' to each corresponding country
    countries = countries.features.filter(function(d) {
        // returns true/false if condition is met
        return names.some(function(n) {
            if (d.id == n.codN3) {
                d.properties = n;
                return true;
            }
        });
    })
    // console.log(countries);

    // select countries and:
    // - set class to: .country
    // - set the drawer "d" to: path 
    g.selectAll("path")
            .data(countries)
        .enter().append("path")
            .attr("class", "country")
            .attr("d", path)
            .on("click", countryClickListener)
            .on("mouseover", countryMouseOverListener)
            .on("mouseout", countryMouseOutListener);

    // set .country-boundary and .country-coastline class to borders
    g.append("path")
        .datum(borders)
        .attr("d", path)
        .attr("class", "country-boundary");

    g.append("path")
        .datum(borders_coast)
        .attr("d", path)
        .attr("class", "country-coastline");

    // country name tooltip 
    var tooltip = g.append("g")
        .attr("class", "country_tooltip")
        .style("opacity", 0);
    // tooltip.append("rect")
    //     .attr("id", "country_tooltip_rect");
    tooltip.append("text")
        .attr("id", "country_tooltip_text");


    // pines
    var pins = g.selectAll(".project_pin")
            .data(map_by_country)
        .enter().append("circle")
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
                return 5;
            })
            .style("fill","red")
            .on("mouseover", pinMouseOverListener)
            .on("mouseout", pinMouseOutListener);

}

var preClickTransform;

// Zoom Function Event Listener
function zoomed() {
    g.attr("transform", d3.event.transform);
}

function countryClickListener(d) {
    // if (active.node() === this) return countryClickListenerReset();
    // active = d3.select(this).classed("active", true);
}

function countryClickListenerReset() {
    // active.classed("active", false);
    // active = d3.select(null);
}

function countryMouseOverListener(d) {
    d3.select(this)
        .transition()
                .duration(1000)
                .style("fill", "#ffff99");

    
    // centroid coordinates
    var coords = [Number(d.properties.lon), Number(d.properties.lat)];
    var proj_coords = projection(coords);

    // draw tooltip
    d3.select("#country_tooltip_text")
        .text(d.properties.codA3)
        .attr("x", proj_coords[0])
        .attr("y", proj_coords[1]);

    // d3.select("#country_tooltip_rect")
    //     .attr("x", proj_coords[0]-10)
    //     .attr("y", proj_coords[1]-20)
    //     .attr("width", 55)
    //     .attr("height", 30);

    d3.select(".country_tooltip")
        .style("opacity", 1);

}

// todo: no desaparecer en caso de estar sobre el tooltip
function countryMouseOutListener(d) {
    d3.select(this)
        .transition()
                .duration(1000)
                .style("fill", "white");

    d3.select(".country_tooltip").style("opacity", 1e-6);
}

function pinMouseOverListener(d) {
    d3.select(this)
        .transition()
            .style("fill", "green");
    
    // display info
    var infolist = d3.select(".side-nav-info")
        .append("ul").attr("id","country-info")

    console.log(d);

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
}

// todo: no desaparecer en caso de estar sobre el tooltip
function pinMouseOutListener(d) {
    d3.select(this)
        .transition()
            .style("fill", "red");

    d3.select("#country-info").remove();
}

</script>


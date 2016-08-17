<style>

/* = = = = = = = = = = = =  map = = = = = = = = = = = = */
/* CAS ORANGE: #F26722 */
/* CAS BLUE  : #42C8F4  */

.svg-background { fill: lightblue; }

.country        { fill: #ddffcc; }
.country_hover  { fill: #f79c6e; }
.country_active { fill: #f26722; }


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

<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Project'), ['action' => 'add', $instance_namespace]) ?></li>
        <li><?= $this->Html->link(__('Graph Visualization'), ['action' => 'graph', $instance_namespace]) ?></li>
    </ul>
    <div class="side-nav-info">
        <p id="info-nprojects"></p>
    </div>
</nav>
<div class="projects map large-10 medium-9 columns content">
    <div id="tooltip-container"></div>
    <div id="svg-map"></div>
</div>


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
    .text("Found " + projects.length + " projects");


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
    .defer(d3.json, <?php echo json_encode($this->Url->build('/files/world-110m.json')); ?> )
    .defer(d3.csv , <?php echo json_encode($this->Url->build('/files/cow.csv')); ?> )
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
    var pins = g.selectAll(".country_pin")
            .data(map_by_country, function(d) { return d.id; })
        .enter().append("circle")
            .attr("class","country_pin")    // class: "country_pin"
            .attr("id", function(d,i) {     // id   : "country_pin-<codN3>"
                return "country_pin-" + d.id;
            })
            .attr("cx", function(d,i) {
                var country = getCountryByN3(d.id);
                return projection([country.lon, country.lat])[0]; 
            })
            .attr("cy", function(d,i) {
                var country = getCountryByN3(d.id);
                return projection([country.lon, country.lat])[1];
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
            .on("click", pinClickListener)
            .on("mouseover", pinMouseOverListener)
            .on("mouseout", pinMouseOutListener);


    ///// tooltip 
    ///////////////////////////////////////////
    var tooltip = g.append("g")
        .datum(null)
        .attr("class", "country_tooltip")
        .style("opacity", 0)
        .on("mouseover", tooltipMouseOverListener)
        .on("mouseout", tooltipMouseOutListener);
    tooltip.append("rect")
        .attr("id", "country_tooltip_rect");
    tooltip.append("text")
        .attr("id", "country_tooltip_text");


}



///////////////////////////////////////////////////////////////////////////////
//////////////////// LISTENERS  ///////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

var active_pin = d3.select(null);

var active_id = null;
var current_transform = d3.zoomIdentity;

// countries
var active_country_id = null;

////////// ZOOM LISTENERS //////////////////////////////////////////////////

function zoomed() {
    
    current_transform = d3.event.transform;
    g.attr("transform", d3.event.transform);

    // update other elements on a
    // special way
    pin_drawer_zoom_update(d3.event.transform);
    tooltip_drawer_zoom_update(d3.event.transform);
}

////////// COUNTRY LISTENERS //////////////////////////////////////////////////

function countryClickListener(d) {
    // cases:
    // - clicked the active country: deactivate -> hover
    // - clicked other country: deactivate previous and activate this.
    var clicked_id = d.id;
    if (clicked_id == active_country_id) {
        // deactivate the current one        
        active_country_id = null;
        drawer_country_hover(clicked_id);

    } else {
        // deactivate previous one
        drawer_country_normal(active_country_id);

        // activate the current
        active_country_id = clicked_id;
        drawer_country_active(active_country_id);
    }
}

function countryMouseOverListener(d) {
    var hover_id = d.id;
    if (hover_id != active_country_id) {
        drawer_country_hover(hover_id);
    };
    // tooltip_drawer_draw(d.id);    
}

// todo: no desaparecer en caso de estar sobre el tooltip
function countryMouseOutListener(d) {
    var hover_id = d.id;
    if (hover_id != active_country_id) {
        drawer_country_normal(hover_id);
    };
    // tooltip_drawer_remove();
}



////////// PIN LISTENERS //////////////////////////////////////////////////////

function pinClickListener(d) {
}

function pinMouseOverListener(d) {
    
    pin_drawer_active(d.id);

    // show tooltip and redraw country 
    tooltip_drawer_draw(d.id);
    country_drawer_paint_active(d.id);

    projects_info_display(d);
}

// todo: no desaparecer en caso de estar sobre el tooltip
function pinMouseOutListener(d) {
    
    pin_drawer_normal(d.id);

    projects_info_clear();

    // reset stuff
    tooltip_drawer_remove();
    country_drawer_paint_normal(d.id);
}


////////// TOOLTIP LISTENERS //////////////////////////////////////////////////

function tooltipMouseOverListener(d) {
    
    // pin_drawer_active(d);

    // show tooltip and redraw country 
    tooltip_drawer_draw(d);
    country_drawer_paint_active(d);

    // projects_info_display(d);
}

// todo: no desaparecer en caso de estar sobre el tooltip
function tooltipMouseOutListener(d) {
    
    // pin_drawer_normal(d);

    projects_info_clear();

    // reset stuff
    tooltip_drawer_remove();
    country_drawer_paint_normal(d);
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
function drawer_country_active(codN3) {
    if (codN3 == null) { return; };
    d3.select("#country-" + codN3).classed("country_active", true);
    d3.select("#country-" + codN3).classed("country_hover", false);
}

// highlights the country if not active
function drawer_country_hover(codN3) {
    if (codN3 == null) { return; };
    d3.select("#country-" + codN3).classed("country_active", false);
    d3.select("#country-" + codN3).classed("country_hover", true);
}

// resets the country colour
function drawer_country_normal(codN3) {
    if (codN3 == null) { return; };
    d3.select("#country-" + codN3).classed("country_active", false);
    d3.select("#country-" + codN3).classed("country_hover", false);
}



//////////////////////////////////////////////////////
// TOOLTIP HELPERS

// draws a tooltip with updated data
function tooltip_drawer_draw(codN3) {

    // retrieve country
    var country = getCountryByN3(codN3);
    var coords  = projection([country.lon, country.lat]);

    // draw tooltip
    var k = current_transform.k;
    var dx = 20/k;
    var dy = 20/k;
    var tw = 120/k;
    var th = 30/k;
    var mleft = 15/k;
    var mbottom = 10/k;
    var nodeFontSize = 12/k;

    d3.select("#country_tooltip_rect")
        .attr("x", coords[0]+dx)
        .attr("y", coords[1]-(th+dy))
        .attr("width", tw)
        .attr("height", th);

    // n asociated projects
    _projects = _map_by_country[country.codN3];
    nProjects = 0
    if ( _projects != null) {
        nProjects = _projects.length;
    }
    projects_word = nProjects == 1 ? "project" : "projects" ;

    d3.select("#country_tooltip_text")
        .text(country.codA3 + " (" + nProjects + " " + projects_word + ")")
        .attr("x", coords[0]+(dx+mleft))
        .attr("y", coords[1]-(dy+mbottom))
        .attr("font-size", nodeFontSize + "px");

    d3.select(".country_tooltip")
        .datum(codN3)
        .style("opacity", 1)
        .attr("transform", d3.zoomIdentity) // reapear!
        .moveToFront();
}

// disapears the tooltip
function tooltip_drawer_remove() {
    d3.select(".country_tooltip")
        .style("opacity", 1e-6)
        // trick to desapear from svg!
        .attr("transform", d3.zoomIdentity.translate(10*width,10*height));
}

function tooltip_drawer_zoom_update(transform) {
    if (active_id != null) {
        tooltip_drawer_draw(active_id);
    } else {
        tooltip_drawer_remove();
    }
}


//////////////////////////////////////////////////////
// PIN HELPERS

function pin_drawer_normal(codN3) {
    
    active_pin.transition()
        .style("stroke", "black")
        .style("stroke-width",  function(d,i) {
            return 1/current_transform.k;
        });

    active_pin = d3.select(null);
}

function pin_drawer_active(codN3) {

    active_pin = d3.select("#country_pin-" + codN3);

    active_pin
        .moveToFront()
        .transition()
            .style("stroke", "blue")
            .style("stroke-width", function(d,i) {
                return 5/current_transform.k;
            });

}

function pin_drawer_zoom_update(transform) {

    g.selectAll(".country_pin")
        .attr("r" , function(d,i) {
                var scale = Math.max(Math.min(d.projects.length, 10)*0.15,1.0);
                return 9*scale/transform.k;
        })
        .style("stroke-width", function(d,i) {
                return 1/transform.k;
        });

    // this pin will have a different stroke-width
    active_pin
        .style("stroke-width", function(d,i) {
                return 5/transform.k;
        });
}



///////////////////////////////////////////////////////////////////////////////
//////////////////// INFORMATION  HELPERS//////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

function projects_info_clear() {
    d3.select("#country-info").remove();
}

function projects_info_display(map_item) {
    
    var country = getCountryByN3(map_item.id);
    var project_idxs = map_item.projects;
    var nProjects = project_idxs.length;

    var curr_projects = [];
    project_idxs.forEach(function (item, index) {
        curr_projects.push(projects[item]);
    });
    //console.log(curr_projects);

    var infolist = d3.select(".side-nav-info")
        .append("ul").attr("id","country-info")

    infolist.append("li").text("Country: " + country.name_en)
    if (nProjects > 1) {

        author_ids = {};
        categories = {};
        last_update = new Date(0);

        curr_projects.forEach(function (item, index) {
            
            // console.log(item);

            // author set (using dictionary as set)
            author_ids[item.user_id] = 0;

            // fill categories
            Object.keys(item.categories).forEach(function (cat_item_id, cat_index) {
                cat_id = item.categories[cat_item_id].id;
                cat_name = item.categories[cat_item_id].name;
                categories[cat_id] = cat_name;
            });

            modified = new Date(item.modified);
            last_update = last_update > modified ? last_update : modified;
        });
        // console.log(categories);

        //console.log(map_item.projects);
        infolist.append("li").text("Projects: " + nProjects);
        infolist.append("li").text("Authors: " + Object.keys(author_ids).length);
        infolist.append("li").text("Last Update: " + last_update.toDateString());
        infolist.append("li").text("Categories: " + Object.keys(categories).length);
        // infolist.append("li").text("Finished: " + 0);
    } else{

        var project = curr_projects[0];
        //console.log(project);

        var proj_description_max = 100;
        var proj_description = project.description.substring(0,proj_description_max);
        if (project.description.length > proj_description_max) {
            proj_description += "...";
        };

        infolist.append("li").text("Project: " + project.name);
        infolist.append("li").text(proj_description);
        infolist.append("li").text("Organization: " + project.organization);
        // infolist.append("li").text("stage: " + project.project_stage.name);
        // infolist.append("li").text("org type: " + project.organization_type.name);
        // infolist.append("li").text("user name: " + project.user.name);
        // infolist.append("li").text("user mail: " + project.user.email);
        // infolist.append("li").text("user main org: " + project.user.main_organization);
        // infolist.append("li").text("proj start date: " + project.start_date.substr(0,10));
        // infolist.append("li").text("last modification: " + project.modified.substr(0,10));
        var cats = infolist.append("li").text("Categories: ")
            .append("ul");

        project.categories.forEach(function(item, index) {
            cats.append("li").text("#" + (index + 1) + ": " + item.name);
        });
        infolist.append("li").append("a")
            .text("Complete info ...")
            .attr("href", "projects/" + project.id);
    };
}


</script>


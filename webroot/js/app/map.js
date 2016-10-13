///////////////////////////////////////////////////////////////////////////////
//////////////////// MAP CONFIGS //////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

var country_pin = {};
country_pin.normal = {}; country_pin.hover = {}; country_pin.active = {};
country_pin.normal.stroke = "#000000"; country_pin.normal.stroke_width = 0;
country_pin.hover.stroke  = "#ffffff"; country_pin.hover.stroke_width  = 2;
country_pin.active.stroke = "#086f91"; country_pin.active.stroke_width = 3;



///////////////////////////////////////////////////////////////////////////////
//////////////////// D3 ///////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

// d3 hook
// moves a child element to the front
// useful when displaying ocluded data
d3.selection.prototype.moveToFront = function() {
  return this.each(function(){
    this.parentNode.appendChild(this);
  });
};

var context = {}
context.svg_div = document.getElementById('svg-div');


// zooming behavior
var zoom = d3.zoom()
    .scaleExtent([0.8, 5])
    .translateExtent([[-400, -500], [2500, 900]])
    .on("zoom", zoomed);


// geo projector
var projection = d3.geoEquirectangular()
    .scale(500)
    .translate([1000, 200]);


// geo path helper
var path = d3.geoPath()
    .projection(projection);


// svg viewport
var svg = d3.select("#svg-div").append("svg")
    .attr("id", "svg-root");

// create inner viewport and enable zooming
var outer_g = svg.append("g").call(zoom);

// svg background for zomming
var svg_background = outer_g
    .append("g").attr("class", "svg-g-background")
    .append("rect").attr("class", "svg-background");

d3.selectAll("button[data-zoom]")
    .on("click", zoomButtonListener);

var g = outer_g.append("g").attr("class", "svg-draws");


// queue file loading and set a callback
d3.queue()
    .defer(d3.json, topojson_file)
    .await(ready);


// window resize listener
update_window();
window.addEventListener("resize", update_window);

// show filters button
var showingFilters = false;
function filterShowListener() {
    // d3.select('#map-navbar').style("display", 'none');

    if (showingFilters) {
        d3.select('#filters-div').style("display", 'none');
    } else {
        d3.select('#filters-div').style("display", 'block');
    };
    showingFilters = !showingFilters;
    update_window();
}
document.getElementById('show-filters-button').addEventListener("click", filterShowListener);

function update_window() {

    var totalWidth  = window.innerWidth;
    var totalHeight = window.innerHeight;
    var height_topbar = document.getElementById("top-bar-div").clientHeight;
    var height_infodiv = 150;
    var height_filterdiv = 205;
    var height_footer = 37;
    height_footer_logo = 0; // hide footer logo
    if (totalWidth < 640) {
        height_footer = 228 - 75;  // footer is taller on small devices;
        height_filterdiv = 342;    // filter window is 342px height on small
    } else if (totalWidth < 1024) {
        height_filterdiv = 262;    // filter window is 262px height on medium
    };

    var height_footer_full = height_footer + height_footer_logo + height_infodiv;
    if (showingFilters) { height_footer_full += height_filterdiv; }

    // current size
    var width  = context.svg_div.clientWidth;
    var height = totalHeight - height_topbar - height_footer_full;
    // classical margin convention
    var margin = {top: 0, right: 0, bottom: 0, left: 0};
    var padded_width  = width  - margin.left - margin.right;
    var padded_height = height - margin.top  - margin.bottom;

    svg
        .attr("width" , padded_width  + margin.left + margin.right )
        .attr("height", padded_height + margin.top  + margin.bottom);

    outer_g
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    svg_background
        .attr("width",  padded_width)
        .attr("height", padded_height);

    // set sizes
    context.width  = padded_width;
    context.height = padded_height;
}


function ready(error, world) {
    if (error) return console.error(error);

    ///// data preparation
    ///////////////////////////////////////////

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
    filterClearOptions();
    filterApplyOptions();


    ///// tooltip 
    /////////////////////////////////////////////
    var tooltip = g.append("g")
        .datum(null)
        .attr("class", "country_tooltip")
        .style("opacity", 0)
        .on("mouseover", tooltipMouseOverListener)
        .on("mouseout", tooltipMouseOutListener);
    tooltip.append("rect").attr("id", "country_tooltip_rect");
    tooltip.append("text").attr("id", "country_tooltip_text");


    //// info bar
    /////////////////////////////////////////////
    projects_info_clear();
}


var filtering_options = {};
function update_world(options) {

    // data join
    var markers = g.selectAll(".country_pin")
            .data(actual_map_by_country, function(d) { return d.id; });

    // enter
    markers.enter().append("circle")
        .attr("class","country_pin node")  // class: "country_pin"
        .attr("id", function(d,i) {        // id   : "country_pin-<codN3>"
            return "country_pin-" + d.id;
        })
        .attr("cx", function(d,i) {
            var country = getCountryById(d.id);
            if (country == null) { return 0; };
            return projection([country.longitude, country.latitude])[0]; 
        })
        .attr("cy", function(d,i) {
            var country = getCountryById(d.id);
            if (country == null) { return 0; };
            return projection([country.longitude, country.latitude])[1];
        })
        .attr("r" , function(d,i) {
            var scale = Math.max(Math.min(d.projects.length, 10)*0.15,1.0);
            return 9*scale/current_transform.k;
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
        .style("stroke-width", country_pin.normal.stroke_width/current_transform.k)
        .on("click", pinClickListener)
        .on("mouseover", pinMouseOverListener)
        .on("mouseout", pinMouseOutListener);


    // enter + update
    // markers.merge(markers)
        // .foo

    // exit
    markers.exit().remove();


    // update zoom position and mark
    if (options && options.hasOwnProperty('country_id')) { 
        var country_id = options.country_id;
        zoomToCountry(country_id);
        mapActivateCountry(country_id);
    }

    // update information
    d3.select("#info-nprojects").text(n_filtered_projects);

    // update view all button link
    filter_query = "projects?";
    if (options.hasOwnProperty('user_genre_id'))        { filter_query += "&g=" + options.user_genre_id;         }
    if (options.hasOwnProperty('organization_type_id')) { filter_query += "&o=" + options.organization_type_id   }
    if (options.hasOwnProperty('category_id'))          { filter_query += "&t=" + options.category_id            }
    if (options.hasOwnProperty('project_stage_id'))     { filter_query += "&s=" + options.project_stage_id       }
    var view_all_button = document.getElementById('map_project_list_button');
    view_all_button.href =  filter_query;
    // console.log(view_all_button);


    filtering_options = options;
    projects_info_display(active_country_id);
}

function zoomToCountry(country_id) {

    country = getCountryById(country_id);
    if (!country) { return; }
    // console.log("zooming to id: " + country_id);

    // zoom
    point = projection([country.longitude, country.latitude]);
    transform = d3.zoomIdentity
      .translate(context.width / 2, context.height / 2)
      .scale(6)
      .translate(-point[0], -point[1]);
    outer_g.transition().duration(750).call(zoom.transform, transform);
    // zoom.transform(outer_g.transition().duration(750), d3.zoomIdentity);

    // record new state
    current_transform = transform;
}


///////////////////////////////////////////////////////////////////////////////
//////////////////// DATA FILTERING  //////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
d3.select("#filter-clear").on("click", filterClearOptions);
d3.select("#filter-apply").on("click", filterApplyOptions);
d3.select("#filter-region").on("change", filterUpdateRegion);


// -------------------------- clear  -------------------------------
function filterClearOptions() {
    document.getElementById("filter-form").reset();
    filterUpdateRegion();
}

// -------------------------- apply  -------------------------------
function filterApplyOptions() {

    options = filterParseOptions();   

    actual_map_by_country = filterProjectsData(options);
    update_world(options);
}

// -------------------------- parse form ---------------------------
function filterParseOptions() {
    
    var options = {};

    // organization type
    var orgtype = document.getElementById("filter-orgtype").value;
    if (orgtype) { options.organization_type_id = orgtype; };
    
    // category
    var category = document.getElementById("filter-category").value;
    if (category) { options.category_id = category; };

    // project_stage
    var stage = document.getElementById("filter-stage").value;
    if (stage) { options.project_stage_id = stage; };
    
    // user genre
    var genre = document.getElementById("filter-genre").value;
    if (genre) { options.user_genre_id = genre; };

    // region
    var region = document.getElementById("filter-region").value;
    if (region) { options.region_id = region; };

    // country
    var country = document.getElementById("filter-country").value;
    if (country) { options.country_id = country; };

    // console.log(options);
    return options;
}

// -------------------------- location interaction -------------------------------

function filterClearSelectOption(selector_id) {
    $('#' + selector_id + ' option').prop('selected', function() {
        return this.defaultSelected;
    });
}

function getRegionSubcontinentIds(region_id) {
    var valid_subcontinent_ids = [];
    _data_subcontinents.map(
        function(subcontinent) {
            var continent_id = subcontinent.continent_id;
            if (region_id == "" || region_id == continent_id) {
                valid_subcontinent_ids.push(subcontinent.id);
            }
        }
    );
    // console.log(valid_subcontinent_ids);
    return valid_subcontinent_ids;
}

function getSubcontinentCountryIds(subcontinent_ids) {
    var valid_country_ids = [];
    _data_countries.map(
        function(country) {
            var subcontinent_id = country.subcontinent_id;
            if (subcontinent_ids.includes(subcontinent_id)) {
                valid_country_ids.push(country.id);
            }
        }
    );
    // console.log(valid_country_ids);
    return valid_country_ids;
}

function filterUpdateCountriesSelector(country_ids) {

    var countries = d3.select("#filter-country")
        .selectAll(".country_selector")
        .data(country_ids);

    // append options and update value, text
    countries
        .enter().append("option")
            .attr("class", "country_selector")
        .merge(countries)
            .attr("value", function(d,i) {
                return d;
            })
            .text(function(d,i) {
                country = getCountryById(d);
                // console.log("id: " + d + ", name: " + country.name);
                return country.name;
            });

    // remove remaining options
    countries.exit().remove();
}

function filterUpdateRegion() {

    // reset country selector
    filterClearSelectOption("filter-country");

    // get valid countries
    var region_id = document.getElementById("filter-region").value;
    valid_subcontinent_ids = getRegionSubcontinentIds(region_id);
    valid_country_ids      = getSubcontinentCountryIds(valid_subcontinent_ids);

    // update selector
    filterUpdateCountriesSelector(valid_country_ids);
}


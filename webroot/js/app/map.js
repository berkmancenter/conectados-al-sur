
d3.select("#info-nprojects")
    .text("Found " + _data_projects.length + " projects");


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


// geo projector
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
        .attr("height", height + margin.top  + margin.bottom);


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

d3.selectAll("button[data-zoom]")
    .on("click", zoomButtonListener);

var g = outer_g.append("g").attr("class", "svg-draws");


// queue file loading and set a callback
d3.queue()
    .defer(d3.json, topojson_file)
    .await(ready);


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
    var pins = g.selectAll(".country_pin")
            .data(_data_map_by_country, function(d) { return d.id; })
        .enter().append("circle")
            .attr("class","country_pin")    // class: "country_pin"
            .attr("id", function(d,i) {     // id   : "country_pin-<codN3>"
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






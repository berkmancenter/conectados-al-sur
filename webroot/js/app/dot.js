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
var availableWidth  = document.getElementById('svg-left').clientWidth;
var availableHeight = document.getElementById('svg-right').clientHeight;
var margin = {top: 0, right: 0, bottom: 0, left: 0},
    width  = availableWidth - margin.left - margin.right,
    height = 700 - margin.top  - margin.bottom;


// svg viewports
var svg_left = d3.select("#svg-left")
    .append("svg")
        .attr("width" , width  + margin.left + margin.right )
        .attr("height", height + margin.top  + margin.bottom);
var svg_right = d3.select("#svg-right")
    .append("svg")
        .attr("width" , width  + margin.left + margin.right )
        .attr("height", height + margin.top  + margin.bottom);

var sim_left = d3.forceSimulation()
    .force("link", d3.forceLink().id(function(d) { return d.id; }))
    .force("charge", d3.forceManyBody())
    .force("center", d3.forceCenter(width / 2, height / 2));


d3.json("miserables.json", function(error, graph) {
  if (error) throw error;

  var link = svg.append("g")
      .attr("class", "links")
    .selectAll("line")
    .data(graph.links)
    .enter().append("line");

  var node = svg.append("g")
      .attr("class", "nodes")
    .selectAll("circle")
    .data(graph.nodes)
    .enter().append("circle")
      .attr("r", 2.5)
      .call(d3.drag()
          .on("start", dragstarted)
          .on("drag", dragged)
          .on("end", dragended));

  node.append("title")
      .text(function(d) { return d.id; });

  simulation
      .nodes(graph.nodes)
      .on("tick", ticked);

  simulation.force("link")
      .links(graph.links);

  function ticked() {
    link
        .attr("x1", function(d) { return d.source.x; })
        .attr("y1", function(d) { return d.source.y; })
        .attr("x2", function(d) { return d.target.x; })
        .attr("y2", function(d) { return d.target.y; });

    node
        .attr("cx", function(d) { return d.x; })
        .attr("cy", function(d) { return d.y; });
  }
});

function dragstarted(d) {
  if (!d3.event.active) simulation.alphaTarget(0.3).restart();
  d.fx = d.x;
  d.fy = d.y;
}

function dragged(d) {
  d.fx = d3.event.x;
  d.fy = d3.event.y;
}

function dragended(d) {
  if (!d3.event.active) simulation.alphaTarget(0);
  d.fx = null;
  d.fy = null;
}


// ///// countries
// ///////////////////////////////////////////
// // add countries
// g.selectAll(".country")
//         .data(countries_geojson)
//     .enter().append("path")
//         .attr("class", "country")       // class: "country"
//         .attr("id", function(d,i) {     // id   : "country-<codN3>"
//             return "country-" + d.id;
//         })
//         .attr("d", path)
//         .on("click", countryClickListener)
//         .on("mouseover", countryMouseOverListener)
//         .on("mouseout", countryMouseOutListener);

// // add countries country boundaries
// g.append("path")
//     .datum(borders)
//     .attr("d", path)
//     .attr("class", "country-boundary");
// g.append("path")
//     .datum(borders_coast)
//     .attr("d", path)
//     .attr("class", "country-coastline");



// ///// pins
// ///////////////////////////////////////////
// update_world();


// ///// tooltip 
// /////////////////////////////////////////////
// var tooltip = g.append("g")
//     .datum(null)
//     .attr("class", "country_tooltip")
//     .style("opacity", 0)
//     .on("mouseover", tooltipMouseOverListener)
//     .on("mouseout", tooltipMouseOutListener);
// tooltip.append("rect").attr("id", "country_tooltip_rect");
// tooltip.append("text").attr("id", "country_tooltip_text");


// //// info bar
// /////////////////////////////////////////////
// projects_info_clear();


// function update_world(map_by_country) {

//     // data join
//     var markers = g.selectAll(".country_pin")
//             .data(actual_map_by_country, function(d) { return d.id; });

//     // update
//     // markers.attr("class", "updated");

//     // enter
//     markers.enter().append("circle")
//         .attr("class","country_pin node")  // class: "country_pin"
//         .attr("id", function(d,i) {        // id   : "country_pin-<codN3>"
//             return "country_pin-" + d.id;
//         })
//         .attr("cx", function(d,i) {
//             var country = getCountryById(d.id);
//             if (country == null) { return 0; };
//             return projection([country.longitude, country.latitude])[0]; 
//         })
//         .attr("cy", function(d,i) {
//             var country = getCountryById(d.id);
//             if (country == null) { return 0; };
//             return projection([country.longitude, country.latitude])[1];
//         })
//         .attr("r" , function(d,i) {
//             var scale = Math.max(Math.min(d.projects.length, 10)*0.15,1.0);
//             return 9*scale/current_transform.k;
//         })
//         .style("fill", function(d,i) {
//             var max_projs = 10.0;
//             var h_maxcolor = 0;
//             var h_mincolor = 60;

//             var m = (h_mincolor - h_maxcolor)/(1 - max_projs);
//             var n = h_mincolor - m*1;

//             var h_value = Math.min(d.projects.length, max_projs);
//             h_value = m*h_value + n;
//             return "hsl(" + h_value + ", 60%, 50%)";
//         })
//         .style("stroke", "black")
//         .style("stroke-width", country_pin.normal.stroke_width/current_transform.k)
//         .on("click", pinClickListener)
//         .on("mouseover", pinMouseOverListener)
//         .on("mouseout", pinMouseOutListener);


//     // enter + update
//     // markers.merge(markers)
//         // .foo

//     // exit
//     markers.exit().remove();

//     projects_info_display(active_country_id);
// }





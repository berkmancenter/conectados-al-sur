///////////////////////////////////////////////////////////////////////////////
//////////////////// CONFIGS //////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

// show filters button
var showingFilters = false;


var context = {}
context.svg_div = document.getElementById('dots-div');

// svg viewports
var svg1 = d3.select("#svg-left").append("svg").attr("id", "svg-left-root");
var svg2 = d3.select("#svg-right").append("svg").attr("id", "svg-right-root");


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



///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

update_window();

// window resize listener
window.addEventListener("resize", update_window);

document.getElementById('show-filters-button').addEventListener("click", filterShowListener);


var nodes = d3.range(50).map(function(i) {
  return {
    id: i
  };
});

var links = d3.range(nodes.length).map(function(i) {
  return {
    source: i,
    target: i%10
  };
});


var width  = +svg1.node().getBoundingClientRect().width,
    height = +svg1.node().getBoundingClientRect().height;



// force simulator
var simulation = d3.forceSimulation();


// svg objects
var link, node;
// the data - an object with nodes and links
var graph = {};
graph.nodes = nodes;
graph.links = links;

// values for all forces
forceProperties = {
    center: { x: 0.5, y: 0.5},
    charge: { enabled: true, strength: -45, distanceMin: 0, distanceMax: 200 },
    collide: { enabled: true, strength: 20, iterations: 1, radius: 8 },
    link: {  enabled: true, distance: 30, iterations: 1 }
}

initializeDisplay();
initializeSimulation();



// set up the simulation and event to update locations after each tick
function initializeSimulation() {
  simulation.nodes(graph.nodes);
  initializeForces();
  simulation.on("tick", ticked);
}

// add forces to the simulation
function initializeForces() {
    // add forces and associate each with a name
    simulation
        .force("link", d3.forceLink())
        .force("charge", d3.forceManyBody())
        .force("collide", d3.forceCollide())
        .force("center", d3.forceCenter());
    // apply properties to each of the forces
    updateForces();
}

// apply new force properties
function updateForces() {
    // get each force by name and update the properties
    simulation.force("center")
        .x(width * forceProperties.center.x)
        .y(height * forceProperties.center.y);
    simulation.force("charge")
        .strength(forceProperties.charge.strength * forceProperties.charge.enabled)
        .distanceMin(forceProperties.charge.distanceMin)
        .distanceMax(forceProperties.charge.distanceMax);
    simulation.force("collide")
        .strength(forceProperties.collide.strength * forceProperties.collide.enabled)
        .radius(forceProperties.collide.radius)
        .iterations(forceProperties.collide.iterations);
    simulation.force("link")
        .id(function(d) {return d.id;})
        .distance(forceProperties.link.distance)
        .iterations(forceProperties.link.iterations)
        .links(forceProperties.link.enabled ? graph.links : []);

    // updates ignored until this is run
    // restarts the simulation (important if simulation has already slowed down)
    simulation.alpha(1).restart();
}

//////////// DISPLAY ////////////

// generate the svg objects and force simulation
function initializeDisplay() {
  // set the data and properties of link lines
  link = svg1.append("g")
        .attr("class", "links")
    .selectAll("line")
    .data(graph.links)
    .enter().append("line");

  // set the data and properties of node circles
  node = svg1.append("g")
        .attr("class", "nodes")
    .selectAll("circle")
    .data(graph.nodes)
    .enter().append("circle")
        .call(d3.drag()
            .on("start", dragstarted)
            .on("drag", dragged)
            .on("end", dragended));

  // node tooltip
  node.append("title")
      .text(function(d) { return d.id; });
  // visualize the graph
  updateDisplay();
}

// update the display based on the forces (but not positions)
function updateDisplay() {
    node
        .attr("r", forceProperties.collide.radius)
        .attr("stroke", forceProperties.charge.strength > 0 ? "blue" : "red")
        .attr("stroke-width", forceProperties.charge.enabled==false ? 0 : Math.abs(forceProperties.charge.strength)/15);

    link
        .attr("stroke-width", forceProperties.link.enabled ? 1 : .5)
        .attr("opacity", forceProperties.link.enabled ? 1 : 0);
}

// update the display positions after each simulation tick
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


//////////// UI EVENTS ////////////

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
  if (!d3.event.active) simulation.alphaTarget(0.0001);
  d.fx = null;
  d.fy = null;
}


// convenience function to update everything (run after UI input)
function updateAll() {
    updateForces();
    updateDisplay();
}





















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
function update_window() {

    var totalWidth  = window.innerWidth;
    var totalHeight = window.innerHeight;
    var height_topbar = document.getElementById("top-bar-div").clientHeight;
    var height_filter_header = 70 + 30;
    var height_infodiv = 120;
    var height_filterdiv = 205;
    if (totalWidth < 640) {
        height_filterdiv = 342;    // filter window is 342px height on small
    } else if (totalWidth < 1024) {
        height_filterdiv = 262;    // filter window is 262px height on medium
    };

    var height_footer_full = height_infodiv;
    if (showingFilters) { height_footer_full += height_filterdiv; }

    // current size
    var width  = context.svg_div.clientWidth;
    var height = totalHeight - height_topbar - height_filter_header - height_footer_full;
    
    var svg_width = document.getElementById("svg-left").clientWidth;
    svg1
        .attr("width" , svg_width)
        .attr("height", height);
    svg2
        .attr("width" , svg_width)
        .attr("height", height);

    // $("#dots-div").css("width", padded_width);
    $("#viz-dots-div").css("height", height);

    // ensure 0 padding.. ensure for removed footer
    $("#content").css("padding-bottom", 0);


    // set sizes
    context.width  = width;
    context.height = height;
}

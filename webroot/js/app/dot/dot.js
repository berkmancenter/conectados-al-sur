///////////////////////////////////////////////////////////////////////////////
//////////////////// CONFIGS //////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////


// show filters button
context.showingFilters = false;

context.svg_div = document.getElementById('dots-div');

// svg viewports
var svg_a = d3.select("#svg-left").append("svg").attr("id", "svg-left-root");
var svg_b = d3.select("#svg-right").append("svg").attr("id", "svg-right-root");
var nodes_group_a = svg_a.append("g").attr("class", "nodes_group");
var nodes_group_b = svg_b.append("g").attr("class", "nodes_group");
var label_group_a = svg_a.append("g").attr("class", "labels_group");
var label_group_b = svg_b.append("g").attr("class", "labels_group");

///////////////////////////////////////////////////////////////////////////////
// PREPARATION
///////////////////////////////////////////////////////////////////////////////

// load default filter options
filtersUpdate();

// prepare viewport
update_window();


///////////////////////////////////////////////////////////////////////////////
// FIRST TIME RUN
///////////////////////////////////////////////////////////////////////////////

// parse classes and generate nodes
var a_classes = [];
var b_classes = [];
[nodes_a, nodes_b] = [[], []];

// draw nodes
var d3_nodes_a = d3.select(null);
var d3_nodes_b = d3.select(null);

// simulations
var simulation_a = createSimulation(nodes_a, "a");
var simulation_b = createSimulation(nodes_b, "b");

updateSVGs();


///////////////////////////////////////////////////////////////////////////////
// EVENTS
///////////////////////////////////////////////////////////////////////////////

window.addEventListener("resize", update_window);
document.getElementById('show-filters-button').addEventListener("click", filterShowListener);
document.getElementById('switch_button').addEventListener("click", filterSwitchListener);
document.getElementById('filter_a').addEventListener("change", filterChangeListener);
document.getElementById('filter_b').addEventListener("change", filterChangeListener);
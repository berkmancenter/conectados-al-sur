///////////////////////////////////////////////////////////////////////////////
//////////////////// CONFIGS //////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

context.current_max_nodes = context.max_nodes;
context.projects = _data_projects;

// show filters button
context.showingFilters = false;

context.svg_div = document.getElementById('viz-dots-row');

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
topSelectorsUpdate();


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


//// info bar
/////////////////////////////////////////////
infobar_clear();


///// filters
///////////////////////////////////////////
filterClearOptions();
filterApplyOptions();


// update_window();



///////////////////////////////////////////////////////////////////////////////
// EVENTS
///////////////////////////////////////////////////////////////////////////////

// resize
window.addEventListener("resize", function () {
	
	if (context.last_window_width !== undefined) {
    
        // prevent update if resize is too small 
        var width_diff = Math.abs(context.last_window_width - window.innerWidth);
        var height_diff = Math.abs(context.last_window_height - window.innerHeight);
        if (Math.max(height_diff, width_diff) < 100) {
            return;
        }
    }
    context.last_window_width = window.innerWidth;
    context.last_window_height = window.innerHeight;
    updateSVGs();
});

// top bar selectors
document.getElementById('switch_button').addEventListener("click", filterSwitchListener);
document.getElementById('filter_a').addEventListener("change", filterChangeListener);
document.getElementById('filter_b').addEventListener("change", filterChangeListener);

// data filters
document.getElementById('show-filters-button').addEventListener("click", filterShowListener);
document.getElementById('filter-clear').addEventListener("click", filterClearOptions);
document.getElementById('filter-apply').addEventListener("click", filterApplyOptions);
document.getElementById('filter-region').addEventListener("change", filterUpdateRegion);


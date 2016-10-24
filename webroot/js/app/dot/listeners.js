///////////////////////////////////////////////////////////////////////////////
//////////////////// WINDOW      //////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

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
    if (context.showingFilters) { height_footer_full += height_filterdiv; }

    // current size
    var width  = context.svg_div.clientWidth;
    var height = totalHeight - height_topbar - height_filter_header - height_footer_full;
    
    var svg_width = document.getElementById("svg-left").clientWidth;
    svg_height = height;
    svg_a
        .attr("width" , svg_width)
        .attr("height", svg_height);
    svg_b
        .attr("width" , svg_width)
        .attr("height", svg_height);

    // $("#dots-div").css("width", padded_width);
    $("#viz-dots-div").css("height", height);

    // ensure 0 padding.. ensure for removed footer
    $("#content").css("padding-bottom", 0);


    // set sizes
    context.width  = width;
    context.height = height;
    context.svg_width   = svg_width;
    context.svg_height  = svg_height;
}


///////////////////////////////////////////////////////////////////////////////
//////////////////// TOP FILTERS //////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

function filterChangeListener() {

    // filter options
    selected_a = document.getElementById('filter_a').value;
    selected_b = document.getElementById('filter_b').value;
    
    context.a_option = selected_a;
    context.b_option = selected_b;

    filtersUpdate(); // update upon context options
    updateSVGs();
}

function filterSwitchListener() {

    // filter options
    selected_a = document.getElementById('filter_a').value;
    selected_b = document.getElementById('filter_b').value;

    context.a_option = selected_b;
    context.b_option = selected_a;

    filtersUpdate(); // update upon context options
    updateSVGs();
}

///////////////////////////////////////////////////////////////////////////////
//////////////////// DATA FILTERS /////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

function filterShowListener() {
    // d3.select('#map-navbar').style("display", 'none');

    if (context.showingFilters) {
        d3.select('#filters-div').style("display", 'none');
    } else {
        d3.select('#filters-div').style("display", 'block');
    };
    context.showingFilters = !context.showingFilters;
    update_window();
}


///////////////////////////////////////////////////////////////////////////////
//////////////////// SIMULATION   /////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////


function simulation_ticked() {
    var alpha = this.alpha();
    if (alpha <= context.min_alpha) {
        this.stop();
        // console.log("Simulation " + this.label + " stopped due to small alpha");
        showLabels(this.label);
        return;
    }

    var selection = d3_nodes_a;
    var classes = a_classes;
    var field = "class_id";
    if (this.label == "b") {
        selection = d3_nodes_b;
        classes = b_classes;
        field = "related_class_id";
    }

    selection
        .attr("cx", function (d) {
            var center = classes[d[field]];
            d.x += (center.cx - d.x) * 0.09 * alpha;
            return d.x;
        })
        .attr("cy", function (d) {
            var center = classes[d[field]];
            d.y += (center.cy - d.y) * 0.09 * alpha;
            return d.y;
        });
}
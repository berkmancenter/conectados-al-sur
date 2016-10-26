///////////////////////////////////////////////////////////////////////////////
//////////////////// WINDOW      //////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

function update_window() {

    var max_small_width  = 640;  // px
    var max_medium_width = 1024; // px

    var totalWidth  = window.innerWidth;
    var totalHeight = window.innerHeight;
    
    // page:
    // top bar
    // top filters
    // svg a
    // svg b
    // info bar
    // filters (can be hidden)

    var height_topbar = document.getElementById("top-bar-div").clientHeight;
    var height_filter_header = 70 + 10 + 10 + 3; // (height + padding + margin)
    var height_infodiv = 110 + 5 + 5 + 1;        // (height + padding)

    // filter height depends upon screen width
    var height_filterdiv = 205 + 1;    // filter window is 205px height on large
    if (totalWidth < max_small_width) {
        height_filterdiv = 342 + 1;    // filter window is 342px height on small
    } else if (totalWidth < max_medium_width) {
        height_filterdiv = 262 + 1;    // filter window is 262px height on medium
    };

    var height_footer_full = height_infodiv;
    if (context.showingFilters) { height_footer_full += height_filterdiv; }

    
    // current size
    var viz_width  = context.svg_div.clientWidth;
    if (typeof a_classes !== 'undefined' && typeof b_classes !== 'undefined') {
        var svg_a_size = computeEfectiveSVGSize(a_classes.length);
        var svg_b_size = computeEfectiveSVGSize(b_classes.length);
        var svg_a_efective_height = svg_a_size.height*context.grid_a.rows + 2*context.svg_padding + 1;
        var svg_b_efective_height = svg_b_size.height*context.grid_b.rows + 2*context.svg_padding;


        var remaining_height = totalHeight 
            - height_topbar 
            - height_filter_header 
            - height_footer_full 
            - svg_a_efective_height
            - svg_b_efective_height;

        // expand svg_b if there is some remaining space
        if (remaining_height > 0) {
            svg_b_efective_height += remaining_height;
        }

        



        svg_a
            .attr("width" , viz_width)
            .attr("height", svg_a_efective_height);
        svg_b
            .attr("width" , viz_width)
            .attr("height", svg_b_efective_height);
    }

    // $("#dots-div").css("width", padded_width);
    // $("#viz-dots-div").css("height", height);

    // ensure 0 padding.. ensure for removed footer
    $("#content").css("padding-bottom", 0);
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
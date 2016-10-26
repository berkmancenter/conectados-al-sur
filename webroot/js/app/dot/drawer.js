///////////////////////////////////////////////////////////////////////////////
//////////////////// NODES   //////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

function computeClassFill(class_id) {
    class_id = Math.max(0, Math.min(class_id, context.node_styles.length - 1));
    return context.node_styles[class_id].fill;
}
function computeClassStroke(class_id) {
    class_id = Math.max(0, Math.min(class_id, context.node_styles.length - 1));
    return context.node_styles[class_id].stroke;
}
function computeClassStrokeWidth(class_id) {
    class_id = Math.max(0, Math.min(class_id, context.node_styles.length - 1));
    return context.node_styles[class_id].stroke_width;
}


function computeEfectiveSVGSize(n_classes) {
    var class_width  = context.min_class_width;
    var class_height = context.min_class_height;
    n_classes = Math.max(1, n_classes)
    return { 
        width: class_width*(1 + 1/n_classes),
        height: class_height*(1 + 1/n_classes),
    }
}

function computeClassCentroids(classes, current_grid) {

    var n_classes = classes.length;
    var max_width = context.svg_div.clientWidth;

    var svg = computeEfectiveSVGSize(classes.length);

    var cols = Math.max(Math.floor(max_width/svg.width),1);
    var rows = Math.ceil(n_classes/cols);

    var idx = 0;
    for (var i = 0; i < rows; i++) {
        var remaining_classes = n_classes - (i * cols);
        var this_row_cols = Math.min(cols, remaining_classes);
        for (var j = 0; j < this_row_cols; j++) {
            classes[idx].cx = Math.ceil((max_width / (this_row_cols + 1)) * (j + 1));
            classes[idx].cy = Math.ceil(context.svg_padding + (i + 0.5)*svg.height);
            idx++;
        }
    }

    current_grid.rows = rows;
    current_grid.cols = cols;

    return classes;
}





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




function updateNodes (svg, nodes) {
    
    var classes = a_classes;
    var field = "class_id";

    var d3_nodes = svg.selectAll(".node")
            .data(nodes);

    // update
    //

    // enter
    //

    // enter + update
    d3_nodes.enter().append("circle")
            .attr("class", "node")
            .attr("r", context.node_style_radius)
            .style("opacity", context.node_style_opacity)
            .attr("cx", function (d) {
                var center = classes[d[field]];
                return center.cx;
            })
            .attr("cy", function (d) {
                var center = classes[d[field]];
                return center.cy;
            })
        .merge(d3_nodes)
            // .transition()
            // .duration(500)
            .attr("fill", function (d) { return computeClassFill(d.class_id); })
            .attr("stroke", function (d) { return computeClassStroke(d.class_id); })
            .attr("stroke-width", function (d) { return computeClassStrokeWidth(d.class_id); });


    // exit
    d3_nodes.exit()
        // .transition()
        // .duration(1000)
        // .style("opacity", 0)  // this breaks!, requires a sleep
        .remove();

    d3_nodes = svg.selectAll(".node");
    return d3_nodes;
}

function removeLabels () {
    d3.selectAll(".class_label").remove();
}

function showLabels (simulation_label) {
    var selection = label_group_a;
    var classes = a_classes;
    var selection_nodes = d3_nodes_a;
    var field = "class_id";
    if (simulation_label == "b") {
        selection = label_group_b;
        classes = b_classes;
        selection_nodes = d3_nodes_b;
        field = "related_class_id";
    }

    classes.forEach(function (item, idx) {
        item.cx_min = 99999;
        item.cy_min = 99999;
        item.cx_max = -99999;
        item.cy_max = -99999;
    })

    // min max
    selection_nodes.each(function (d) {
        if (classes[d[field]].cx_min > d.x) {
            classes[d[field]].cx_min = d.x;
        }
        if (classes[d[field]].cx_max < d.x) {
            classes[d[field]].cx_max = d.x;
        }
        if (classes[d[field]].cy_min > d.y) {
            classes[d[field]].cy_min = d.y;
        }
        if (classes[d[field]].cy_max < d.y) {
            classes[d[field]].cy_max = d.y;
        }
    });
    

    var d3_labels = selection.selectAll(".class_label")        
        .data(classes);

    // update
    //

    // enter
    //
    d3_labels.enter().append("text")
        .attr("class", "class_label")
        .style("opacity", 0.7)
        .style("font-family", "Open Sans")
        .text(function (d) {
            var text = d.label;
            if (text.length > context.label_max_length) {
                text = text.substring(0,context.label_max_length - 3);
                text += "...";
            };
            return text;
        })
        .attr("dx", function (d) {
            // class width
            var class_width = d.cx_max - d.cx_min;

            var scale = 1;
            d.label_x = d.cx_min * scale + (class_width * scale - this.getBBox().width) / 2;
            return d.label_x * scale;
        })
        .attr("dy", function (d) {
            // class width
            var class_width = d.cx_max - d.cx_min;

            var scale = 1;
            d.label_y = d.cy_max * scale + context.label_separation;
            return d.label_y * scale;
        })
        // .on('mouseover', function (d) {
        //     d3.select(this).text(d.label);
        // })
        // .on('mouseout', function (d) {
        //     var text = d.label;
        //     if (text.length > 15) {
        //         text = text.substring(0,10);
        //         text += "...";
        //     };
        //     d3.select(this)
        //         .text(text);
        // })
        .on('click', function (d) {
            d3.select(this).text(d.label);
        });

    // Fade-in effect. (not working)
    // d3_labels.transition()
    //     .duration(500)
    //     .style("opacity", 0.7);

    // console.log("Showing labels for simulation: " + simulation_label);
}



///////////////////////////////////////////////////////////////////////////////
//////////////////// FILTERS //////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

function filtersUpdate () {
    filtersReset();
    $('#filter_a').val(context.a_option);
    $('#filter_b').val(context.b_option);
    $("#filter_a option[value='" + context.b_option + "']").remove();
    $("#filter_b option[value='" + context.a_option + "']").remove();
}

function filtersReset () {

    // remove all
    d3.selectAll(".header-filter-select option").remove();

    // init filters
    Object.keys(_filter_options).forEach(function (item, idx) {
        d3.select("#filter_a").append("option")
            .attr("value", item)
            .text(_filter_options[item]);

        d3.select("#filter_b").append("option")
            .attr("value", item)
            .text(_filter_options[item]);
    });
}
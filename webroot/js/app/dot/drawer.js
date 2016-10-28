function update_world(options) {

    updateSVGs();


    // update information
    d3.select("#info-nprojects").text(context.projects.length);

    // update view all button link
    filter_query = "projects?";
    if (options.hasOwnProperty('user_genre_id'))        { filter_query += "&g=" + options.user_genre_id;         }
    if (options.hasOwnProperty('organization_type_id')) { filter_query += "&o=" + options.organization_type_id   }
    if (options.hasOwnProperty('category_id'))          { filter_query += "&t=" + options.category_id            }
    if (options.hasOwnProperty('project_stage_id'))     { filter_query += "&s=" + options.project_stage_id       }
    if (options.hasOwnProperty('region_id'))            { filter_query += "&r=" + options.region_id              }
    if (options.hasOwnProperty('country_id'))           { filter_query += "&c=" + options.country_id             }
    var view_all_button = document.getElementById('dots_project_list_button');
    view_all_button.href =  filter_query;
    // console.log(view_all_button);


    context.filtering_options = options;
    // projects_info_display(active_country_id);
}

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


// function computeEfectiveSVGHeight(nodes_selector) {
//     // console.log(nodes_selector);
//     var cy_min =  99999;
//     var cy_max = -99999;

//     // min max
//     nodes_selector.each(function (d) {
//         if (cy_min > d.y) { cy_min = d.y; }
//         if (cy_max < d.y) { cy_max = d.y; }
//     });
//     var height = cy_max - cy_min + context.label_separation + 10;
//     // console.log(height);
//     // console.log(cy_max);
//     // console.log(cy_min);
//     // console.log('---');
//     return height;
// }

function computeSVGClassSize(n_classes) {
    var class_width  = context.min_class_width;
    var class_height = context.min_class_height;
    n_classes = Math.max(1, n_classes)
    return { 
        width: class_width*(1 + 2/n_classes),
        height: class_height*(1 + 5/n_classes),
    }
}

function computeClassCentroids(classes, current_grid) {

    var n_classes = classes.length;
    var max_width = context.svg_div.clientWidth;

    var svg = computeSVGClassSize(classes.length);

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
    
    context.selected_class = null;
    drawerDisableClass();

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
            .on('mouseover', function (d) { classOverListener(d) })
            .on('mouseout', function (d) { classOutListener(d) })
            .on('click', function (d) { classClickedListener(d) })
        .merge(d3_nodes)
            .attr("class", function (d) {
                return "node node-class-" + d.class_id;
            })
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
            d.label_x = d.cx_min + (class_width - this.getBBox().width) / 2;
            return d.label_x;
        })
        .attr("dy", function (d) {
            d.label_y = d.cy_max  + context.label_separation;
            return d.label_y;
        });
        // .on('mouseover', function (d) { classOverListener(d) })
        // .on('mouseout', function (d) { classOutListener(d) })
        // .on('click', function (d) { classClickedListener(d) });

    // Fade-in effect. (not working)
    // d3_labels.transition()
    //     .duration(500)
    //     .style("opacity", 0.7);

    // console.log("Showing labels for simulation: " + simulation_label);
}



///////////////////////////////////////////////////////////////////////////////
// TOP FILTERS
///////////////////////////////////////////////////////////////////////////////

function topSelectorsUpdate () {
    topSelectorsReset();
    $('#filter_a').val(context.a_option);
    $('#filter_b').val(context.b_option);
    $("#filter_a option[value='" + context.b_option + "']").remove();
    $("#filter_b option[value='" + context.a_option + "']").remove();
}

function topSelectorsReset () {

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


///////////////////////////////////////////////////////////////////////////////
// INFO BAR
///////////////////////////////////////////////////////////////////////////////

function infobar_clear() {
    d3.select("#info-ul").selectAll("*").remove();

    infobar_set_class_label(null);
}

function infobar_set_class_label(class_label) {

    var label  = d3.select("#info-title");

    var a_label = _filter_options[context.a_option];
    var b_label = _filter_options[context.b_option];

    if (class_label != null) {
        label.text(a_label + ": " +  class_label);
    } else {
        label.text(a_label + " vs. " + b_label);
    }
}

function infobar_set_class_info(class_id) {

    infobar_clear();
    infobar_set_class_label(a_classes[class_id].label);

    // real class id:
    var real_class_id = context.aMapInv[class_id];

    var infolist = d3.select("#info-ul");
    var nProjects = a_classes[class_id].count;
    var percent = 0;
    if (context.projects.length > 0) {
        percent = Math.round(100*nProjects/context.projects.length);
    }

    if (_useSpanish()) {
        infolist.append("li").text("Proyectos: " + nProjects + " - " +  percent + "%");
    } else {
        infolist.append("li").text("Projects: " + nProjects + " - " +  percent + "%");
    }

    var filter_query = "projects?";
    if (context.filtering_options.hasOwnProperty('country_id'))           { filter_query += "&c=" + context.filtering_options.country_id;            }
    if (context.filtering_options.hasOwnProperty('user_genre_id'))        { filter_query += "&g=" + context.filtering_options.user_genre_id;         }
    if (context.filtering_options.hasOwnProperty('organization_type_id')) { filter_query += "&o=" + context.filtering_options.organization_type_id   }
    if (context.filtering_options.hasOwnProperty('category_id'))          { filter_query += "&t=" + context.filtering_options.category_id            }
    if (context.filtering_options.hasOwnProperty('project_stage_id'))     { filter_query += "&s=" + context.filtering_options.project_stage_id       }
    if (context.filtering_options.hasOwnProperty('region_id'))            { filter_query += "&r=" + context.filtering_options.region_id              }
    // console.log(filter_query);

    var class_query = "&" + context.a_option + "=";
    if (filter_query.indexOf(class_query) < 0) {
        filter_query += class_query + "" + real_class_id;
    }
    // console.log(filter_query);

    if (_useSpanish()) {
        infolist.append("li").append("a")
            .text("Ver más ...")
            .attr("href", filter_query)
            .attr("target", "_blank");
    } else {
        infolist.append("li").append("a")
            .text("Complete info ...")
            .attr("href", filter_query)
            .attr("target", "_blank");
    }
}


function drawerEnableClass(class_id) {
    
    infobar_set_class_info(class_id);

    nodes_group_a.selectAll(".node-class-" + class_id)
        .attr("class", function (d) {
            return "node node-class-" + d.class_id + " node-selected";
        })
        .attr("r", context.node_style_radius * 1.5);
    nodes_group_b.selectAll(".node-class-" + class_id)
        .attr("class", function (d) {
            return "node node-class-" + d.class_id + " node-selected";
        })
        .attr("r", context.node_style_radius * 1.5);

}

function drawerDisableClass() {
    infobar_clear();

    nodes_group_a.selectAll(".node-selected")
        .attr("class", function (d) {
            return "node node-class-" + d.class_id;
        })
        .attr("r", context.node_style_radius);
        
    nodes_group_b.selectAll(".node-selected")
        .attr("class", function (d) {
            return "node node-class-" + d.class_id;
        })
        .attr("r", context.node_style_radius);
}


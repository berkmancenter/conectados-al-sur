///////////////////////////////////////////////////////////////////////////////
//////////////////// DRAWER  HELPERS //////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////
// COUNTRY HELPERS

// highlights the country
function drawer_country_active(codN3) {
    if (codN3 == null) { return; };
    d3.select("#country-" + codN3).classed("country_active", true);
    d3.select("#country-" + codN3).classed("country_hover", false);
}

// highlights the country if not active
function drawer_country_hover(codN3) {
    if (codN3 == null) { return; };
    d3.select("#country-" + codN3).classed("country_active", false);
    d3.select("#country-" + codN3).classed("country_hover", true);
}

// resets the country colour
function drawer_country_normal(codN3) {
    if (codN3 == null) { return; };
    d3.select("#country-" + codN3).classed("country_active", false);
    d3.select("#country-" + codN3).classed("country_hover", false);
}

//////////////////////////////////////////////////////
// PIN HELPERS

function drawer_pin_active(codN3) {
    if (codN3 == null) { return; };
 
    d3.select("#country_pin-" + codN3)
        .moveToFront()
        .style("stroke", country_pin.active.stroke)
        .style("stroke-width", function(d,i) {
                return country_pin.active.stroke_width/current_transform.k;
        });
}

function drawer_pin_hover(codN3) {
    if (codN3 == null) { return; };

    d3.select("#country_pin-" + codN3)
        .style("stroke", country_pin.hover.stroke)
        .style("stroke-width", function(d,i) {
                return country_pin.hover.stroke_width/current_transform.k;
        });
}

function drawer_pin_normal(codN3) {
    if (codN3 == null) { return; };

    d3.select("#country_pin-" + codN3)
        .style("stroke", country_pin.normal.stroke)
        .style("stroke-width", function(d,i) {
                return country_pin.normal.stroke_width/current_transform.k;
        });

}

function drawer_pin_zoom_update(transform) {

    g.selectAll(".country_pin")
        .attr("r" , function(d,i) {
            var scale = Math.max(Math.min(d.projects.length, 10)*0.15,1.0);
            return 9*scale/transform.k;
        })
        .style("stroke-width", function(d,i) {
            return country_pin.normal.stroke_width/transform.k;
        });

    // hovered pin
    d3.select("#country_pin-" + hovered_country_id)
        .style("stroke-width", function(d,i) {
            return country_pin.hover.stroke_width/transform.k;
        });

    // active pin
    d3.select("#country_pin-" + active_country_id)
        .style("stroke-width", function(d,i) {
            return country_pin.active.stroke_width/transform.k;
        });
}


//////////////////////////////////////////////////////
// TOOLTIP HELPERS

function drawer_tooltip(codN3) {

    // retrieve country
    var country = getCountryById(codN3);
    if (country == null) { return; };

    var coords  = projection([country.longitude, country.latitude]);

    // draw tooltip
    var k = current_transform.k;
    var dx = 20/k;
    var dy = 20/k;
    var tw = 120/k;
    var th = 30/k;
    var mleft = 15/k;
    var mbottom = 10/k;
    var nodeFontSize = 12/k;

    d3.select("#country_tooltip_rect")
        .style("stroke-width", 5.0/k)
        .attr("rx", 10.0/k)
        .attr("ry", 10.0/k)
        .attr("x", coords[0]+dx)
        .attr("y", coords[1]-(th+dy))
        .attr("width", tw)
        .attr("height", th);

    // n asociated projects
    _projects = getCountryProjectIds(codN3);
    nProjects = 0
    if ( _projects != null) {
        nProjects = _projects.length;
    }
    projects_word = nProjects == 1 ? "project" : "projects" ;

    // console.log(country);
    // console.log(nProjects);
    // console.log(_projects);
    // console.log(projects_word);

    d3.select("#country_tooltip_text")
        .text(country.cod_a3 + " (" + nProjects + " " + projects_word + ")")
        .style("cursor", "default")
        .attr("x", coords[0]+(dx+mleft))
        .attr("y", coords[1]-(dy+mbottom))
        .attr("font-size", nodeFontSize + "px");

    d3.select(".country_tooltip")
        .datum(codN3)
        .style("opacity", 1)
        .attr("transform", d3.zoomIdentity) // reapear!
        .moveToFront();
}

function drawer_tooltip_remove() {
    d3.select(".country_tooltip")
        .style("opacity", 1e-6)
        // trick to desapear from svg!
        .attr("transform", d3.zoomIdentity.translate(10*context.width,10*context.height));
}

function drawer_tooltip_zoom_update(transform) {
    if (hovered_country_id != null) {
        drawer_tooltip(hovered_country_id);
    } else {
        drawer_tooltip_remove();
    }
}


///////////////////////////////////////////////////////////////////////////////
//////////////////// INFORMATION  HELPERS//////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

function projects_info_set_country_label(codN3) {

    var label  = d3.select("#info-country-label");
    var select = d3.select("#info-country-select");

    if (codN3 != null) {
        var country = getCountryById(codN3);
        if (country == null) { return; };
        if (_useSpanish()) {
            label.text(country.name_es);
        } else {
            label.text(country.name);
        }
        select.style("display", 'none');
    } else {
        select.style("display", 'block');
        label.text("");
    }
}


function projects_info_clear() {
    d3.select("#info-country-ul").selectAll("*").remove();

    projects_info_set_country_label(null);
}

function projects_info_display(codN3) {

    projects_info_clear();
    projects_info_set_country_label(codN3);
    
    var project_idxs = getCountryProjectIds(codN3);
    
    var curr_projects = [];
    // console.log("n3: " + codN3);
    // console.log(project_idxs);

    // console.log(project_idxs);
    if (project_idxs != null) {
        project_idxs.forEach(function (item, index) {
            curr_projects.push(getProjectById(item));
        });
    }
    var nProjects = curr_projects.length;

    //console.log(curr_projects);

    var infolist = d3.select("#info-country-ul");

    if (nProjects > 1) {

        // categories = {};
        // last_update = new Date(0);

        // curr_projects.forEach(function (item, index) {
            
            // console.log(item);
            // console.log(item);

            // fill categories
            // Object.keys(item.categories).forEach(function (cat_item_id, cat_index) {
            //     cat_id = item.categories[cat_item_id].id;
            //     cat_name = item.categories[cat_item_id].name;
            //     categories[cat_id] = cat_name;
            // });

            // modified = new Date(item.modified);
            // last_update = last_update > modified ? last_update : modified;
        // });
        // console.log(categories);

        if (_useSpanish()) {
            infolist.append("li").text("Projectos: " + nProjects);
        } else {
            infolist.append("li").text("Projects: " + nProjects);
        }
        
        // infolist.append("li").text("Categories: " + Object.keys(categories).length);
        // infolist.append("li").text("Last Update: " + last_update.toDateString());
        

        // console.log(filtering_options);
        filter_query = "projects?c=" + codN3;
        if (filtering_options.hasOwnProperty('user_genre_id'))        { filter_query += "&g=" + filtering_options.user_genre_id;         }
        if (filtering_options.hasOwnProperty('organization_type_id')) { filter_query += "&o=" + filtering_options.organization_type_id   }
        if (filtering_options.hasOwnProperty('category_id'))          { filter_query += "&t=" + filtering_options.category_id            }
        if (filtering_options.hasOwnProperty('project_stage_id'))     { filter_query += "&s=" + filtering_options.project_stage_id       }
        // if (filtering_options.hasOwnProperty('region_id'))            { filter_query += "&r=" + filtering_options.region_id              }

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

    } else if (nProjects == 1) {

        var project = curr_projects[0];
        // console.log(project);
        // console.log(curr_projects);

        infolist.append("li").text(project.name);
        infolist.append("li").text(project.organization);

        if (_useSpanish()) {
            infolist.append("li").append("a")
                .text("Ver más ...")
                .attr("href", "projects/" + project.id)
                .attr("target", "_blank");
        } else {
            infolist.append("li").append("a")
                .text("Complete info ...")
                .attr("href", "projects/" + project.id)
                .attr("target", "_blank");
        }

    } else {
        if (_useSpanish()) {
            infolist.append("li").text("No hay proyectos");
        } else {
            infolist.append("li").text("No projects");
        }
    }
}


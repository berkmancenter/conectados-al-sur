///////////////////////////////////////////////////////////////////////////////
//////////////////// LISTENERS  ///////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

// zoom
var current_transform = d3.zoomIdentity;

// countries
var active_country_id  = null;
var hovered_country_id = null;

////////// ZOOM LISTENERS //////////////////////////////////////////////////

function zoomed() {
    
    current_transform = d3.event.transform;
    g.attr("transform", d3.event.transform);

    // update other elements on a special way
    drawer_pin_zoom_update(d3.event.transform);
    drawer_tooltip_zoom_update(d3.event.transform);
}

function zoomButtonListener() {
    var zoom_scale = 1.5;
    if (this.getAttribute("data-zoom") < 0) {
        zoom_scale = 1.0/zoom_scale;
    }
    zoom.scaleBy(outer_g, zoom_scale);
}

////////// COUNTRY LISTENERS //////////////////////////////////////////////////

function countryClickListener(d) {

    var clicked_id = d.id;
    if (clicked_id == active_country_id) {
        // deactivate the current one        
        active_country_id = null;
        drawer_country_hover(clicked_id);
        drawer_pin_normal(clicked_id);

        // crear country info
        projects_info_clear();

    } else {
        // deactivate previous one
        drawer_country_normal(active_country_id);
        drawer_pin_normal(active_country_id);

        // activate the current
        active_country_id = clicked_id;
        if (hovered_country_id == active_country_id) { hovered_country_id = null; }
        drawer_country_active(active_country_id);
        drawer_pin_active(active_country_id);

        // show projects info
        projects_info_display(active_country_id);
    }
}

function countryMouseOverListener(d) {
    var hover_id = d.id;
    if (hover_id != active_country_id) {
        hovered_country_id = hover_id;
        drawer_country_hover(hover_id);
        drawer_pin_hover(hover_id);
    }
    drawer_tooltip(hover_id);    
}

function countryMouseOutListener(d) {
    var hover_id = d.id;
    if (hover_id != active_country_id) {
        hovered_country_id = null;
        drawer_country_normal(hover_id);
        drawer_pin_normal(hover_id);
    }
    drawer_tooltip_remove();
}

////////// PIN LISTENERS //////////////////////////////////////////////////////
function pinClickListener(d)     { countryClickListener(d);     }
function pinMouseOverListener(d) { countryMouseOverListener(d); }
function pinMouseOutListener(d)  { countryMouseOutListener(d); }


////////// TOOLTIP LISTENERS //////////////////////////////////////////////////
function tooltipMouseOverListener(d) {
    var country_id = d;
    drawer_tooltip(country_id);
    if (country_id != active_country_id) {
        drawer_country_hover(country_id);
    } else {
        drawer_country_active(country_id);
    }
}

function tooltipMouseOutListener(d) {
    var country_id = d;
    drawer_tooltip_remove();
    if (country_id != active_country_id) {
        drawer_country_normal(country_id);    
    }
}


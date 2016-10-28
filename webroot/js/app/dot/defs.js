
// global
var context = {}

// defaults
context.a_option = "t"; // categories
context.b_option = "g"; // genres


///////////////////////////////////////////////////////////////////////////////
// DRAWING
///////////////////////////////////////////////////////////////////////////////

context.svg_padding = 20; // top, bottom padding [px]
context.min_class_width  = 140; // minimum class width  [px]
context.min_class_height = 100; // minimum class height [px] (account some space for the label!)

context.label_separation = 25; // vertical separation from label to the lowest related node
context.label_max_length = 13; // max characters to be displayed for each label

// default class grids for each SVG
context.grid_a = {};
context.grid_b = {};
context.grid_a.cols = 1;
context.grid_a.rows = 1;
context.grid_b.cols = 1;
context.grid_b.rows = 1;


///////////////////////////////////////////////////////////////////////////////
// COLORING
///////////////////////////////////////////////////////////////////////////////


context.node_styles = [
    { fill: "#1f78b4", stroke: "#000", stroke_width: 1 },
    { fill: "#33a02c", stroke: "#000", stroke_width: 1 },
    { fill: "#e31a1c", stroke: "#000", stroke_width: 1 },
    { fill: "#ff7f00", stroke: "#000", stroke_width: 1 },
    { fill: "#6a3d9a", stroke: "#000", stroke_width: 1 },
    { fill: "#a6cee3", stroke: "#000", stroke_width: 1 },
    { fill: "#b2df8a", stroke: "#000", stroke_width: 1 },
    { fill: "#fb9a99", stroke: "#000", stroke_width: 1 },
    { fill: "#fdbf6f", stroke: "#000", stroke_width: 1 },
    { fill: "#cab2d6", stroke: "#000", stroke_width: 1 },
    { fill: "#1f78b4", stroke: "#000", stroke_width: 4 },
    { fill: "#33a02c", stroke: "#000", stroke_width: 4 },
    { fill: "#e31a1c", stroke: "#000", stroke_width: 4 },
    { fill: "#ff7f00", stroke: "#000", stroke_width: 4 },
    { fill: "#6a3d9a", stroke: "#000", stroke_width: 4 },
    { fill: "#a6cee3", stroke: "#000", stroke_width: 4 },
    { fill: "#b2df8a", stroke: "#000", stroke_width: 4 },
    { fill: "#fb9a99", stroke: "#000", stroke_width: 4 },
    { fill: "#fdbf6f", stroke: "#000", stroke_width: 4 },
    { fill: "#cab2d6", stroke: "#000", stroke_width: 4 },
];


context.node_style_opacity = 1.0;
context.node_style_radius = 7;

///////////////////////////////////////////////////////////////////////////////
// SIMULATION
///////////////////////////////////////////////////////////////////////////////

context.min_alpha = 0.2;
context.alpha_init = 2.0;

context.max_nodes = 50;

context.forces = {
    charge  : { 
        enabled: true,
        strength: -15,
        distance_min: 0,
        distance_max: 200
    },
    collide : {
        enabled: true,
        strength:  1,
        iterations: 1,
        radius: 10
    },
}



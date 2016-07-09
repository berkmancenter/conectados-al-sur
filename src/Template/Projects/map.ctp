<style>

/* = = = = = = = = = = = =  map = = = = = = = = = = = = */

.background {
  fill: #333;
  pointer-events: all;
}

/* ??? */
.mesh {
  fill: none;
  stroke: #fff;
  stroke-linecap: round;
  stroke-linejoin: round;
}

/* --- country, name and borders --- */
.country {
  fill: #ccc;
  cursor: pointer;
}

.country.active {
  fill: orange;
}

.country-label {
  fill: #000;
  fill-opacity: 0.8;
  font-size: 20px;
  font-weight: 300;
  text-anchor: middle;
}

.country-boundary {
  fill: none;
  stroke: #000;
  stroke-dasharray: 3,4;
  stroke-linejoin: round;
  stroke-width: 1.5px;
}

.country-coastline {
  fill: none;
  stroke: #aaa;
  stroke-linejoin: round;
  stroke-width: 1.5px;
}


/* --- map pins --- */
.pin {
  fill: blue;
  stroke: white;
  stroke-width: 1.5px;
  cursor: pointer;
}
.pin-hover {
  fill: red;
  stroke: white;
  stroke-width: 1.5px;
  cursor: pointer;
}

/* --- map tooltip --- */
body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  width: 960px;
  height: 500px;
  position: relative;
}
#tooltip-container {
  position: absolute;
  background-color: #fff;
  color: #000;
  padding: 10px;
  border: 1px solid;
  display: none;
}
.tooltip_key {
  font-weight: bold;
}
.tooltip_value {
  margin-left: 20px;
  float: right;
}


/* - - - - - - side-bar - - - - - - */
.side-nav li
{
    background-color: #ccc;
}

.side-nav li a:not(.button)
{
    color: #000;
}
.side-nav li a:hover:not(.button)
{
    color: red;
}
</style>


<?= $this->Html->script('d3/d3.min.js') ?>
<?= $this->Html->script('topojson/topojson.min.js') ?>
<?= $this->Html->script('jquery-3.0.0.min') ?>

<!-- The view title -->
<?= $this->assign('title', 'Projects Map') ?>

<div class="projects index large-9 medium-8 columns content">
    <div id="tooltip-container"></div>
    <div id="svg-map"></div>
</div>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <!-- <li class="heading"><?= __('Toolbar') ?></li> -->
        <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Graph Visualization'), ['action' => 'graph']) ?></li>
    </ul>
    <ul class="side-nav-info">
        <li id="info-nprojects"></li>
    </ul>
</nav>




<script>

var projects = <?php echo json_encode($projects); ?>;
var cities = <?php echo json_encode($cities); ?>;
console.log(projects[0]);
console.log(cities[0]);

d3.select("#info-nprojects")
    .datum(projects.length)
    .append("p")
    .text(function (d) {
        if (d > 1) {
            info  = "Found ";
            info += d;
            info += " projects";
            return info;
        }
        if (d == 1) {
            return "Found 1 project.";
        }
        return "No projects were found.";
    });

// ============================================================================
// Variables

var active = d3.select(null);

// map size
var width = 1300;
var height = 500;

// ------------------------------------------------------------------
// geography rendering requires:
// - SVG or Canvas : where to draw: (vector based  vs. pixel based)
// - projection    : projects from spherical to cartesian 2D screen
// - path generator: draws the projected geometry on the SVG or Canvas
// - zoom behabior : manages zooming

// zooming behavior
var zoom = d3.zoom()
    .scaleExtent([0.5, 5])
    .translateExtent([[-700, -800], [width + 1200, height + 200]])
    .on("zoom", zoomed);

// map projection to 2D
var projection = d3.geoMercator()
    .scale(400)
    .translate([width/2, height/2]);

// map drawer
var path = d3.geoPath()
    .projection(projection);

// where to draw
var svg = d3.select("#svg-map").append("svg")
    .attr("width", width)
    .attr("height", height)
    .on("click", stopped, true); // TODO: VER QUE HACE ESTO EXACTAMENTE

// svg background
svg.append("rect")
    .attr("class", "background")
    .attr("width", width)
    .attr("height", height)
    .on("click", reset);

// svg group
var g = svg.append("g");


// // ------------------------------------------------------------------


// // ============================================================================

// enable zooming
svg.call(zoom);

// queue file loading and set a callback
d3.queue()
    .defer(d3.json, "files/world-110m.json")
    .defer(d3.tsv , "files/world-country-names.tsv")
    .await(ready);

// // ============================================================================

function ready(error, world, names) {
    if (error) return console.error(error);

    // geojson to topojson
    var land      = topojson.feature(world, world.objects.land);
    var countries = topojson.feature(world, world.objects.countries);

    // country boundaries
    // filter to reduce the number of boundaries
    // a,b: features on either side of a boundary
    // a === b : exterior boundaries
    // a !== b : interior boundaries
    var borders = topojson.mesh(world, world.objects.countries,
        function(a, b) { return a !== b; }
    )
    var borders_coast = topojson.mesh(world, world.objects.countries,
        function(a, b) { return a === b; }
    )

    // add feature property 'name' to each corresponding country
    // then sort them by name
    countries = countries.features.filter(function(d) {
        return names.some(function(n) {
            if (d.id == n.id) return d.properties.name = n.name;
        });
    })

    // select countries and:
    // - set class to: .country
    // - set the drawer "d" to: path 
    g.selectAll(".country")
            .data(countries)
        .enter().append("path")
            .attr("class", "country")
            .attr("d", path)
            .attr("title", function(d) { return d.properties.name; })
            .on("click", clicked)
            .on("mousemove", function(d) {
                var html = "";
                html += "<div class=\"tooltip_kv\">";
                html += "<span class=\"tooltip_key\">";
                html += d.properties.name;
                html += "</span>";
                html += "<span class=\"tooltip_value\">";
                html += "0";
                html += "";
                html += "</span>";
                html += "</div>";
                
                $("#tooltip-container").html(html);
                $(this).attr("fill-opacity", "0.8");
                $("#tooltip-container").show();

                var coordinates = d3.mouse(this);
                
                if (d3.event.pageX < width / 2) {
                  d3.select("#tooltip-container")
                    .style("top", (d3.event.layerY + 15) + "px")
                    .style("left", (d3.event.layerX + 15) + "px");
                } else {
                  var tooltip_width = $("#tooltip-container").width();
                  d3.select("#tooltip-container")
                    .style("top", (d3.event.layerY + 15) + "px")
                    .style("left", (d3.event.layerX - tooltip_width - 30) + "px");
                }

            })
            .on("mouseout", function() {
                    $(this).attr("fill-opacity", "1.0");
                    $("#tooltip-container").hide();
            });


    // set .country-boundary and .country-coastline class to borders
    g.append("path")
        .datum(borders)
        .attr("d", path)
        .attr("class", "country-boundary");
    g.append("path")
        .datum(borders_coast)
        .attr("d", path)
        .attr("class", "country-coastline");


    // --------------------------
    // PINES
    var pin = d3.symbol()
        .type(d3.symbolCircle)
        .size(100);
    var pin_red = d3.symbol()
        .type(d3.symbolCircle)
        .size(150);

    var marks = [{x: -50, y: -20},{x: -78, y: 41},{x: -70, y: 53}];

    g.selectAll(".pin")
            .data(marks)
        .enter()
            .append("path")
            .attr('class','pin')
            .attr("d", pin)
            .attr("transform", function(d) { 
                return "translate(" + projection([d.x,d.y]) + ")";
            })
            .on("mouseover", function(d) {
                d3.select(this)
                    .attr('class','pin-hover')
                    .attr("d", pin_red);
            })
            .on("mouseout", function(d) {
                d3.select(this)
                    .attr('class','pin')
                    .attr("d", pin);
            })
            .on("click", function() {
                d3.select(this).style("fill", "#eee");
            });
                        
            
    // ------------------------



    // // display all country names on the centroid
    // g.selectAll(".country-label")
    //         .data(countries)
    //     .enter().append("text")
    //         .attr("class", "country-label")
    //         .attr("transform", function(d) { return "translate(" + path.centroid(d) + ")"; })            
    //         .attr("dy", ".35em")
    //         .on("mouseout",  function() {
    //             d3.select(this).text("");
    //         })
    //         .on("mouseover", function() {
    //             d3.select(this).text(
    //                 function(d) { return d.properties.name; }
    //             );
    //         });

    // d3.selectAll(".country-label")
    //     .on("click", function() {
    //         d3.select(this).style("fill", "#eee");
    //     });

    //console.log(countries[0].geometry.coordinates);
    // console.log(world);
    // console.log(named);
}



function clicked(d) {
    if (active.node() === this) return reset();
    active.classed("active", false);
    active = d3.select(this).classed("active", true);

    // TODO: preferir centroide
    var bounds = path.bounds(d),
        dx = bounds[1][0] - bounds[0][0],
        dy = bounds[1][1] - bounds[0][1],
        x = (bounds[0][0] + bounds[1][0]) / 2,
        y = (bounds[0][1] + bounds[1][1]) / 2,
        scale = Math.max(1, Math.min(8, 0.9 / Math.max(dx / width, dy / height))),
        translate = [width / 2 - scale * x, height / 2 - scale * y];

    // console.log(scale);
    // console.log(translate);
    var t = d3.zoomIdentity.translate(translate[0],translate[1]).scale(scale);
    // console.log(t);
    svg.transition()
        .duration(750)
        .call(zoom.transform, t);
}

function reset() {
    active.classed("active", false);
    active = d3.select(null);

    // TODO: hay un error.. ver consola
    svg.transition()
        .duration(750)
        .call(zoom.transform, d3.zoomIdentity);
}

// TODO: cuando el zoom llega al max, no desplazar ventana!
function zoomed() {
    g.style("stroke-width", 1.5 / d3.event.scale + "px");
    g.attr("transform", d3.event.transform);
}

// If the drag behavior prevents the default click,
// also stop propagation so we don’t click-to-zoom.
function stopped() {
    if (d3.event.defaultPrevented) d3.event.stopPropagation();
}

</script>


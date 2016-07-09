<?= $this->Html->script('d3/d3.min.js') ?>
<?= $this->Html->script('topojson/topojson.min.js') ?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Organization Types'), ['controller' => 'OrganizationTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Organization Type'), ['controller' => 'OrganizationTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Stages'), ['controller' => 'ProjectStages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Stage'), ['controller' => 'ProjectStages', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projects index large-9 medium-8 columns content">
    <div id="svg-map"></div>
</div>



<style>
body {font-size:11px;}
path {
  stroke: black;
  stroke-width: 0.25px;
}

</style>

<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://d3js.org/topojson.v0.min.js"></script>
<script>
var width = 960,
    velocity = .005,  
    then = Date.now() 
    height = 475;

var projection = d3.geo.mercator()
    .center([0, 0 ])
    .scale(1000);

var svg = d3.select("svg-map").append("svg")
    .attr("width", width)
    .attr("height", height);

var path = d3.geo.path()
    .projection(projection);

var g = svg.append("g");
d3.json("files/world-110m.json", function(error, topology) {
  g.selectAll("path")
    .data(topojson.object(topology, topology.objects.countries).geometries)
  .enter()
    .append("path")
    .attr("d", path)
    .style("fill","black")
    
  d3.timer(function() {  
    var angle = velocity * (Date.now() - then);  
    projection.rotate([angle,0,0]);  
    svg.selectAll("path")  
      .attr("d", path.projection(projection));  
  }); 
  
  var zoom = d3.behavior.zoom()
  .on("zoom",function() {
    g.attr("transform","translate("+d3.event.translate.join(",")+")scale("+d3.event.scale+")")
  });
    
  svg.call(zoom)
});
</script>

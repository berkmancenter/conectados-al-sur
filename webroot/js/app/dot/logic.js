///////////////////////////////////////////////////////////////////////////////
//////////////////// NODES   //////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

function computeClasses (option) {
    var set = getDataset(option);

    field = "name";
    if (_useSpanish()) {
        field = "name_es";
    }

    classes = [];    
    set.forEach(function (item, idx) {

        classes[idx] = {
            id: item.id,
            label: item[field],
            trimmed_label: item[field].toLowerCase().replace(/[^abcdefghijklmnopqrstuvwxyz]/g, '')
        }
    });

    return classes;
}

function computeMapping(a_option, b_option) {

    // A := Project Stages
    // B := Genres
    var P = context.projects;
    var A = getDataset(a_option);
    var B = getDataset(b_option);
    var nA = A.length;
    var nB = B.length;


    // maps A ids to 0...(nA-1)
    var aMap = {};
    var aMapInv = new Array(nA);
    A.forEach(function (item, idx) {
        aMapInv[idx] = item.id;
        aMap[item.id] = idx;
    });
    context.aMapInv = aMapInv;
    // console.log(bMap);
    // console.log(bMapInv);

    // maps B ids to 0...(nB-1)
    var bMap = {};
    var bMapInv = new Array(nB);
    B.forEach(function (item, idx) {
        bMapInv[idx] = item.id;
        bMap[item.id] = idx;
    });
    // console.log(bMap);
    // console.log(bMapInv);


    // each element represents a row for Ai
    var mapping = createMatrixZeros(nA, nB);

    // create mapping
    a_classes.forEach(function (item, idx) {
        item.count = 0;
    })
    b_classes.forEach(function (item, idx) {
        item.count = 0;
    })
    P.forEach(function (item, idx) {
        var a_ids = getProjectPropertyIds(item, a_option);
        var b_ids = getProjectPropertyIds(item, b_option);

        a_ids.forEach(function (item, idx) {
        	var row = aMap[item];
        	b_ids.forEach(function (item, idx) {
        		var col = bMap[item];
		        mapping[row][col] += 1;
        	});
            a_classes[row].count += 1;
        });

        b_ids.forEach(function (item, idx) {
            var index = bMap[item];
            b_classes[index].count += 1;
        });
    });
    // console.log(mapping);
    return mapping;
}

function mapToPercent(map) {

	var Ns = map.map(function (item, idx) {
        return arraySum(item);
    });
    N = arraySum(Ns)

    var rows = map.length;
    var cols = map[0].length;
    var percents = createMatrixZeros(rows, cols);

    for (var i = rows-1; i >= 0; i--) {
        for (var j = cols-1; j >= 0; j--) {
            percents[i][j] = map[i][j]/(N + 0.0);
        };
    };
    return percents;
}

function percentToNodes(percent, nNodes) {

    var rows = percent.length;
    var cols = percent[0].length;
    var nodes = createMatrixZeros(rows, cols);

    for (var i = rows-1; i >= 0; i--) {
        for (var j = cols-1; j >= 0; j--) {

            var pieces = percent[i][j]*nNodes;
            if (0 < pieces  && pieces < 1) {
                pieces = 1;
            }
            nodes[i][j] = Math.round(pieces);
        };
    };
    return nodes;
}

function arraySum(array) {
    return array.reduce(function (a, b) {
        return a+b;
    }, 0);
}

function nodesToD3(nodes_map) {

    var rows = nodes_map.length;
    var cols = nodes_map[0].length;

    // var N = arraySum(rows)
    // console.log(nodes_map);
    // console.log(rows);
    // console.log(cols);

    var nodes = [];
    // var acc = 0;
    for (var i = 0; i < rows; i++) {

        row = nodes_map[i];
        // console.log(i);
        // console.log(row);
        for (var j = 0; j < cols; j++) {

            n = row[j];
            // console.log(n);
            for (var k = 0; k < n; k++) {

                nodes.push({
                    // id: acc + k,
                    class_id: i,        // 0 to nA-1: original class ids
                    related_class_id: j // 0 to nB-1: related  class ids
                });
            };
        };
        // acc += n;
    };

    // var rows = percent.length;
    // var cols = percent[0].length;
    // console.log(nodes);
    return nodes;
}

function computeNodes(a_option, b_option) {
    var mapping  = computeMapping(a_option, b_option);
    var percents_map = mapToPercent(mapping);
    var nodes_map    = percentToNodes(percents_map, context.current_max_nodes);
    a_nodes = nodesToD3(nodes_map); // we need a deep copy 
    b_nodes = nodesToD3(nodes_map); // we need a deep copy
    return [a_nodes, b_nodes];
}




///////////////////////////////////////////////////////////////////////////////
//////////////////// SIMULATION  //////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////


function createSimulation (nodes, label) {
    var simulation = d3.forceSimulation();
    simulation.label = label;

    simulationInitForces(simulation);
    simulationSetup(simulation);

    simulation.stop();

    simulation.on("tick", simulation_ticked);
    // simulation.on("end", simulation_ended);

    return simulation;
}
    
function simulationInitForces (simulation) {
    simulation
        .force("collide", d3.forceCollide())
        .force("charge", d3.forceManyBody());
}

function simulationSetup (simulation) {
    simulation.force("charge")
        .strength(context.forces.charge.strength * context.forces.charge.enabled)
        .distanceMin(context.forces.charge.distance_min)
        .distanceMax(context.forces.charge.distance_max);
    simulation.force("collide")
        .strength(context.forces.collide.strength * context.forces.collide.enabled)
        .radius(context.forces.collide.radius)
        .iterations(context.forces.collide.iterations);    
}

function restartSimulation(simulation) {
    // updates ignored until this is run
    // restarts the simulation (important if simulation has already slowed down)
    simulation.alpha(context.alpha_init).restart();
}

function updateSVGs() {
    
    // remove all labels
    removeLabels();

    // stop simulations
    simulation_a.stop();
    simulation_b.stop();

    // parse classes and generate nodes
    a_classes = computeClasses(context.a_option);
    b_classes = computeClasses(context.b_option);
    [nodes_a, nodes_b] = computeNodes(context.a_option, context.b_option);

    // compute centroids
    a_classes = computeClassCentroids(a_classes, context.grid_a);
    b_classes = computeClassCentroids(b_classes, context.grid_b);

    // draw nodes
    d3_nodes_a = updateNodes(nodes_group_a, nodes_a);
    d3_nodes_b = updateNodes(nodes_group_b, nodes_b);

    // simulations
    simulation_a.nodes(nodes_a);
    simulation_b.nodes(nodes_b);
    restartSimulation(simulation_a);
    restartSimulation(simulation_b);

    update_window();
}

///////////////////////////////////////////////////////////////////////////////
//////////////////// MATH    //////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////


function createMatrixZeros(nA, nB) {
    var matrix = new Array(nA);
    for (var i = matrix.length - 1; i >= 0; i--) {
        matrix[i] = new Array(nB);
    };
    for (var i = nA-1; i >= 0; i--) {
        for (var j = nB-1; j >= 0; j--) {
            matrix[i][j] = 0;
        };
    };
    return matrix;
}



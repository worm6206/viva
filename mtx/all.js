	var allText;
	var i = 0;
	var arrayofStrings;
	var count = 0;
	var k;

//************************* Read File *************************

	function readTextFile(file) {
	    var rawFile = new XMLHttpRequest();
	    rawFile.open("GET", file, false);
	    rawFile.onreadystatechange = function() {
	        if (rawFile.readyState === 4) {
	            if (rawFile.status === 200 || rawFile.status === 0) {
	                allText = rawFile.responseText;
	                // alert(allText);
	            }
	        }
	    }
	    rawFile.send(null);
	}

	function removeComment(string) {
	    if (string[i] == '%') {
	        while (string[++i] != '\n');
	        i++;
	        removeComment(string);
	    }

	}

	function splitString(string, sep) {
	    arrayofStrings = string.split(sep);

	}

	var path = window.location.href;
	var num = path.indexOf("?");
	num++;
	var path2 = [];
	for (var j = 0; j < path.length - num; j++) {
	    path2[j] = path[j + num];
	}
	path = null;
	path = path2.join("");

	//store text file into allText
	readTextFile(path);

	//remove lines start with '%'
	removeComment(allText);
	allText = allText.substring(i, allText.length);

	//replace \n with space, then use space to split string into array.
	allText = allText.replace(/\n/g, " ");
	splitString(allText, ' ');

	//till this point the coordinate data is stored inside array "arrayofStrings"

//************************* Draw *************************

	function main() {

	    var graphGenerator = Viva.Graph.generator();
	    var graph = Viva.Graph.graph();
	    var pause = false;
	    var displayTag = false;
	    var container = document.body;

//**************************************************
// Determine the *.mtx file is 2 column or 3 column
// This is not a good way of doing it, but it works so I didn't improve it
//**************************************************

	    if ((arrayofStrings.length - (arrayofStrings[2] * 2 + 3)) <= 2)
	        k = 2;
	    else
	        k = 3;
	    for (var i = 0; i < arrayofStrings[2]; i++) {
	        graph.addLink(arrayofStrings[3 + i * k], arrayofStrings[3 + i * k + 1]);
	        if (arrayofStrings[3 + i * k] != arrayofStrings[3 + i * k + 1]) count++;
	    };

//************************ Init **************************
// Init layout, graphic domain, and renderer params
//**************************************************

	    var layout = Viva.Graph.Layout.forceDirected(graph, {
	        springLength: 30,
	        springCoeff: 0.0008,
	        dragCoeff: 0.1,
	        gravity: -1.2,
	        theta: 1
	    });

	    var graphics = Viva.Graph.View.webglGraphics();

	    var renderer = Viva.Graph.View.renderer(graph, {
	        layout: layout,
	        graphics: graphics,
	        renderLinks: true,
	        prerender: true,
	        container: container
	    });

//*********************** Labels ***************************
//Default the labels are hidden, so comment out
//It's EXTREMELY laggy if turned on with some giant graph
//**************************************************

	    // var domLabels = generateDOMLabels(graph);
	    // graphics.placeNode(function(ui, pos) {
	    //     var domPos = {
	    //         x: pos.x,
	    //         y: pos.y
	    //     };
	    //     // And ask graphics to transform it to DOM coordinates:
	    //     graphics.transformGraphToClientCoordinates(domPos);

	    //     // then move corresponding dom label to its own position:
	    //     var nodeId = ui.node.id;
	    //     var labelStyle = domLabels[nodeId].style;
	    //     labelStyle.left = domPos.x + 'px';
	    //     labelStyle.top = domPos.y + 'px';
	    // });

	    // function generateDOMLabels(graph) {
	    //     // this will map node id into DOM element
	    //     var labels = Object.create(null);
	    //     graph.forEachNode(function(node) {
	    //         var label = document.createElement('span');
	    //         label.classList.add('node-label');
	    //         label.innerText = node.id;
	    //         labels[node.id] = label;
	    //         container.appendChild(label);
	    //     });
	    //     // NOTE: If your graph changes over time you will need to
	    //     // monitor graph changes and update DOM elements accordingly
	    //     return labels;
	    // }

//**************************************************
// run renderer after appending the labels to position
//**************************************************

		renderer.run();

//************************ Mouse Event **************************

	    var doRecenter = true;
	    var events = Viva.Graph.webglInputEvents(graphics, graph);

	    events.click(function(node) {
	        //Reset color
	        graph.forEachNode(NodeClearColor);
	        graph.forEachLink(EdgeClearColor);

	        // draw Selected Node
	        DrawFocusedNode(node);

	        //  get Edges
	        var links = graph.getLinks(node.id);

	        // draw neighbors & edges

	        for (var i = 0; i < links.length; i++) {
	            if (links[i].fromId === links[i].toId) break;
	            if (links[i].fromId === node.id)
	                DrawNode(links[i].toId);
	            else
	                DrawNode(links[i].fromId);
	            DrawLink(links[i]);
	        }

	        // Move Camera, the recenter function
	        if(doRecenter){
		        var pos = layout.getNodePosition(node.id);
		        renderer.moveTo(pos.x, pos.y);
		    }

	        renderer.rerender();
	    });

	    // Node functions
	    function DrawFocusedNode(node) {
	        var nodeUI = graphics.getNodeUI(node.id);
	        nodeUI.color = 0xFFA500ff;
	        nodeUI.size = 20;
	    }

	    function NodeClearColor(node) {
	        var nodeUI = graphics.getNodeUI(node.id);
	        nodeUI.color = 0x009ee8ff;
	        nodeUI.size = 10;
	    }

	    // Link functions
	    function DrawNode(nodeid) {
	        var nodeUI = graphics.getNodeUI(nodeid);
	        nodeUI.color = 0xFF0000ff;
	    }

	    function EdgeClearColor(link) {
	        var linkUI = graphics.getLinkUI(link.id);
	        linkUI.color = 0xffffffff;
	    }

	    function DrawLink(link) {
	        var linkUI = graphics.getLinkUI(link.id);
	        linkUI.color = 0xFF0000ff;
	    }

//********************* Update html *****************************
//update the corresponding html tags with their data
//**************************************************

	    var nodecount = arrayofStrings[0];
	    if(Number(arrayofStrings[0]) < Number(arrayofStrings[1])) nodecount = arrayofStrings[1];

		$('.path').text(path);
		$('.nodecount').text(nodecount);
		$('.count').text(count);

//************************* Keyboard Events *************************

	    document.body.addEventListener('keydown', function(e) {
	        if (e.which === 32) { // spacebar
	            if (!pause) {
	                renderer.pause();
	                $('.pause-text').css('opacity', '1');
	            } else {
	                renderer.resume();
	                $('.pause-text').css('opacity', '0');
	            }
	            pause = !pause;
	        } else if (e.which === 27) { // ESCAPE
	            graph.forEachNode(NodeClearColor);
	            graph.forEachLink(EdgeClearColor);
	            renderer.rerender();
	        } else if (e.which === 67) { // C
	            doRecenter = !doRecenter;
	        } else if (e.which === 84) { // T
	            if (displayTag) {
	                $('.node-label').remove();
	            } else {
	                var domLabels = generateDOMLabels(graph);
	                graphics.placeNode(function(ui, pos) {
	                    var domPos = {
	                        x: pos.x,
	                        y: pos.y
	                    };
	                    // And ask graphics to transform it to DOM coordinates:
	                    graphics.transformGraphToClientCoordinates(domPos);

	                    // then move corresponding dom label to its own position:
	                    var nodeId = ui.node.id;
	                    var labelStyle = domLabels[nodeId].style;
	                    labelStyle.left = domPos.x + 'px';
	                    labelStyle.top = domPos.y + 'px';
	                });
	                renderer.rerender();
	            }
	            displayTag = !displayTag;
	        }
	    });
	}

//Loading appears before reading the file and drawing
//deleted after first run

	$('.loading').remove();
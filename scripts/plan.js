
// --------------------- plans generation and variables initialisation --------------------------
// Set up dimensions and variables
const width = 500;
const height = 500;
const padding = 40;
const pointRadius = 8;
let pointColor = "lightblue";
let RealpointColor = "blue";
const animationDuration = 1000;
const updateInterval = 2000;

//variables for the grid creation
const gridSize = 26.25; //size of each cell
const gridWidth = 16;
const gridHeight = 16;



// Set up SVG containers (estimated position)
const svg = d3.select("#plan")
  .attr("width", width)
  .attr("height", height);


// Set up scales for x and y axes
const xScale = d3.scaleLinear()
  .domain([0, 8])
  .range([padding, width - padding]);

const yScale = d3.scaleLinear()
  .domain([8, 0])
  .range([padding, height - padding]);


// Draw x axis
svg.append("g")
  .attr("transform", "translate(0," + (height - padding) + ")")
  .call(d3.axisBottom(xScale));

// Draw y axis

svg.append("g")
  .attr("transform", "translate(" + padding + ",0)")
  .call(d3.axisLeft(yScale));

// Generate grid lines
for (let i = 0; i <= gridWidth; i++) {
  svg.append("line")
    .attr("x1", i * gridSize + padding)
    .attr("y1", 0 + padding)
    .attr("x2", i * gridSize + padding)
    .attr("y2", gridHeight * gridSize + padding)
    .attr("stroke", "lightgray");
}

for (let i = 0; i <= gridHeight; i++) {
  svg.append("line")
    .attr("x1", 0 + padding)
    .attr("y1", i * gridSize + padding)
    .attr("x2", gridWidth * gridSize + padding)
    .attr("y2", i * gridSize + padding)
    .attr("stroke", "lightgray");
}

// Define the points group (multiple possible positions)
const points = svg.append("g");
points.append("circle");


// ---------------------- Point display functions ---------------------------

// Function to update the estimated point's position
async function updatePoint() {
  const response = await fetch("get_coordinates.php");
  const coord = await response.json();
  pointColor = "lightgrey";

  // check if the update table function is set, 
  // if yes, we are loged in as admin so we need to update the dynamic table
  if (typeof updateTable == 'function') { 
    updateTable(coord);
  }

  // Filter data to only contain the two points we want to display
  // If there are 3 points to display, their position will be the ones at the index i, i+1, i+2
  if (coord['x'].length == 3) {
    filteredData = [
      { x: coord['x'][0], y: coord['y'][0] },
      { x: coord['x'][1], y: coord['y'][1] },
      { x: coord['x'][2], y: coord['y'][2] }
    ];
    
    // If there are 2 points to display, their position will be the ones at the index i and i+1
    // 2 points will be sent to i+1 so it will look like, there are only 2 points
  } else if(coord['x'].length == 2) {
    filteredData = [
      { x: coord['x'][0], y: coord['y'][0] },
      { x: coord['x'][1], y: coord['y'][1] },
      { x: coord['x'][1], y: coord['y'][1] }
    ];
  } else {
    // Update the unique point position with animation
    filteredData = [
      { x: coord['x'][0], y: coord['y'][0] },
      { x: coord['x'][0], y: coord['y'][0] },
      { x: coord['x'][0], y: coord['y'][0] }
    ];
    pointColor = "lightblue";
  }
      points
      .selectAll("circle")
      .data(filteredData) // Pass the filtered data here
      .join("circle")
      .attr("r", pointRadius)
      .style("fill", pointColor)
      .transition()
      .duration(animationDuration)
      .attr("cx", d => xScale(d.x))
      .attr("cy", d => yScale(d.y));
}

// ---------------------- Real and estimated point's position ---------------------------

// Automatically update the point's position at regular intervals
setInterval(updatePoint, updateInterval);


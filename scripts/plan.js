
// --------------------- plan generation --------------------------
// Set up dimensions and variables
const width = 500;
const height = 500;
const padding = 40;
const pointRadius = 8;
let pointColor = "lightblue";
let multiple_color = "lightgrey";
const animationDuration = 1000;
const updateInterval = 2000;

//variables for the grid creation
const gridSize = 26.25; //size of each cell
const gridWidth = 16;
const gridHeight = 16;

// Set up SVG container
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


// Function to update the point's position
async function updatePoint() {
    const response = await fetch("get_coordinates.php");
    const coord = await response.json();

    //if there are multiple possible coordinates for the same measurement
    if (coord['x'].length > 1) {
          // Filter data to only contain the two points we want to display
          const filteredData = [
          { x: coord['x'][0], y: coord['y'][0] },
          { x: coord['x'][1], y: coord['y'][1] }
          ];
          // console.log (coord['x'][0] + " ; " + coord['y'][0]);
          // console.log (coord['x'][1] + " ; " +  coord['y'][1]);
          points
          .selectAll("circle")
          .data(filteredData) // Pass the filtered data here
          .join("circle")
          .attr("r", pointRadius)
          .style("fill", multiple_color)
          .transition()
          .duration(animationDuration)
          .attr("cx", d => xScale(d.x))
          .attr("cy", d => yScale(d.y));

    } else {
        // Update the unique point position with animation
        const filteredData = [
            { x: coord['x'][0], y: coord['y'][0] },
            { x: coord['x'][0], y: coord['y'][0] }
            ];
        console.log("entering unique point animation");
        points
        .selectAll("circle")
        .data(filteredData)
        .attr("r", pointRadius)
        .style("fill", pointColor)
        .transition()
        .duration(animationDuration)
        .attr("cx", d => xScale(d.x))
        .attr("cy", d => yScale(d.y));
    }
    interval = 0;

}
// Automatically update the point's position at regular intervals
setInterval(updatePoint, updateInterval);

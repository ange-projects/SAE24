// Set up dimensions and variables
const width = 500;
const height = 500;
const padding = 40;
const pointRadius = 8;
squareSize = width/9;
const pointColor = squareColor = "steelblue";
const animationDuration = 1000;
const updateInterval = 3000;

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
    previousX = 0;
    previousY = 0;

// Function to update the point's position
function updatePoint() {
  console.log("entering update point");
  fetch("get_coordinates.php")
    .then(response => response.json())
    .then(coord => {
      //if there are multiple possible coordinates for the same measurment
      if(coord['x'].length > 1){
          //for each element of the array, extract and store x and y values
          console.log("entering for loop");
          for (var i = 0; i < coord['x'].length; i++) {
            //define the possible_points object as all the possible_position_group circles
            points
            .selectAll("circle")
              //apply attributes to each circle
              .data(coord['x'].map((x, i) => ({ x: x, y: coord['y'][i] })))
              .join("circle")
              .attr("r", pointRadius)
              .style("fill", "lightgrey")
              .transition()
              .duration(animationDuration)
              .attr("cx", d => xScale(d.x))
              .attr("cy", d => yScale(d.y));
            }
          } else {
            // Update the unique point position with animation
            console.log("entering unique point animation");
            newX = (coord['x'][0]);
            newY = (coord['y'][0]);
            points
            .selectAll("circle")
            .transition()
            .duration(animationDuration)
            .style("fill", "lightblue")
            .attr("cx", d => xScale(newX))
            .attr("cy", d => yScale(newY));
        }
          //store the actual value of one point, it will be the starting point of the future one
          previousX = (coord['x'][0]);
          previousY = (coord['y'][0]);
    })
    .catch(error => console.error(error));
}
// Automatically update the point's position at regular intervals
setInterval(updatePoint, updateInterval);

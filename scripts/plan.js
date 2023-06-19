// ---------------------- form handling ---------------------------
let interval = 0;
// Get the form element
const form = document.getElementById('display_history');
console.log(form);
// Attach an event listener to the form's submit event
form.addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the default form submission

  // Access the form elements and retrieve their values
  const intervalInput = document.getElementById('interval');
  interval = intervalInput.value;
  console.log('interval found is' + interval);

});
// --------------------- plan generation --------------------------
// Set up dimensions and variables
const width = 500;
const height = 500;
const padding = 40;
const pointRadius = 8;
squareSize = width/9;
let pointColor = "lightblue";
let multiple_color = "lightgrey";
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
points.append("circle");


// Function to update the point's position
async function updatePoint() {
    const response = await fetch("get_history.php?interval=" + interval);
    const coord = await response.json();
    //if there are multiple possible coordinates for the same measurement
    if (coord['x'].length > 1) {
        // console.log("length is :" + coord['x'].length);
      if (coord['x'].length > 2){
        console.log("chnaging color");
        multiple_color = "red";
        pointColor = "red";
      }
      var i = 0;
      while (i < coord['x'].length) {
            console.log(i);
            // console.log("i is " + i + "going until " + coord['x'].length);
            if (coord['id'][i] === coord['id'][i+1] || coord['id'].length == 1) {
                // Filter data to only contain the two points we want to display
                const filteredData = [
                { x: coord['x'][i], y: coord['y'][i] },
                { x: coord['x'][i + 1], y: coord['y'][i + 1] }
                ];
                console.log (coord['x'][i] + " ; " + coord['y'][i]);
                console.log (coord['x'][i + 1] + " ; " +  coord['y'][i + 1]);
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

                // Add delay before moving to the next iteration
                await new Promise(resolve => setTimeout(resolve, 10000));
                i=+2;
            } else {
                const filteredData = [
                    { x: coord['x'][0], y: coord['y'][0] },
                    { x: coord['x'][0], y: coord['y'][0] }
                    ];
                console.log(coord['x'][0] + " ; " +  coord['y'][0]);
                points
                .selectAll("circle")
                .data(filteredData)
                .attr("r", pointRadius)
                .style("fill", pointColor)
                .transition()
                .duration(animationDuration)
                .attr("cx", d => xScale(d.x))
                .attr("cy", d => yScale(d.y));
                i++;
            }

        }
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
    multiple_color = "lightgrey";
    pointColor = "lightblue";
}
// Automatically update the point's position at regular intervals
setInterval(updatePoint, updateInterval);

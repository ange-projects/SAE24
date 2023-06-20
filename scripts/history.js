// --------------------- plan generation --------------------------
// Set up dimensions and variables
const width = 500;
const height = 500;
const padding = 40;
const pointRadius = 8;
let pointColor = "lightblue";
let multiple_color = "lightgrey";
const animationDuration = 1000;
const updateInterval = 5000;

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
    let add = 0;
    let filteredData;
    console.log("starting");
    for (let i = 0; i <= coord['id'].length; i += add) {

        if (coord['id'][i] === coord['id'][i+1]) {
        // Filter data to only contain the two points we want to display
            filteredData = [
            { x: coord['x'][i], y: coord['y'][i] },
            { x: coord['x'][i + 1], y: coord['y'][i + 1] }
            ];
            add = 2;
        } else {
            // Update the unique point position with animation
            filteredData = [
                { x: coord['x'][i], y: coord['y'][i] },
                { x: coord['x'][i], y: coord['y'][i] }
                ]; + 1
            add = 1;
        }
        console.log (coord['x'][0] + " ; " + coord['y'][0]);
        console.log (coord['x'][1] + " ; " +  coord['y'][1]);
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

        await new Promise(resolve => setTimeout(resolve, 2000)); // Wait for 5 seconds

    }
    }
// ---------------------- form handling ---------------------------
let interval = 10;
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

  updatePoint() ;
});
// Automatically update the point's position at regular intervals
// setInterval(updatePoint, updateInterval);

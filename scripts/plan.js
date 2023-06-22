
// --------------------- plan generation --------------------------
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

// set the deault DB name (normal)
let bdd = "coord_points";

// Set up SVG containers
const svg = d3.select("#plan")
  .attr("width", width)
  .attr("height", height);

const Realsvg = d3.select("#RealPosition")
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
Realsvg.append("g")
  .attr("transform", "translate(0," + (height - padding) + ")")
  .call(d3.axisBottom(xScale));

svg.append("g")
  .attr("transform", "translate(0," + (height - padding) + ")")
  .call(d3.axisBottom(xScale));

// Draw y axis
Realsvg.append("g")
  .attr("transform", "translate(" + padding + ",0)")
  .call(d3.axisLeft(yScale));

svg.append("g")
  .attr("transform", "translate(" + padding + ",0)")
  .call(d3.axisLeft(yScale));

// Generate grid lines
for (let i = 0; i <= gridWidth; i++) {
  Realsvg.append("line")
    .attr("x1", i * gridSize + padding)
    .attr("y1", 0 + padding)
    .attr("x2", i * gridSize + padding)
    .attr("y2", gridHeight * gridSize + padding)
    .attr("stroke", "lightgray");

  svg.append("line")
    .attr("x1", i * gridSize + padding)
    .attr("y1", 0 + padding)
    .attr("x2", i * gridSize + padding)
    .attr("y2", gridHeight * gridSize + padding)
    .attr("stroke", "lightgray");
}

for (let i = 0; i <= gridHeight; i++) {
  Realsvg.append("line")
    .attr("x1", 0 + padding)
    .attr("y1", i * gridSize + padding)
    .attr("x2", gridWidth * gridSize + padding)
    .attr("y2", i * gridSize + padding)
    .attr("stroke", "lightgray");

  svg.append("line")
    .attr("x1", 0 + padding)
    .attr("y1", i * gridSize + padding)
    .attr("x2", gridWidth * gridSize + padding)
    .attr("y2", i * gridSize + padding)
    .attr("stroke", "lightgray");
}

function updateTable(coords) {
  // Get a reference to the table body
  var tableBody = document.querySelector('table tbody');
  // Clear the existing table content
  tableBody.innerHTML = '';

  // Create table rows for each data point
  for (var i = 0; i < coords['x'].length; i++) {
    // Create a new table row
    var row = document.createElement('tr');
    // Create table cells and fill them with coord data
    var idCell = document.createElement('td');
    idCell.textContent = coords['id'][0];
    row.appendChild(idCell);

    var poidCell = document.createElement('td');
    poidCell.textContent = coords['x'][i];
    row.appendChild(poidCell);

    var xCell = document.createElement('td');
    xCell.textContent = coords['x'][i];
    row.appendChild(xCell);

    var yCell = document.createElement('td');
    yCell.textContent = coords['y'][i];
    row.appendChild(yCell);

    var timeCell = document.createElement('td');
    timeCell.textContent = coords['time'][i];
    row.appendChild(timeCell);


    // Add the row to the table body
    tableBody.appendChild(row);
  }
}


  // Define the points group (multiple possible positions)
const points = svg.append("g");
const Realpoint = Realsvg.append("g");
points.append("circle");

// Function to update the point's position
async function updateRealPoint() {
  // const response = await fetch("get_coordinates.php?type=real");
  const response = await fetch("get_coordinates.php");
  const Realcoord = await response.json();
    // Update the unique point position with animation
    filteredData = [
      { x: Realcoord['x'][0], y: Realcoord['y'][0] }
      ];
      console.log("real point filtered data is " + filteredData.x);
      pointColor = "lightblue";
      Realpoint
      .selectAll("circle")
      .data(filteredData) // Pass the filtered data here
      .join("circle")
      .attr("r", pointRadius)
      .style("fill", RealpointColor)
      .transition()
      .duration(animationDuration)
      .attr("cx", d => xScale(d.x))
      .attr("cy", d => yScale(d.y));
}

// Function to update the estimated point's position
async function updatePoint() {
  const response = await fetch("get_coordinates.php");
  const coord = await response.json();
  pointColor = "lightgrey";
  updateTable(coord);

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
  interval = 0;

// Get the degradation form element
const formDeg = document.getElementById('degradation');


// Get references to the checkboxes and radio buttons
var checkboxes = document.querySelectorAll('input[type="checkbox"]');
// var radioButtons = document.querySelectorAll('input[type="radio"]');

// Create a function to check if any checkbox is checked
function isChecked(Myfield) {
  for (var i = 0; i < Myfield.length; i++) {
    if (Myfield[i].checked) {
      return true;
    }
  }
  return false;
}

// Check if at least one checkbox or radio button is checked when the form is submitted
formDeg.addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the default form submission
  if (isChecked(checkboxes)) {
    console.log("element checked");
    bdd = "coord_points_deg";
  } else {
    console.log("element not checked");
  }
});

// Automatically update the point's position at regular intervals
setInterval(updatePoint, updateInterval);

// Automatically update the real point's position at regular intervals
setInterval(updateRealPoint, updateInterval);
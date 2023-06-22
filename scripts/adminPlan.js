
// --------------------- plan generation and variable initialisation --------------------------

//history variables
let wait_time = 1000; //history speed
let running = 0; //takes 1 if history is running


//Set up Realsvg container (real position)
const Realsvg = d3.select("#RealPosition")
.attr("width", width)
.attr("height", height);

// Set up svg_history container
const svg_history = d3.select("#history_plan")
  .attr("width", width)
  .attr("height", height);

// Draw x axis
Realsvg.append("g")
  .attr("transform", "translate(0," + (height - padding) + ")")
  .call(d3.axisBottom(xScale));

svg_history.append("g")
  .attr("transform", "translate(0," + (height - padding) + ")")
  .call(d3.axisBottom(xScale));

// Draw y axis
Realsvg.append("g")
  .attr("transform", "translate(" + padding + ",0)")
  .call(d3.axisLeft(yScale));

svg_history.append("g")
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
    
    svg_history.append("line")
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

    svg_history.append("line")
      .attr("x1", 0 + padding)
      .attr("y1", i * gridSize + padding)
      .attr("x2", gridWidth * gridSize + padding)
      .attr("y2", i * gridSize + padding)
      .attr("stroke", "lightgray");
}

// Define the points group (multiple possible positions)
const history_points = svg_history.append("g");
const Realpoint = Realsvg.append("g");
points.append("circle");


// ---------------------- Point display functions ---------------------------

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

// function used to update the dynamic table based on the estimated position
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

// Function used to display the history as requested in the form
async function updateHistory() {
    const response = await fetch("get_coordinates.php?interval=" + interval);
    const coord = await response.json();
    running = 1;
    let add = 0;
    let filteredData;
    console.log("starting");
    for (let i = 0; i <= coord['id'].length; i += add) {
      await new Promise(resolve => setTimeout(resolve, wait_time)); // Wait for 1 seconds
        if (coord['id'][i] === coord['id'][i+1]) {
          console.log("coord['id'][i]");
            // If there are 3 points to display, their position will be the ones at the index i, i+1, i+2
          if (coord['id'][i] === coord['id'][i+2]) {
            filteredData = [
              { x: coord['x'][i], y: coord['y'][i] },
              { x: coord['x'][i + 1], y: coord['y'][i + 1] },
              { x: coord['x'][i + 2], y: coord['y'][i + 2] }
            ];
            add = 3;
            
            // If there are 2 points to display, their position will be the ones at the index i and i+1
            // 2 points will be sent to i+1 so it will look like, there are only 2 points
          } else {
              filteredData = [
              { x: coord['x'][i], y: coord['y'][i] },
              { x: coord['x'][i + 1], y: coord['y'][i + 1] },
              { x: coord['x'][i + 1], y: coord['y'][i + 1] }
              ];
              add = 2;
          }

        } else {
            // If there is only one point to display, all the points are sent to one position
            filteredData = [
                { x: coord['x'][i], y: coord['y'][i] },
                { x: coord['x'][i], y: coord['y'][i] },
                { x: coord['x'][i], y: coord['y'][i] }
                ];
            add = 1;
        }

        console.log ("history update");
        history_points
          .selectAll("circle")
          .data(filteredData) // Pass the filtered data here
          .join("circle")
          .attr("r", pointRadius)
          .style("fill", "#fc5353")
          .transition()
          .duration(wait_time)
          .attr("cx", d => xScale(d.x))
          .attr("cy", d => yScale(d.y));
    }
  history_points
    .selectAll("circle")
    .remove();
    running = 0;
}

// ---------------------- history form handling ---------------------------

// --- speed changer form ---
// Get the form element
function change_speed(speed){
  wait_time = speed;
}

let interval = 0;
// Get the form element
const form = document.getElementById('display_history');
console.log(form);
// Attach an event listener to the form's submit event
form.addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the default form submission

  // Access the form elements and retrieve their values
  const intervalInput = document.getElementById('intervalBar');
  interval = intervalInput.value;

  if (running == 0){
    updateHistory() ;
  }
});

// ---------------------- estimated point position ---------------------------

// Automatically update the real point's position at regular intervals
setInterval(updateRealPoint, updateInterval);


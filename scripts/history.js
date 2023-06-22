wait_time = 1000;

// Set up svg_history container
const svg_history = d3.select("#history_plan")
  .attr("width", width)
  .attr("height", height);


// Draw x axis
svg_history.append("g")
  .attr("transform", "translate(0," + (height - padding) + ")")
  .call(d3.axisBottom(xScale));

// Draw y axis
svg_history.append("g")
  .attr("transform", "translate(" + padding + ",0)")
  .call(d3.axisLeft(yScale));

  // Generate grid lines
for (let i = 0; i <= gridWidth; i++) {
  svg_history.append("line")
    .attr("x1", i * gridSize + padding)
    .attr("y1", 0 + padding)
    .attr("x2", i * gridSize + padding)
    .attr("y2", gridHeight * gridSize + padding)
    .attr("stroke", "lightgray");
}
let running = 0;

for (let i = 0; i <= gridHeight; i++) {
  svg_history.append("line")
    .attr("x1", 0 + padding)
    .attr("y1", i * gridSize + padding)
    .attr("x2", gridWidth * gridSize + padding)
    .attr("y2", i * gridSize + padding)
    .attr("stroke", "lightgray");
}


  // Define the history_points group (multiple possible positions)
const history_points = svg_history.append("g");



// Function to update the point's position
async function updatePoint() {
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


// ---------------------- form handling ---------------------------

// --- speed changer form ---
// Get the form element
function change_speed(speed){
  wait_time = speed;
}

// --- Starting form ---
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
    updatePoint() ;
  }
});

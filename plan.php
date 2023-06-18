<!DOCTYPE html>
<html>
<head>
  <title>Dynamic Plan with D3.js</title>
  <script src="https://d3js.org/d3.v6.min.js"></script>
</head>
<body>
  <h1>Dynamic Plan</h1>

  <svg id="plan" width="500" height="500"></svg>

  <script>
    // Set up dimensions and variables
    const width = 500;
    const height = 500;
    const padding = 40;
    const pointRadius = 8;
    squareSize = width/9;
    const pointColor = squareColor = "steelblue";
    const animationDuration = 1000;
    const updateInterval = 3000;
    const gridSize = 9; // Number of rows and columns in the grid

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

    // Draw the grid lines
    svg.append("g")
      .selectAll("line")
      .data(d3.range(gridSize))
      .join("line")
      .attr("x1", d => xScale(d))
      .attr("y1", padding)
      .attr("x2", d => xScale(d))
      .attr("y2", height - padding)
      .attr("stroke", "lightgray");

    svg.append("g")
      .selectAll("line")
      .data(d3.range(gridSize))
      .join("line")
      .attr("x1", padding)
      .attr("y1", d => yScale(d))
      .attr("x2", width - padding)
      .attr("y2", d => yScale(d))
      .attr("stroke", "lightgray");

    // Define the point
    const point = svg.append("circle")
      .attr("r", pointRadius)
      .style("fill", pointColor)
      .attr("opacity", 0);

      // Define the point group (multiple possible positions)
    const possible_position_group = svg.append("g");

    // Function to update the point's position
    function updatePoint() {
      console.log("entering update point");
      possible_position_group.selectAll("circle")
      .remove(); // Clear previous circles
      fetch("get_coordinates.php")
        .then(response => response.json())
        .then(coord => {
            //if there are multiple possible coordinates for the same measurment
            if(coord['x'].length > 1){

              point.attr("opacity", 0); //remove the blue point
              
              //for each element of the array, extract and store x and y values
              console.log("entering for loop");
              for (var i = 0; i < coord['x'].length; i++) {
                if (typeof newX == 'undefined') {
                newX = 0;
                newY = 0;
                }
                console.log(i);
                console.log("adding a point at "+coord['x'][i] +" ; "+ coord['y'][i])
                //define the possible_points object as all the possible_position_group circles
                possible_position_group
                  .selectAll("circle")
                  //apply attributes to each circle
                  .data(coord['x'].map((x, i) => ({ x: x, y: coord['y'][i] })))
                  .join("circle")
                  .attr("r", pointRadius)
                  .style("fill", "grey")
                  .attr("cx", xScale(newX))
                  .attr("cy", yScale(newY))
                  .transition()
                  .attr("opacity", 1)
                  .duration(animationDuration)
                  .attr("cx", d => xScale(d.x))
                  .attr("cy", d => yScale(d.y));
              }

            } else {

              // Update the unique point position with animation
              newX = (coord['x'][0]);
              newY = (coord['y'][0]);

              console.log("entering unique point animation");
              point.transition()
                  .attr("opacity", 1)
                  .duration(animationDuration)
                  .attr("cx", xScale(newX))
                  .attr("cy", yScale(newY))
            }
        })
        .catch(error => console.error(error));
    }

    // Automatically update the point's position at regular intervals
    setInterval(updatePoint, updateInterval);
  </script>
</body>
</html>


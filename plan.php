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
    const pointColor = "steelblue";
    const animationDuration = 1000;
    const updateInterval = 2000;

    // Set up SVG container
    const svg = d3.select("#plan")
      .attr("width", width)
      .attr("height", height);

    // Set up scales for x and y axes
    const xScale = d3.scaleLinear()
    .domain([0, 8])
    .range([padding, width - padding]); //minimum output value is padding. The maximum output value is width minus the padding. 

    const yScale = d3.scaleLinear()
      .domain([8, 0])
      .range([padding, height - padding]); //minimum output value corresponds to height minus the padding. The maximum output value is padding

    // Draw x axis
    svg.append("g")
      .attr("transform", "translate(0," + (height - padding) + ")") // move horizontally by 0 unit, move vertically by "height - padding"
      .call(d3.axisBottom(xScale)); // generates the x-axis using the d3.axisBottom function

    // Draw y axis
    svg.append("g")
      .attr("transform", "translate(" + padding + ",0)") // move it horizontally by the padding so it is not inside it
      .call(d3.axisLeft(yScale)); // generates the y-axis using the d3.axisLeft function

    // defines the point
    const point = svg.append("circle")
      .attr("r", pointRadius)
      .style("fill", pointColor);

    // Function to update the point's position
    function updatePoint() {
    fetch("get_coordinates.php") // Replace "get_coordinates.php" with the correct PHP file path
        .then(response => response.json())
        .then(coord => {
            console.log(coord);
        // Calculate new coordinates for the point
        const newX = coord[0]; // Adjust the calculation as per your requirement
        const newY = coord[1]; // Adjust the calculation as per your requirement

        // Update the point's position with animation
        point.transition()
            .duration(animationDuration)
            .attr("cx", xScale(newX))
            .attr("cy", yScale(newY));
        })
        .catch(error => console.error(error));
    }

    // Automatically update the point's position at regular intervals
    setInterval(updatePoint, updateInterval);
  </script>
</body>
</html>

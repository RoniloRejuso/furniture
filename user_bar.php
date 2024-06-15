<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vertical Color Bar</title>
<style>
  .color-bar-container {
    display: flex;
    align-items: flex-end;
  }

  .color-bar {
    width: 30px;
    height: 300px; /* Adjust height as needed */
    background: linear-gradient(to bottom,
      rgb(255, 0, 0) 0%,
      rgb(255, 51, 0) 2.86%, /* 1/35 */
      rgb(255, 102, 0) 5.71%, /* 2/35 */
      rgb(255, 153, 0) 8.57%, /* 3/35 */
      rgb(255, 204, 0) 11.43%, /* 4/35 */
      rgb(255, 255, 0) 14.29%, /* 5/35 */
      rgb(204, 255, 0) 17.14%, /* 6/35 */
      rgb(153, 255, 0) 20%, /* 7/35 */
      rgb(102, 255, 0) 22.86%, /* 8/35 */
      rgb(51, 255, 0) 25.71%, /* 9/35 */
      rgb(0, 255, 0) 28.57%, /* 10/35 */
      rgb(0, 255, 51) 31.43%, /* 11/35 */
      rgb(0, 255, 102) 34.29%, /* 12/35 */
      rgb(0, 255, 153) 37.14%, /* 13/35 */
      rgb(0, 255, 204) 40%, /* 14/35 */
      rgb(0, 255, 255) 42.86%, /* 15/35 */
      rgb(0, 204, 255) 45.71%, /* 16/35 */
      rgb(0, 153, 255) 48.57%, /* 17/35 */
      rgb(0, 102, 255) 51.43%, /* 18/35 */
      rgb(0, 51, 255) 54.29%, /* 19/35 */
      rgb(0, 0, 255) 57.14%, /* 20/35 */
      rgb(51, 0, 255) 60%, /* 21/35 */
      rgb(102, 0, 255) 62.86%, /* 22/35 */
      rgb(153, 0, 255) 65.71%, /* 23/35 */
      rgb(204, 0, 255) 68.57%, /* 24/35 */
      rgb(255, 0, 255) 71.43%, /* 25/35 */
      rgb(255, 0, 204) 74.29%, /* 26/35 */
      rgb(255, 0, 153) 77.14%, /* 27/35 */
      rgb(255, 0, 102) 80%, /* 28/35 */
      rgb(255, 0, 51) 82.86%, /* 29/35 */
      rgb(255, 0, 0) 85.71%, /* 30/35 */
      rgb(255, 51, 0) 88.57%, /* 31/35 */
      rgb(255, 102, 0) 91.43%, /* 32/35 */
      rgb(255, 153, 0) 94.29%, /* 33/35 */
      rgb(255, 204, 0) 97.14%, /* 34/35 */
      rgb(255, 255, 0) 100% /* 35/35 */
    );
    margin-right: 10px; /* Adjust margin as needed */
  }
  
  .color-bar-labels {
    font-size: 12px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-end;
    margin-right: 5px; /* Adjust margin as needed */
  }

  /* Add space between labels */
  .color-bar-labels div {
    margin-bottom: 5px;
  }
</style>
</head>
<body>
  <div class="color-bar-container">
    <div class="color-bar"></div>
    <div class="color-bar-labels">
      <div>350</div>
      <div>300</div>
      <div>250</div>
      <div>200</div>
      <div>150</div>
      <div>100</div>
      <div>50</div>
      <div>0</div>
    </div>
  </div>
</body>
</html>

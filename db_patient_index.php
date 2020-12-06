<?php
session_start();
$_SESSION['page'] = "dashboard";
require("db_patient_header.php");

?>
 <!-- cards -->
 <section>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
        <div class="row pt-md-5 mt-md-3 mb-5">

          <div class="col-xl-8 p-2">
            <div class="card card-common">
              <div class="card-body">
                <div class="d-flex ">
                  <i class="fas fa-calendar-check fa-3x text-danger"></i>
                  <div class="text-center text-secondary mx-auto">
                    <h5>Upcoming appointments</h5>
                    <?php
$sql = "SELECT DESCRIPTION, DATE, TIME, STATUS FROM appointment WHERE PATIENT_ID = ANY(SELECT PATIENT_ID FROM users WHERE USER_ID = '$user_check') AND DATE>CURDATE() AND STATUS = 1  LIMIT 4 ";
$result = mysqli_query($conn,$sql);
  if(mysqli_num_rows($result)){
 echo "<table class='table table-danger table-striped  text-center mt-2'>
              <thead>
                <tr class='text-muted'>
                  <th>#</th>
                  <th>Description</th>
                  <th>Date</th>
                  <th>Time</th>
                </tr>
              </thead>
              <tbody>
              ";
              $i=1;
            while($row = mysqli_fetch_assoc($result)){
              echo "<tr>
                  <th scope='row'>".$i."</th>
                  <td>".$row['DESCRIPTION']."</td>
                  <td>".$row['DATE']."</td>
                  <td>".$row['TIME']."</td></tr>";
                  $i++;
            }
                echo "
              </tbody>
            </table>";
  }else{
    echo "<div class='alert alert-info'>There is no appointment today</div>";
  }
 
                    ?>

                   

                  </div>
                </div>
              </div>
              <div class="card-footer text-secondary">
                <i class="fas fa-sync mr-3"></i>
                <a href="db_patient_index.php"><span>Updated Now</span></a>
              </div>
            </div>
          </div>

          <div class="col-xl-4 p-2">
            <div class="card card-common">
              <div class="card-body">
                <p class="text-center">Press the link below to make a new appointment request!</p>
                <a href="db_patient_request.php" class="btn btn-info btn-block">Request Now!</a>

              </div>
            </div>
          </div>




        </div>
      </div>
    </div>
  </div>
</section>
<!-- end of cards -->

<div class="container-fluid" style="height: 75vh">
    <div class="row mt-md-5 mb-5">
        <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
            <div class="row align-items-center">
                <div class="col" style="overflow-x:auto;">
                    <div class="d-flex justify-content-between align-items-center ml-2 mr-2 mt-2">
                        <h3 class="text-muted text-center mb-3 d-flex">Overall Patient records</h3>
                        <select class="form-control" id="chartType" style="width: 20%">
<!--                            <option value="day">Appointment Day</option>-->
<!--                            <option value="gender">Gender</option>-->
                            <option value="bmi">Body Mass Index</option>
                            <option value="blood">Blood Pressure</option>
                            <option value="ldl">Cholesterol Level</option>
                        </select>
                    </div>
                    <br><br>
                    <div class="chart" style="display: flex; justify-content: space-around">
                        <div style="width: 43%">
                            <canvas id="canvas1" width="300px" height="400px"></canvas>
                        </div>
                        <div style="width: 43%">
                            <canvas id="canvas2" width="300px" height="400px"></canvas>
                        </div>
                    </div>
                    <br>
                    <div id="chartType" style="display: flex; justify-content: space-around">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline-primary" id="bar">Bar</button>
                            <button type="button" class="btn btn-outline-primary" id="line">Line</button>
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline-primary" id="doughnut">Doughnut</button>
                            <button type="button" class="btn btn-outline-primary" id="pie">Pie</button>
                            <button type="button" class="btn btn-outline-primary" id="polar">Polar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- footer starts-->
<footer>
  <div class="container-fluid  mt-5">
    <div class="row">
      <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
        <div class="row border-top pt-3">
          <div class="col text-center">
            <p>&copy; 2019 Copyright All rights reserved - HealthInsider</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- end of footer -->


<script src="js\db_index.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
<script src="js/myChart.js"></script>
<script src="js/patientChart.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

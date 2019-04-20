<?php
require("db_patient_header.php"); ?>
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
                    <table class="table table-danger table-striped  text-center mt-2">
                      <thead>
                        <tr class="text-muted">
                          <th>#</th>
                          <th>Patient</th>
                          <th>Doctor</th>
                          <th>Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th>1</th>
                          <td>Ali</td>
                          <td>Dr.Abu</td>
                          <td>9-9.45am</td>
                        </tr>
                        <tr>
                          <th>2</th>
                          <td>Lord</td>
                          <td>Dr.Sun</td>
                          <td>11-11.45am</td>
                        </tr>
                        <tr>
                          <th>3</th>
                          <td>Jason</td>
                          <td>Dr.Window</td>
                          <td>1-2.45pm</td>
                        </tr>
                        <tr>
                          <th>4</th>
                          <td>James</td>
                          <td>Dr.Door</td>
                          <td>4-4.45pm</td>
                        </tr>
                      </tbody>
                    </table>


                  </div>
                </div>
              </div>
              <div class="card-footer text-secondary">
                <i class="fas fa-sync mr-3"></i>
                <span>Updated Now</span>
              </div>
            </div>
          </div>

          <div class="col-xl-4 p-2">
            <div class="card card-common">
              <div class="card-body">
                <p class="text-center">Press the link below to make an appointment request</p>
                <a href="db_patient_request.html" class="btn btn-secondary btn-block">request</a>

              </div>
            </div>
          </div>

          <div class="col-sm-12">
            <p class="divider-text">
              <span class="bg-light">Patient analysis for reference</span>
            </p>
          </div>


          <div class="col-xl-6 p-2">
            <div class="card card-common">
              <div class="card-body">
                <img class="img-fluid" src="images/BMIPieChart.png">
              </div>
            </div>
          </div>
          <div class="col-xl-6 p-2">
            <div class="card card-common">
              <div class="card-body">
                <img class="img-fluid" src="images/colesterolPieChart.png">
              </div>
            </div>
          </div>
          <div class="col-xl-6 p-2">
            <div class="card card-common">
              <div class="card-body">
                <img class="img-fluid" src="images/blood-pressure-graph.png">
              </div>
            </div>
          </div>
          <div class="col-xl-6 p-2">
            <div class="card card-common">
              <div class="card-body">
                <img class="img-fluid" src="images/cholesterol-graph.png">
              </div>
            </div>
          </div>






        </div>
      </div>
    </div>
  </div>
</section>
<!-- end of cards -->


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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

<?php
session_start();  
$_SESSION['page'] = "request";
require("db_patient_header.php");
$sql = "SELECT DISTINCT SPECIALIZATION FROM doctor";
$result = mysqli_query($conn,$sql);

?>
<script type="text/javascript">
    function showDoctor(str) {
    if (str == "") {
        document.getElementById("doctor").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("doctor").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","db_patient_request_doctor.php?specialization="+str,true);
        xmlhttp.send();
    }
}

function showDate(str) {
    if (str == "") {
        document.getElementById("date").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("date").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","db_patient_request_doctor.php?doctor="+str,true);
        xmlhttp.send();
    }
}

function showTime(str) {
    if (str == "") {
        document.getElementById("time").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("time").innerHTML = this.responseText;
            }
        };
        console.log(document.getElementById('doctor').value);
        xmlhttp.open("GET","db_patient_request_doctor.php?date="+str+"&doctor="+document.getElementById('doctor').value,true);
        xmlhttp.send();
    }
}
  </script>


  <!-- right section -->
  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
          <div class="row pt-md-5 mt-md-3 mb-5">

            <!-- container starts -->
            <div class="container-fluid">
              <div class="card bg-light">
                <article class="card-body mx-auto" style="max-width: 500px;">
                  
                  <h4 class="card-title mt-3 text-center">Appointment request</h4>
                  <p class="text-center">Fill up the form below to make an appointment request</p>

                  <p class="divider-text">
                    <span class="bg-light">APPOINTMENT DETAILS</span>
                  </p>
                  <?php
                    if($_SERVER['REQUEST_METHOD']=='POST')  { 
                    $doctor = $_POST["doctor"];
                    $date = $_POST["date"];
                    $time = $_POST["time"];
                    $description = $_POST["description"];

                    $sql4 = "INSERT INTO appointment (PATIENT_ID,DESCRIPTION,DATE,TIME,DOCTOR_ID,STATUS)
                  SELECT u.PATIENT_ID,'$description','$date','$time',d.DOCTOR_ID,'2' FROM users u,
                  doctor d WHERE u.USER_ID = '$user_check' AND d.DOCTOR_NAME = '$doctor' ";
                  
                  if(mysqli_query($conn,$sql4)){
                        echo "<div class='alert alert-info'>Appointment Request sent! </div>";
                      }else{
                      echo "<div class='alert alert-info'>Appointment Request Failed! Please Try Again! </div>";
                    }
                    }

                  ?>
                  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="form-group">
                      <label for="specialization">Specialization</label>
                      <select class="form-control" id="specialization" name="specialization"onChange="showDoctor(this.value)">
                        <option>Select Specialization</option>
                        <?php
                        if(mysqli_num_rows($result)>0){
  
                        while($row = mysqli_fetch_assoc($result)){
                          echo '<option>'.$row['SPECIALIZATION'].'</option>';
                        }
                      }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="doctor">Doctor</label>
                      <select class="form-control" id="doctor" name="doctor" onchange="showDate(this.value)">
                        <option>Select Doctor</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="date">Date</label>
                      <select class="form-control" id="date" name="date" onchange="showTime(this.value)">
                        <option>Select Date</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="Time">Time</label>
                      <select class="form-control" id="time" name="time">
                        <option>Select Time</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="Description">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block"> Send request</button>
                    </div>

                  </form>
                </article>
              </div> <!-- card.// -->

            </div>
            <!--container end.//-->
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- right section ends -->


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
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>
  
</body>

</html>

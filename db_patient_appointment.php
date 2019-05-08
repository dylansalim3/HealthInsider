<?php
session_start();  
$_SESSION['page'] = "appointment";
require("db_patient_header.php");


?>
<script type="text/javascript">
    function displayUpcomingAppointment(index) {
    if (index == "") {
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
</script>
 <!-- right section -->
 <section>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
        <div class="row pt-md-5 mt-md-3 mb-5">
          <div class="col" style="overflow-x:auto;">
            <div class=" align-items-center ml-2 mr-2 mt-2">
              <h3 class="text-muted text-center mb-3">Upcoming appointments</h3>
            </div>
            <?php

 if (isset($_GET['upcomingPageNo'])) {
            $upcomingPageNo = $_GET['upcomingPageNo'];
        } else {
            $upcomingPageNo = 1;
        }
$no_of_records_per_page = 3;
$offset = ($upcomingPageNo-1) * $no_of_records_per_page;
$countSQL = "SELECT count(*) FROM appointment WHERE PATIENT_ID = ANY(SELECT PATIENT_ID FROM users WHERE USER_ID = '$user_check') AND DATE>CURDATE()";
$countResult = mysqli_query($conn,$countSQL);
$total_rows = mysqli_fetch_array($countResult)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

$sql = "SELECT DESCRIPTION, DATE, TIME, STATUS FROM appointment WHERE PATIENT_ID = ANY(SELECT PATIENT_ID FROM users WHERE USER_ID = '$user_check') AND DATE>CURDATE() AND STATUS IN(1,2) ORDER BY STATUS LIMIT $offset,$no_of_records_per_page ";
$result = mysqli_query($conn,$sql);
  
  echo "<table class='table table-striped bg-light text-center align-items-center mt-2'>
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
                  <td>".$row['TIME']."</td>
                  <td><h6><span class='badge ";
                  if ($row1['STATUS']==1) {
                    echo "badge-success'>Successful</span></h6></td></tr>";
                  }else{
                    echo "badge-info'>Pending</span></h6></td></tr>";
                  }
                $i++;
            }
                 

                
                echo "
              </tbody>
            </table>";
              
             ?>

            <nav>
             <ul class='pagination justify-content-center'>
              <li class='page-item page-link py-2 px-3'>
                <a href="?upcomingPageNo=1">First</a></li>
              <li class="page-item page-link py-2 px-3 <?php if($upcomingPageNo <= 1){ echo 'disabled'; } ?>">
                <a href="<?php if($upcomingPageNo <= 1){ echo '#'; } else { echo "?upcomingPageNo=".($upcomingPageNo - 1); } ?>">Prev</a></li>
               <li class="page-item page-link py-2 px-3 <?php if($upcomingPageNo >= $total_pages){ echo 'disabled'; } ?>">
                <a href="<?php if($upcomingPageNo >= $total_pages){ echo '#'; } else { echo "?upcomingPageNo=".($upcomingPageNo + 1); } ?>">Next</a></li>
                <li class="page-item page-link py-2 px-3"><a href="?upcomingPageNo=<?php echo $total_pages; ?>">Last</a></li>
              </ul>
            </nav>
            
            

            

          </div>
        </div>


        <!-- table 2 starts -->
        <div class="row pt-md-5 mt-md-3 mb-5">
          <div class="col" style="overflow-x:auto;">
            <div class=" align-items-center ml-2 mr-2 mt-2">
              <h3 class="text-muted text-center mb-3">Appointment history</h3>
            </div>

            <?php

 if (isset($_GET['HistoryPageNo'])) {
            $HistoryPageNo = $_GET['HistoryPageNo'];
        } else {
            $HistoryPageNo = 1;
        }
$no_of_records_per_page = 3;
$offset = ($HistoryPageNo-1) * $no_of_records_per_page;
$countSQL = "SELECT count(*) FROM appointment WHERE PATIENT_ID = ANY(SELECT PATIENT_ID FROM users WHERE USER_ID = '$user_check') AND (DATE<CURDATE() OR STATUS = 0)";
$countResult = mysqli_query($conn,$countSQL);
$total_rows = mysqli_fetch_array($countResult)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

$sql1 = "SELECT DESCRIPTION, DATE, TIME,STATUS,REJECT_REASON FROM appointment WHERE PATIENT_ID = ANY(SELECT PATIENT_ID FROM users WHERE USER_ID = '$user_check') AND (DATE<CURDATE() OR STATUS = 0) ORDER BY DATE DESC LIMIT $offset,$no_of_records_per_page";
$result1 = mysqli_query($conn,$sql1);
  
  echo "<table class='table table-striped bg-light text-center align-items-center mt-2'>
              <thead>
                <tr class='text-muted'>
                  <th>#</th>
                  <th>Description</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Status</th>
                  <th>Reject Reason</th>
                </tr>
              </thead>
              <tbody>
              ";
              $i=1;
            while($row1 = mysqli_fetch_assoc($result1)){
              echo "<tr>
                  <th scope='row'>".$i."</th>
                  <td>".$row1['DESCRIPTION']."</td>
                  <td>".$row1['DATE']."</td>
                  <td>".$row1['TIME']."</td>
                  <td><h6><span class='badge ";
                  if($row1['STATUS']==0){
                    echo "badge-danger'>Rejected</span></h6></td>";
                    echo "<td>".$row1['REJECT_REASON']."</td></tr>";
                  }elseif ($row1['STATUS']==1) {
                    echo "badge-success'>Successful</span></h6></td>";
                    echo "<td>-</td></tr>";
                  }else{
                    echo "badge-info'>Pending</span></h6></td>";
                    echo "<td>-</td></tr>";
                  }
                 
                $i++;
            }
                 

                
                echo "
              </tbody>
            </table>";
              
             ?>

            <nav>
             <ul class='pagination justify-content-center'>
              <li class='page-item page-link py-2 px-3'>
                <a href="?HistoryPageNo=1">First</a></li>
              <li class="page-item page-link py-2 px-3 <?php if($HistoryPageNo <= 1){ echo 'disabled'; } ?>">
                <a href="<?php if($HistoryPageNo <= 1){ echo '#'; } else { echo "?HistoryPageNo=".($HistoryPageNo - 1); } ?>">Prev</a></li>
               <li class="page-item page-link py-2 px-3 <?php if($HistoryPageNo >= $total_pages){ echo 'disabled'; } ?>">
                <a href="<?php if($HistoryPageNo >= $total_pages){ echo '#'; } else { echo "?HistoryPageNo=".($HistoryPageNo + 1); } ?>">Next</a></li>
                <li class="page-item page-link py-2 px-3"><a href="?HistoryPageNo=<?php echo $total_pages; ?>">Last</a></li>
              </ul>
            </nav>

          

          </div>
        </div> <!-- ends table 2 -->
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

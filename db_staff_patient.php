<?php
session_start();
$page = 'manage';
require('check-session.php');
require('db_staff_header.php');
require_once "php/staff_patient.php";
?>

<?php foreach ($records as $record): ?>
    <!-- start of delete modal-->
    <div class="modal fade" id="delete<?php echo $record['PATIENT_HISTORY_ID'] ?>">
        <div class="modal-dialog " id="small-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete patient record?</h4>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete?</p>
                </div>
                <div class="modal-footer">
                    <form action="db_staff_patient.php" method="post">
                        <button class="btn btn-secondary" type="submit"
                                name="delete" value="<?php echo $record['PATIENT_HISTORY_ID'] ?>">
                            Yes
                        </button>
                        <button class="btn btn-primary active-2" data-dismiss="modal" type="button">
                            <a class="text-white" style="text-decoration:none;">No</a>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end of delete modal -->
<?php endforeach; ?>

    <!-- start of ward modal-->
    <div class="modal fade" id="wardModal1">
        <div class="modal-dialog " id="small-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Manage Ward</h4>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="db_staff_patient.php" method="post" id="wardForm">
                        <label for="wardNo">Ward No</label>
                        <select class="form-control" id="wardNo" name="wardId">
                            <?php for($i = 1; $i<=10; $i++) : ?>
                                <option value=<?php echo $i ?>>
                                    <?php echo $i ?>
                                </option>
                            <?php endfor; ?>
                        </select>

                        <div class="form-group">
                            <label for="ward-patient-id">Patient ID</label>
                            <select class="form-control" id="ward-patient-dropdown" name="patientId">
<!--                                js insert-->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ward-patient-name">Patient Name</label>
                            <input type="text" class="form-control" id="ward-patient-name" name="patientName" disabled>
                            <input type="text" class="form-control" id="ward-patient-hidden-id" name="patientId" style="display: none">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                        <button class="btn btn-primary active-2" data-dismiss="modal" type="button">
                            <a class="text-white" style="text-decoration:none;">Cancel</a>
                        </button>
                        <button class="btn btn-secondary" id="wardCheckoutBtn" type="submit" name="ward" value=1 form="wardForm">
                            Checkout
                        </button>
                        <button class="btn btn-secondary" id="wardConfirmBtn" type="submit" name="ward" value=2 form="wardForm">
                            Confirm
                        </button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of ward modal -->


<!-- start of add record modal -->
<div aria-hidden="true" aria-labelledby="tablesetting" class="modal fade" id="managerecords" role="dialog"
     tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add patient records</h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addRecord" action="db_staff_patient.php" method="post">
                    <div class="form-group">
                        <label class="col-form-label" for="patient-id">Patient ID:</label>
                        <input class="form-control" id="patient-id" name="PATIENT_ID" type="text" required >
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="patient-id">Patient Name:</label>
                        <input class="form-control" id="patient-name" type="text" disabled>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="date">Date:</label>
                        <input class="form-control" id="date" name="DATE" type="date" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="time">Time:</label>
                        <input class="form-control" id="time" name="TIME" type="time" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="height">Height:</label>
                        <input class="form-control" id="height" name="HEIGHT" type="number" step="0.1" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="weight">Weight:</label>
                        <input class="form-control" id="weight" name="WEIGHT" type="number" step="0.1" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="systolic">Systolic:</label>
                        <input class="form-control" id="systolic" name="SYSTOLIC" type="number" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="diastolic">Diastolic:</label>
                        <input class="form-control" id="diastolic" name="DIASTOLIC" type="number" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="heartRate">Heart Rate:</label>
                        <input class="form-control" id="heartRate" name="HEART_RATE" type="number" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="heartRate">LDL Cholesterol Level:</label>
                        <input class="form-control" id="heartRate" name="LDL" type="number" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="detail">Details:</label>
                        <textarea class="form-control" id="detail" name="PATIENT_HISTORY" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" form="addRecord" type="submit" name="add">Add</button>
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- end of add record modal -->


<!-- start of view modal -->
<?php foreach ($records as $record) : ?>
    <div class="modal fade p-3" id="view<?php echo $record['PATIENT_HISTORY_ID']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Patient detail</h4>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">

                            <p class="text-center">Below are the detailed information of patient</p>
                            <p class="divider-text">
                                <span class="bg-light">Patient Info</span></p>

                            <form>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Patient's Name</label>
                                    <input class="form-control" id="formGroupExampleInput" type="text" value="<?php
                                    echo $record['PATIENT_NAME'];
                                    ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Date</label>
                                    <input class="form-control" id="formGroupExampleInput2" type="date" value="<?php
                                    echo $record['DATE'];
                                    ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput3">Time</label>
                                    <input class="form-control" id="formGroupExampleInput3" type="text" value="<?php
                                    echo $record['TIME']
                                    ?>" disabled>
                                </div>
                                <div class=" form-group">
                                    <label for="exampleTextarea">Height</label>
                                    <input class="form-control" id="exampleTextarea" rows="4" value="<?php
                                    echo $record['HEIGHT'];
                                    ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput4">Weight</label>
                                    <input class="form-control" id="formGroupExampleInput4" type="email" value="<?php
                                    echo $record['WEIGHT'];
                                    ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput5">BMI</label>
                                    <input class="form-control" id="formGroupExampleInput5" type="text" value="<?php
                                    echo $record['BMI'];
                                    ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput6">Systolic</label>
                                    <input class="form-control" id="formGroupExampleInput6" type="text" value="<?php
                                    echo $record['SYSTOLIC'];
                                    ?>" disabled>
                                </div>

                                <span class="bg-light"></span>
                                <div class="form-group">
                                    <label for="formGroupExampleInput7">Diastolic</label>
                                    <input class="form-control" id="formGroupExampleInput7" type="text" value="<?php
                                    echo $record['DIASTOLIC'];
                                    ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput8">Heart Rate</label>
                                    <input class="form-control" id="formGroupExampleInput8" type="text" value="<?php
                                    echo $record['HEART_RATE'];
                                    ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput9">LDL Cholesterol Level</label>
                                    <input class="form-control" id="formGroupExampleInput9" type="text" value="<?php
                                    echo $record['LDL'];
                                    ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextarea2">Details</label>
                                    <textarea class="form-control" id="exampleTextarea2" rows="4" disabled><?php
                                        echo $record['PATIENT_HISTORY']; ?>
                                    </textarea>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
<!--                    <button class="btn btn-primary" data-dismiss="modal" type="button">Update</button>-->
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- end of view modal-->

<!-- tables -->
<section>
    <div class="container-fluid">
        <div class="row mt-md-5 mb-5">
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                <div class="row align-items-center">
                    <div class="col" style="overflow-x:auto;">
                        <div class="d-flex justify-content-between align-items-center ml-2 mr-2 mt-2">
                            <h3 class="text-muted text-center mb-3">Patient records</h3>
                            <div>
                                <button class="btn btn-primary" data-target="#managerecords" data-toggle="modal"
                                        title="Setting" type="button">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button class="btn btn-dark" data-target="#wardModal1" data-toggle="modal"
                                        title="ward" type="button">
                                    Ward
                                </button>
                            </div>

                        </div>
                        <table class="table table-striped bg-light text-center align-items-center mt-2">
                            <thead>
                            <tr class="text-muted">
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>BMI</th>
                                <th>Systolic</th>
                                <th>Diastolic</th>
                                <th>Heart Rate</th>
                                <th>LDL</th>
                                <th>Details</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $listnum=0; ?>
                            <?php foreach ($records as $record) : ?>
                                <?php $listnum++;$pagenum=($page-1)*7 ?>
                                <tr>
                                    <th><?php
                                        echo $listnum+$pagenum;
                                        ?></th>
                                    <th><?php
                                        echo $record['PATIENT_HISTORY_ID']
                                        ?></th>
                                    <td><?php
                                        echo $record['PATIENT_NAME']
                                        ?></td>
                                    <td><?php
                                        echo $record['DATE']
                                        ?></td>
                                    <td><?php
                                        echo $record['TIME']
                                        ?></td>
                                    <td><?php
                                        echo $record['BMI']
                                        ?></td>
                                    <td><?php
                                        echo $record['SYSTOLIC']
                                        ?></td>
                                    <td><?php
                                        echo $record['DIASTOLIC']
                                        ?></td>
                                    <td><?php
                                        echo $record['HEART_RATE']
                                        ?>
                                    </td>
                                    <td><?php
                                        echo $record['LDL']
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary" data-toggle="modal"
                                                data-target="#view<?php echo $record['PATIENT_HISTORY_ID'] ?>">
                                            View
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary" data-toggle="modal"
                                                data-target="#delete<?php echo $record['PATIENT_HISTORY_ID'] ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                        <!-- pagination -->
                        <nav>
                            <ul class="pagination justify-content-center">
<!--                                <li class="page-item">-->
<!--                                    <a class="page-link py-2 px-3" href="db_staff_patient.php?page=--><?php
//                                    if ($page == 1) {
//                                        echo 1;
//                                    } else {
//                                        echo $page - 1;
//                                    }
//                                    ?><!--">-->
<!--                                        <span>Previous</span>-->
<!--                                    </a>-->
<!--                                </li>-->

                                <?php for ($x = 1; $x <= $totalPage; $x++) : ?>
                                    <li class="page-item <?php
                                    if ($page == $x) {
                                        echo 'active';
                                    }
                                    ?>">
                                        <a class="page-link py-2 px-3" href="db_staff_patient.php?page=<?php
                                        echo $x;
                                        ?>">
                                            <?php echo $x; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

<!--                                <li class="page-item">-->
<!--                                    <a class="page-link py-2 px-3" href="db_staff_patient.php?page=--><?php
//                                    if ($page == $totalPage) {
//                                        echo $totalPage;
//                                    } else {
//                                        echo $page + 1;
//                                    }
//                                    ?><!--">-->
<!--                                        <span>Next</span>-->
<!--                                    </a>-->
<!--                                </li>-->
                            </ul>
                        </nav>
                        <!-- end of pagination -->

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of tables -->

<div class="container-fluid" style="height: 75vh">
    <div class="row mt-md-5 mb-5">
        <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
            <div class="row align-items-center">
                <div class="col" style="overflow-x:auto;">
                    <div class="d-flex justify-content-between align-items-center ml-2 mr-2 mt-2">
                        <h3 class="text-muted text-center mb-3 d-flex">Overall Patient records</h3>
                        <select class="form-control" id="chartType" style="width: 20%">
                            <option value="day">Appointment Day</option>
                            <option value="gender">Gender</option>
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
<script crossorigin="anonymous" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        src="https://code.jquery.com/jquery-3.3.1.slim.min.js">
</script>
<script crossorigin="anonymous" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
</script>
<script crossorigin="anonymous" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
</script>
<script src="js/staffPatient.js"></script>
</body>

</html>

<?php
session_start();
$page = 'appointment';
require('check-session.php');
require('db_staff_header.php');
require_once "php/staff_appointment.php";
?>

<!-- modal to add doctor availability-->
<div class="modal fade" id="addDoctor">
    <div class="modal-dialog " id="small-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add a doctor availability?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="doctorForm" action="db_staff_appointment.php" method="post">
                    <!-- input id-->
                    <div class="form-group">
                        <label for="doctorOptions">Doctor</label>
                        <select class="form-control" id="doctorOptions" name="id">
                            <?php foreach ($doctorArray as $doctor) : ?>
                                <option value="<?php echo $doctor['DOCTOR_ID'] ?>">
                                    <?php echo $doctor['DOCTOR_NAME'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- input date-->
                    <div class="form-group">
                        <label for="Date">Date</label>
                        <input type="date" class="form-control" id="Date" name="date"
                               value="<?php echo date('Y-m-d') ?>" min="<?php echo date('Y-m-d') ?>">
                    </div>
                    <!-- input time-->
                    <div class="form-group">
                        <label for="Time">Time</label>
                        <select class="form-control" id="Time" name="time">
                            <?php for ($x = 9; $x <= 21; $x++) : ?>
                                <option value="<?php echo "{$x}:00:00" ?>">
                                    <?php echo "{$x}:00" ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" id="promptBut" class="btn btn-primary active-2 promptBut" form="doctorForm"
                        name="slot">Add Availability
                </button>
            </div>
        </div>
    </div>
</div>
<!-- end of modal to add doctor availability -->

<!-- modal to set reject reason-->
<div class="modal fade" id="rejectModal">
    <div class="modal-dialog " id="small-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reject Reason</h4>
            </div>
            <div class="modal-body">
                <form id="rejectReason" action="db_staff_appointment.php" method="post">
                    <!-- input reason and hidden id-->
                    <div class="form-group">
                        <label for="reason"></label>
                        <input type="text" name="appointmentId" id="rejectId" style="display: none;">
                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Describe your reason here">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" id="rejectButton" class="btn btn-primary active-2 promptBut" form="rejectReason"
                        name="process" value="reject">Confirm
                </button>
            </div>
        </div>
    </div>
</div>
<!-- end of modal to set reject reason -->

<!-- start of process pending modal -->
<div class="modal fade p-3" id="process">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add appointment request</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">

                        <p class="text-center">Below are the detailed information of appointment</p>
                        <p class="divider-text">
                            <span class="bg-light">Appointment Info</span></p>

                        <form method="post" action="db_staff_appointment.php" id="process_form">
                            <!--id hidden-->
                            <input type="number" style="display: none" name="appointmentId" value="1" id="process_id">
                            <!-- name-->
                            <div class="form-group">
                                <label for="process_name">Patient's Name</label>
                                <input type="text" class="form-control" id="process_name" value="James" name="name"
                                       disabled>
                            </div>
                            <!-- date-->
                            <div class="form-group">
                                <label for="process_date">Appointment Date</label>
                                <input type="date" class="form-control" id="process_date" value="2019-08-03"
                                       name="date" disabled>
                            </div>
                            <!-- time-->
                            <div class="form-group">
                                <label for="process_time">Appointment Time</label>
                                <input type="time" class="form-control" id="process_time" value="08:00" name="time"
                                       disabled>
                            </div>
                            <!-- special-->
                            <div class="form-group">
                                <label for="process_time">Specialization</label>
                                <input type="text" class="form-control" id="process_special" value="08:00" name="time"
                                       disabled>
                            </div>
                            <!-- doctor-->
                            <div class="form-group">
                                <label for="process_time">Doctor In Charge</label>
                                <input type="text" class="form-control" id="process_doctor" value="08:00" name="time"
                                       disabled>
                                <input type="text" style="display: none;" name="slotId" id="process_slot" >
                            </div>
                            <!-- reason-->
                            <div class="form-group">
                                <label for="process_reason">Reason for visit</label>
                                <textarea class="form-control" id="process_reason" rows="4" name="reason" disabled
                                          disabled>
                                <!-- js insert reason  j-->
                                </textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <p class="text-muted text-center mb-3">Succesful appointment making will delete this pending
                record from
                table</p>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <!-- process-->
                <button type="submit" class="btn btn-info " form="process_form" name="process" value="accept">
                    Make An Appointment
                </button>
                <!-- process -->
                <button type="button" class="btn btn-primary active-2" data-dismiss="modal" data-toggle="modal" data-target="#rejectModal">Reject Appointment</button>
            </div>
        </div>
    </div>
</div>
<!-- end of process pending modal-->

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">


                <!-- start of doctor availability table-->
                <div class="row align-items-center pt-md-5 mt-md-3 mb-3 px-4">
                    <div class="col" style="overflow-x:auto;">
                        <div class=" align-items-center ml-2 mr-2 mt-2">
                            <h3 class="text-muted text-center mb-3">Doctor Availability</h3>
                            <p class="text-muted text-center mb-3">Following table shows the availability of the
                                doctors</p>
                        </div>
                        <div style="display: flex;">
                            <button type="button" class="btn btn-secondary ml-auto" title="Add" data-toggle="modal"
                                    data-target="#addDoctor" style="justify-self: end;">
                                Add
                            </button>
                        </div>
                        <table class="table table-striped bg-light text-center align-items-center mt-2">
                            <thead>
                            <tr class="text-muted">
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Specialization</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                            </thead>
                            <tbody id="availability">
                            <!-- js insert table row-->
                            </tbody>
                        </table>
                        <!-- pagination start-->
                        <nav>
                            <ul class="pagination justify-content-center" id="availabilityPage">
                                <!--js insert page link-->
                            </ul>
                        </nav>
                        <!-- end of pagination -->
                    </div>
                </div>
                <!-- end of doctor availabilty table-->

                <!-- start of pending table-->
                <div class="row align-items-center pt-md-5 mt-md-3 mb-3 px-4">
                    <div class="col" style="overflow-x:auto;">
                        <div class=" align-items-center ml-2 mr-2 mt-2">
                            <h3 class="text-muted text-center mb-3">Pending Appointments</h3>
                            <p class="text-muted text-center mb-3">Following table presents pending (unprocessed)
                                appointments,press 'Process' button to process appointments</p>
                        </div>
                        <table class="table table-striped bg-light text-center align-items-center mt-2">
                            <thead>
                            <tr class="text-muted">
                                <th>#</th>
                                <th>Name</th>
                                <th>Reason for visit</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody id="pending">
                            <!-- js insert table row-->
                            </tbody>
                        </table>
                        <!-- pagination start-->
                        <nav>
                            <ul class="pagination justify-content-center" id="pendingPage">
                                <!--js insert page link-->
                            </ul>
                        </nav>
                        <!-- end of pagination -->
                    </div>
                </div>
                <!-- end of pending table-->

                <!--start of upcoming table-->
                <div class="row align-items-center pt-md-5 mt-md-3 mb-3 px-4">
                    <div class="col" style="overflow-x:auto;">
                        <div class=" align-items-center ml-2 mr-2 mt-2">
                            <h3 class="text-muted text-center mb-3">Upcoming Appointments</h3>
                            <p class="text-muted text-center mb-3">Following table records show upcoming
                                appointments.Records will be deleted 3 days after appointment date.</p>
                        </div>
                        <table class="table table-striped bg-light text-center align-items-center mt-2">
                            <thead>
                            <tr class="text-muted">
                                <th>#</th>
                                <th>Name</th>
                                <th>Reason for visit</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Doctor In Charge</th>
                            </tr>
                            </thead>
                            <tbody id="upcoming">
                            <!-- js insert table row-->
                            </tbody>
                        </table>
                        <!-- pagination start-->
                        <nav>
                            <ul class="pagination justify-content-center" id="upcomingPage">
                                <!--js insert page link-->
                            </ul>
                        </nav>
                        <!-- end of pagination -->
                    </div>
                </div>
                <!-- end of upcoming table-->

                <!-- start of history table -->
                <div class="row align-items-center pt-md-5 mt-md-3 mb-3 px-4">
                    <div class="col" style="overflow-x:auto;">
                        <div class=" align-items-center ml-2 mr-2 mt-2">
                            <h3 class="text-muted text-center mb-3">Appointment History</h3>
                        </div>
                        <table class="table table-striped bg-light text-center align-items-center mt-2">
                            <thead>
                            <tr class="text-muted">
                                <th>#</th>
                                <th>Name</th>
                                <th>Reason for visit</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Doctor In Charge</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody id="history">
                            <!--                            <tr>-->
                            <!--                                <th>1</th>-->
                            <!--                                <td>James</td>-->
                            <!--                                <td>Follow up with sore throat</td>-->
                            <!--                                <td>19 March 2019</td>-->
                            <!--                                <td>8 - 9 am</td>-->
                            <!--                                <td>Dr Ali</td>-->
                            <!--                                <td>-->
                            <!--                                    <h6><span class="badge badge-info">Pending</span></h6>-->
                            <!--                                </td>-->
                            <!--                            </tr>-->

                            </tbody>
                        </table>
                        <!-- pagination start-->
                        <nav>
                            <ul class="pagination justify-content-center" id="historyPage">
                                <!--js insert page link-->
                            </ul>
                        </nav>
                        <!-- end of pagination -->
                    </div>
                </div>
                <!-- end of history table -->

                <!-- calendar starts -->
                <div class="row align-items-center pt-md-5 mt-md-3 mb-3 ">
                    <div class="col" style="overflow-x:auto;">
                        <div id='calendar' ></div>
                    </div>
                </div>
                <!-- calendar ends -->

            </div>
        </div>
    </div>
</section>

<!-- footer starts-->
<footer>
    <div class="container-fluid  mt-5">
        <div class="row">
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                <div class="row border-top pt-3">
                    <div class="col-lg-6 ">
                    </div>
                    <div class="col-lg-6 text-center">
                        <p>&copy; 2019 Copyright. By HealthInsider</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end of footer -->


<script src="js/staffAppointment.js"></script>
<!--<script src="js\db_appointment.js"></script>-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>

<script src='fullcalendar/core/main.js'></script>
<script src='fullcalendar/daygrid/main.js'></script>
<script src='fullcalendar/timegrid/main.js'></script>
<script src='fullcalendar/interaction/main.js'></script>

<script src="js/myCalendar.js"></script>
</body>

</html>

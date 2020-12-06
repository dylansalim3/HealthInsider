<?php
session_start();
$page = 'dashboard';
require('check-session.php');
require('db_staff_header.php');
?>


<!-- cards -->
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                <div class="row pt-md-5 mt-md-3 mb-5">
                    <div class="col-xl-3 col-sm-6 p-2">
                        <div class="card card-common">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <i class="fas fa-user-injured fa-3x text-warning"></i>
                                    <div class="text-right text-secondary">
                                        <h5>Patients</h5>
                                        <h3 id="patients">500</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-secondary">
                                <i class="fas fa-sync mr-3"></i>
                                <span class="updateBtn">Updated Now</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 p-2">
                        <div class="card card-common">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <i class="fas fa-user-tie fa-3x text-success"></i>
                                    <div class="text-right text-secondary">
                                        <h5>Staffs</h5>
                                        <h3 id="staffs">100</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-secondary">
                                <i class="fas fa-sync mr-3"></i>
                                <span class="updateBtn">Updated Now</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 p-2">
                        <div class="card card-common">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <i class="fas fa-users fa-3x text-info"></i>
                                    <div class="text-right text-secondary">
                                        <h5>Users</h5>
                                        <h3 id="users">15,000</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-secondary">
                                <i class="fas fa-sync mr-3"></i>
                                <span class="updateBtn">Updated Now</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 p-2">
                        <div class="card card-common">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <i class="fas fa-chart-line fa-3x text-danger"></i>
                                    <div class="text-right text-secondary">
                                        <h5>Visitors</h5>
                                        <h3 id="visitors">45,000</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-secondary">
                                <i class="fas fa-sync mr-3"></i>
                                <span class="updateBtn">Updated Now</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 p-2">
                        <div class="card card-common">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <i class="fas fa-bed fa-3x text-primary"></i>
                                    <div class="text-right text-secondary">
                                        <h5>Ward available</h5>
                                        <h3><span id="wardEmpty"></span> empty</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-secondary">
                                <i class="fas fa-sync mr-3"></i>
                                <span class="updateBtn">Updated Now</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 p-2">
                        <div class="card card-common">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <i class="fas fa-procedures fa-3x text-danger"></i>
                                    <div class="text-right text-secondary">
                                        <h5>Patients in ward</h5>
                                        <h3 id="wardPatient">20</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-secondary">
                                <i class="fas fa-sync mr-3"></i>
                                <span class="updateBtn">Updated Now</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 p-2">
                        <div class="card card-common">
                            <div class="card-body">
                                <div class="d-flex ">
                                    <i class="fas fa-calendar-check fa-3x text-danger"></i>
                                    <div class="text-center text-secondary mx-auto">
                                        <h5>Today's appointment</h5>
                                        <table class="table table-danger table-striped  text-center mt-2">
                                            <thead>
                                            <tr class="text-muted">
                                                <th>#</th>
                                                <th>Patient</th>
                                                <th>Doctor</th>
                                                <th>Time</th>
                                            </tr>
                                            </thead>
                                            <tbody id="appointment">
                                            <!--table tow goes here-->
                                            </tbody>
                                        </table>
                                        <div id="none" style="display: none">no appointment today</div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-secondary">
                                <i class="fas fa-sync mr-3"></i>
                                <span class="updateBtn">Updated Now</span>
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


<script crossorigin="anonymous" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="js/staffDashboard.js"></script>
</body>

</html>

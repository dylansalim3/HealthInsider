<?php

session_start();
$page = 'profile';
require('check-session.php');
require('db_staff_header.php');
require('php/staff_profile.php');

?>

<!-- right section -->
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                <div class="pt-md-5 mt-md-3 mb-5">
                    <form id="form">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input class="form-control form-control-plaintext" id="role" readonly type="text"
                                   value="Staff" required>
                            <?php
                            echo "<div style='display: none' id='oldName'>{$login_session}</div>"
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input class="form-control" id="name" type="text" name="name" value="<?php
                            echo $staffArray['NAME'];
                            ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date of birth</label>
                            <input class="form-control" id="dob" type="date" name="dob" value="<?php
                            echo $staffArray['DOB'];
                            ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nric">NRIC</label>
                            <input class="form-control" id="nric" type="text" name="nric" value="<?php
                            echo $staffArray['NRIC'];
                            ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="address">Home address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"><?php
                                echo $staffArray['ADDRESS'];
                                ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input class="form-control" id="email" type="email" name="email" value="<?php
                            echo $userArray['EMAIL'];
                            ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone number</label>
                            <input class="form-control" id="contact" type="text" name="contact" value="<?php
                            echo $staffArray['CONTACT'];
                            ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" name="gender" id="gender">
                                <option <?php
                                if ($staffArray['GENDER'] == 'Male') {
                                    echo 'selected';
                                }
                                ?>>Male
                                </option>
                                <option <?php
                                if ($staffArray['GENDER'] == 'Female') {
                                    echo 'selected';
                                }
                                ?>>Female
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="phone">Enter Password</label>
                            <input class="form-control" id="oldPassword" placeholder="Please enter your current password" type="password"
                                   name="oldPassword" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Change password</label>
                            <input class="form-control mt-2" id="newPassword" placeholder="New password" type="password"
                                   name="password">
                            <input class="form-control mt-2" id="newPassword2" placeholder="Retype new password"
                                   type="password" name="password2">
                        </div>

                        <div class="form-group">
                            <label for="picture">Change profile picture</label>
                            <input class="form-control-file" name="picture" id="picture" type="file">
                        </div>

                        <button class="btn btn-dark mt-3" id="submit">Update</button>

                        <?php if (isset($_GET['success'])) : ?>
                            <div class="alert alert-success" id="alert" style=" margin-top: 1.5rem;">
                                Your profile is successfully updated
                            </div>
                        <?php else : ?>
                            <div class="alert" id="alert" style="display: none; margin-top: 1.5rem;">
                            </div>
                        <?php endif; ?>

                    </form>
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


<script crossorigin="anonymous" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="js/staffProfile.js"></script>
</body>

</html>

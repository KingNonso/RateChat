<?php
    include(View::NavBar());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                View Details of Applicant
                <small>Here are details for your perusal</small>
            </h1>
            <ol class="breadcrumb">
                <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>
            </ol>
        </section>

        <?php
            $date = new DateTime('now');
            $today = $date->format('d F, Y');
        ?>

        <!-- Main content -->
        <section class="content">

            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <!-- The time line -->
                    <ul class="timeline">
                        <!-- timeline time label -->
                        <li class="time-label">
                  <span class="bg-red">
                    <?php echo $today; ?>

                  </span>
                        </li>
                        <?php
                            if(isset($this->admissions)){
                                $mod = $this->admissions;
                                ?>
                                    <li>
                                        <i class="fa fa-user bg-aqua"></i>

                                        <div class="timeline-item">
                                            <span class="time"> Made Application on  <i class="fa fa-clock-o"></i>
                                                <?php
                                                    echo $mod['date'];
                                                ?> </span>

                                            <h3 class="timeline-header no-border"><a href="#"> <?php echo($mod['name']); ?> </a>
                                            </h3>
                                            <div class="timeline-body">
                                                <p><b>Sex: </b><?php echo $mod['sex'];  ?></p>
                                                <p><b>Date of Birth: </b><?php echo $mod['dob'];  ?></p>
                                                <p><b>Marital Status: </b><?php echo $mod['marital_status'];  ?></p>
                                                <p><b>Place of Birth: </b><?php echo $mod['place_of_birth'];  ?></p>

                                            <p><b>State of Origin: </b><?php echo $mod['state_of_origin'];  ?></p>
                                            <p><b>LGA: </b><?php echo $mod['lga'];  ?></p>
                                            <p><b>Nationality: </b><?php echo $mod['nationality'];  ?></p>
                                            <p><b>Phone Number: </b><?php echo $mod['phone_no'];  ?></p>
                                            <p><b>Postal address: </b><?php echo $mod['postal_address'];  ?></p>
                                            <p><b>Postal state: </b><?php echo $mod['postal_state'];  ?></p>
                                            <p><b>Email: </b><?php echo $mod['email'];  ?></p>
                                            <p><b>Residential address: </b><?php echo $mod['residential_address'];  ?></p>
                                            <p><b>State of Residence: </b><?php echo $mod['state_of_residence'];  ?></p>
                                            <h3>Educational Information</h3>
                                            <p><b>Name of Institution Last Attended: </b><?php echo $mod['institution'];  ?></p>
                                            <p><b>Highest Qualification: </b><?php echo $mod['program'];  ?></p>
                                            <p><b>Examination Taken: </b><?php echo $mod['course'];  ?></p>
                                            <p><b>Examining Board: </b><?php echo $mod['faculty'];  ?></p>
                                            <p><b>Admission/Entry Date: </b><?php echo $mod['admission_date'];  ?></p>
                                            <p><b>Graduation Date: </b><?php echo $mod['graduation_date'];  ?></p>
                                            <p><b>Hostel Address: </b><?php echo $mod['Hostel_address'];  ?></p>
                                            <p><b>Hostel Phone No: </b><?php echo $mod['Hostel_phone'];  ?></p>
                                            <p><b>Sex: </b><?php echo $mod['sex'];  ?></p>
                                            </div>

                                            <div class="timeline-footer">
                                                <a href="<?php echo URL; ?>webmaster/admissions/accept/<?php echo $mod['adm_app_id']; ?>" onclick="return confirm('This cannot be undone. PROCEED?')" class="btn btn-success btn-flat">Accept </a>

                                                <a href="<?php echo URL; ?>webmaster/admissions/decline/<?php echo $mod['adm_app_id']; ?>" onclick="return confirm('This cannot be undone. PROCEED?')" class="btn btn-danger btn-flat">Decline </a>
                                            </div>
                                        </div>
                                    </li>

                                <?php

                            }
                        ?>
                        <?php
                            if(isset($this->teachers)){
                                foreach($this->teachers as $mod){?>
                                    <li>
                                        <i class="fa fa-user bg-aqua"></i>

                                        <div class="timeline-item">
                                            <span class="time"> Made Adviser on  <i class="fa fa-clock-o"></i>
                                                <?php
                                                    echo $mod['date'];
                                                ?> </span>

                                            <h3 class="timeline-header no-border"><a href="#"> <?php echo($mod['name']); ?> </a>
                                            </h3>
                                            <div class="timeline-body">
                                                <p><b>Class: </b><?php echo $mod['subject_for'];  ?></p>
                                                <p><b>Subject: </b><?php echo $mod['subject_name'];  ?></p>
                                                <p><b>Has Lab Session: </b><?php $echo = ($mod['lab_enabled'] == 1)? 'Yes': 'No'; echo $echo;  ?></p>
                                                <p><b>Prerequisite: </b><?php echo $mod['prerequisite'];  ?></p>
                                                <p><b>Description: </b><?php echo $mod['description'];  ?></p>
                                                <p><b>Session: </b><?php echo $mod['session_name'];  ?></p>
                                                <p><b>Term: </b><?php echo $mod['term'];  ?></p>
                                                <p><b>Contact: </b><?php echo $mod['phone_no'];  ?></p>
                                            </div>
                                            <div class="timeline-footer">
                                                <a href="<?php echo URL; ?>admin/teacher/subject/<?php echo $mod['person_id']; ?>" class="btn btn-info btn-flat">Assign Class</a>

                                                <a href="<?php echo URL; ?>admin/teacher/delete/<?php echo $mod['teacher_id']; ?>" class="btn btn-danger btn-flat">Remove</a>
                                            </div>
                                        </div>
                                    </li>

                                <?php
                                }
                            }
                        ?>
                        <li>
                            <i class="fa fa-clock-o bg-gray"></i>
                        </li>
                    </ul>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


        </section>    <!-- /.content -->
    </div>  <!-- /.content-wrapper -->

<?php
    include(View::rightNav());
?>
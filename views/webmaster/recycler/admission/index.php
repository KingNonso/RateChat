<?php
    include(View::webmaster_nav());
    $user = new User();
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Admissions
                <small>Webmaster Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


            </ol>


        </section>

        <!-- Main content -->
        <section class="content">
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Showing all </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Entry Session</th>
                                        <th>Entry Term</th>
                                        <th>Entry Class</th>
                                        <th>Date</th>
                                        <th colspan="3">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach($this->admissions as $mod){
                                            ?>
                                            <tr>
                                                <td><?php
                                                 $record = $user->refToRecord($mod['record_tracker']);
                                                        $name = $record['firstname'].' '.$record['surname'].' '.$record['othername'];
                                                        echo $name;
                                                    ?></td>
                                                <td><?php echo $mod['entry_session'];  ?></td>
                                                <td><?php echo $mod['entry_term'];  ?></td>
                                                <td><?php echo $mod['entry_class'];  ?></td>
                                                <?php
                                                    $date = new DateTime($mod['date_inserted']);
                                                    $dob = $date->format('d M, Y ');//h:i a
                                                ?>
                                                <td><?php echo($dob); ?>
                                                </td>
                                                <td><a href="<?php echo URL; ?>webmaster/admissions/view/<?php echo $mod['adm_app_id']; ?>" class="btn btn-default btn-flat">View</a></td>
                                                <?php
                                                    if($mod['admitted'] == 'yes'){
                                                    $date = new DateTime($mod['date_inserted']);
                                                    $dob = $date->format('d M, Y ');//h:i a
                                                ?>

                                                <td>Admitted</td>
                                                    <?php
                                                }else{?>
                                                        <td><a href="<?php echo URL; ?>webmaster/admissions/accept/<?php echo $mod['adm_app_id']; ?>" onclick="return confirm('This cannot be undone. PROCEED?')" class="btn btn-success btn-flat">Accept </a></td>                                                    <?php   }

                                                ?>
                                                <td><a href="<?php echo URL; ?>webmaster/admissions/decline/<?php echo $mod['adm_app_id']; ?>" onclick="return confirm('This cannot be undone. PROCEED?')" class="btn btn-danger btn-flat">Decline </a></td>

                                            </tr>
                                        <?php }  ?>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Entry Session</th>
                                        <th>Entry Term</th>
                                        <th>Entry Class</th>
                                        <th>Date</th>
                                        <th colspan="3">Actions</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- Your Page Content Here -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>
<?php
    include(View::webmaster_nav());

?>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Users
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
    <div class="col-xs-12">
<?php if(Session::exists('home')){ ?>
    <div class="box box-success">
    <div class="box-header ">
            <h3 class="box-title"><?php echo Session::flash('home');?> </h3>
    </div>
    </div>

<?php } elseif(Session::exists('error')){ ?>
        <div class="box box-danger">
            <div class="box-header ">

            <h3 class="box-title"><?php echo Session::flash('error');?> </h3>
            </div>
        </div>

<?php }else{?>
        <div class="box box-primary">
            <div class="box-header ">

            <h3 class="box-title">Users Profile </h3>
            </div>
        </div>
<?php }?>

    </div>

    <div class="col-md-12">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Full Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th colspan="4">Action</th>
                        </tr>
                        <?php
                            foreach($this->users as $u){
                                ?>
                                <tr>
                                    <td><?php echo($u->id); ?></td>
                                    <td><?php echo($u->surname.' '.$u->firstname.' '.$u->othername); ?></td>
                                    <td><?php echo($u->sex); ?></td>
                                    <td><?php echo($u->phone_no); ?></td>
                                    <td><?php echo($u->email); ?></td>
                                    <td><?php echo($u->state_of_origin); ?></td>




                                    <?php
                                        if($u->user_perms_id > 1){
                                            ?>
                                            <td> <a href="<?php echo(URL.'webmaster/make_admin/unmake/'. $u->id); ?>" class="btn btn-danger btn-sm btn-flat">Remove Role </a> </td>
                                        <?php
                                        } ?>

                                    <td><button type="button" class="btn btn-info btn-sm btn-flat" onclick="populatePackage(<?php echo($u->id); ?>,'<?php echo($u->email); ?>')">Add Administrative Role </button></td>
                                    <td> <a href="<?php echo(URL.'webmaster/enter_account/'. $u->id); ?>" class="btn btn-primary btn-sm btn-flat">Access Account </a> </td>
                                    <?php
                                        if($u->user_status == 1){
                                            ?>
                                            <td> <a href="<?php echo(URL.'webmaster/block_user/block/'. $u->id); ?>" class="btn btn-warning btn-sm btn-flat">Block User</a> </td>

                                        <?php
                                        }else{
                                            ?>

                                            <td> <a href="<?php echo(URL.'webmaster/block_user/undo/'. $u->id); ?>" class="btn btn-warning btn-sm btn-flat">Unblock User </a> </td>
                                        <?php
                                        }
                                    ?>

                                </tr>
                            <?php
                            }
                        ?>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th colspan="4">Action</th>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>

        <!-- Profile Image -->
        <!-- /.box -->

        <!-- About Me Box -->
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <!-- /.col -->
    </div>
    <!-- /.row -->

    </section>
    <!-- /.content -->
    </div>  <!-- /.content-wrapper -->

  <!-- put in a package modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Administrative Role</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" role="form" action="<?php echo(URL.'webmaster/make_admin/make'); ?>" method="post">

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="username">Email:</label>
                            <div class="col-sm-10">
                                <p class="form-control-static" id="username">someone@example.com</p>
                            </div>
                            <input type="hidden" class="form-control" id="user_id" name="user_id">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="package">Role:</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="package" name="package">
                                <?php
                                    foreach($this->packages as $pack){ ?>
                                            <option value="<?php echo($pack['id']);  ?>"><?php echo($pack['name'].' - '.$pack['default_page']);  ?></option>

                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
<?php
    include(View::rightNav());
?>
<script>
    function populatePackage(id,username){
        $("#username").text(username);
        $("#user_id").val(id);
        // alert(111);
        $("#myModal").modal()
    }
</script>
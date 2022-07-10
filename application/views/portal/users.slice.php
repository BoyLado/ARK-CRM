@extends('template.layout')

@section('page_title',$pageTitle)



@section('custom_styles')
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/select2/css/select2.min.css">

<style type="text/css">
  /*INTERNAL STYLES*/
  .tbl tr td{
    border : none !important;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow b
  {
    margin-top: 2px !important;
  }

  .select2-container .select2-selection--single .select2-selection__rendered
  {
    padding-left: 0px !important;
  }

  .select2-container--default .select2-selection--single
  {
    border: 1px solid #ced4da;
  }
  
</style>

@endsection



@section('page_content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header pt-1 pb-1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <h6 class="mt-1 float-left">
            <span>
              <a href="<?php echo base_url(); ?>users" class="text-muted">Users</a> -
            </span> 
            <small>
              <a href="<?php echo base_url(); ?>users" class="text-muted">All</a>
            </small> 
            <small> - 
              <a href="#" class="text-muted" id="lnk_user">Anton Jay</a>
            </small>
          </h6>
          <div class="float-right">
            <div class="d-inline d-lg-none">
              <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                <i class="nav-icon fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu" style="">
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_inviteNewUser">
                  <i class="fa fa-plus mr-1"></i>Invite New User
                </a>
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_importUsers">
                  <i class="fa fa-upload mr-1"></i>Import
                </a>
              </div>
            </div>
            <div class="d-none d-lg-block">
              <button type="button" class="btn btn-default btn-sm" id="btn_inviteNewUser">
                <i class="fa fa-plus mr-1"></i> Invite New User
              </button>
              <button type="button" class="btn btn-default btn-sm" id="btn_importUsers">
                <i class="fa fa-upload mr-1"></i> Import
              </button>
            </div>
          </div>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-8 col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <table id="tbl_users" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2" data-priority="1">Salutation</th>
                    <th class="p-2" data-priority="2">First Name</th>
                    <th class="p-2" data-priority="3">Last Name</th>
                    <th class="p-2">User Email</th>
                    <th class="p-2">User Status</th>
                    <th class="p-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <table id="tbl_invites" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2" colspan="2">Pending Invites</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div><!-- /.row -->

    </div><!-- /.container flued -->

    <div class="modal fade" id="modal_inviteNewUser" role="dialog">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title"><i class="fa fa-plus mr-1"></i> Invite New User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_inviteNewUser">
              <input type="email" class="form-control" id="txt_userEmail" name="txt_userEmail" placeholder="User email (e.g. ajhay.dev@gmail.com)" required>
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="reset" class="btn btn-secondary">clear</button>
            <button type="submit" class="btn btn-primary" id="btn_submitInvitation" form="form_inviteNewUser">Submit Invitation</button>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer pt-2 pb-2">
  <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 3.2.0
  </div>
  <!-- <center>
    <button type="button" class="btn btn-info btn-sm"><i class="fa fa-save mr-1"></i> Save</button>
    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-times mr-1"></i> Cancel</button>
  </center> -->
</footer>

@endsection



@section('custom_scripts')

<!-- Plugins -->
<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/select2/js/select2.full.min.js"></script>

<!-- Custom Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/portal/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_users').addClass('active');

    //topNav icon & label

    let topNav = `<i class="fas fa-user-check mr-2"></i>
                  <b>USERS</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();

    USERS.loadUsers();
    USERS.loadPendingInvites();

    $('#lnk_inviteNewUser').on('click',function(){
      $('#modal_inviteNewUser').modal('show');
    });

    $('#btn_inviteNewUser').on('click',function(){
      $('#modal_inviteNewUser').modal('show');
    });

    $('#form_inviteNewUser').on('submit',function(e){
      e.preventDefault();

      USERS.inviteNewUser(this);
    });

  });
</script>

@endsection

@extends('template.layout')

@section('page_title',$pageTitle)



@section('custom_styles')
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/css/select2.min.css">

<!-- Full Calendar -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/fullcalendar/fullcalendar.css">

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
          <h6 class="float-left mb-0">
            <span>
              <a href="javascript:void(0)" id="btn_holidays" class="btn btn-default btn-sm">
                <i class="fa fa-flag mr-1"></i>Holidays
              </a>
            </span>
          </h6>
          <div class="float-right">
            <div class="d-inline d-lg-none">
              <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                <i class="nav-icon fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu" style="">
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_addEvent">
                  <i class="fa fa-plus mr-1"></i>Add Event
                </a>
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_addTask">
                  <i class="fa fa-plus mr-1"></i>Add Task
                </a>
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_createCalendar">
                  <i class="fa fa-calendar-plus mr-1"></i>Create Calendar
                </a>
              </div>
            </div>
            <div class="d-none d-lg-block">
              <button type="button" class="btn btn-default btn-sm" id="btn_addEvent">
                <i class="fa fa-plus mr-1"></i> Add Event
              </button>
              <button type="button" class="btn btn-default btn-sm" id="btn_addTask">
                <i class="fa fa-plus mr-1"></i> Add Task
              </button>
              <button type="button" class="btn btn-default btn-sm" id="btn_createCalendar">
                <i class="fa fa-calendar-plus mr-1"></i> Create Calendar
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

      

    </div><!-- /.container flued -->
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
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/js/select2.full.min.js"></script>

<!-- FullCalendar -->

<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/moment/moment-timezone-with-data.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/fullcalendar/fullcalendar.js"></script>



<!-- Custom Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_agenda').addClass('active');

    //topNav icon & label

    let topNav = `<i class="fas fa-list mr-2"></i>
                  <b>AGENDA</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();

    //
    // ======================================================>
    //

    // AGENDA.loadCalendars();

    $('#lnk_createCalendar').on('click',function(){
      AGENDA.loadTimezones();
      AGENDA.clearEvent();
      $('#modal_calendar').modal('show');
    }); 

    $('#btn_createCalendar').on('click',function(){
      AGENDA.loadTimezones();
      AGENDA.clearEvent();
      $('#modal_calendar').modal('show');
    });

    $('#form_calendar').on('submit',function(e){
      e.preventDefault();
      let calendarId = $('#txt_calendarId').val();

      (calendarId == "")? AGENDA.addCalendar(this) : AGENDA.editCalendar(this);
    });

    $('#lnk_addEvent').on('click',function(){
      AGENDA.loadUsers('#slc_eventAssignedTo');
      AGENDA.clearTask();
      $('#modal_events').modal('show');
    });

    $('#btn_addEvent').on('click',function(){
      AGENDA.loadUsers('#slc_eventAssignedTo');
      AGENDA.clearTask();
      $('#modal_events').modal('show');
    });

    $('#lnk_addTask').on('click',function(){
      AGENDA.loadUsers('#slc_taskAssignedTo');
      $('#modal_tasks').modal('show');
    });

    $('#btn_addTask').on('click',function(){
      AGENDA.loadUsers('#slc_taskAssignedTo');
      $('#modal_tasks').modal('show');
    });

    $('#form_events').on('submit',function(e){
      e.preventDefault();
      let eventId = $('#txt_eventId').val();

      (eventId == "")? AGENDA.addEvent(this) : AGENDA.editEvent(this);
    });

    $('#form_tasks').on('submit',function(e){
      e.preventDefault();
      let taskId = $('#txt_taskId').val();

      (taskId == "")? AGENDA.addTask(this) : AGENDA.editTask(this);
    });

    $('#btn_holidays').on('click',function(){
      $('#modal_holidays').modal('show');
    });


  });
</script>

@endsection

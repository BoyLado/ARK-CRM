@extends('template.layout')

@section('page_title',$pageTitle)



@section('custom_styles')
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/select2/css/select2.min.css">

<!-- Full Calendar -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/fullcalendar/main.css">

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
              <a href="<?php echo base_url(); ?>index.php/documents" class="text-muted">Documents</a> -
            </span> 
            <small>
              <a href="<?php echo base_url(); ?>index.php/documents" class="text-muted">All</a>
            </small> 
            <!-- <small> - 
              <a href="#" class="text-muted" id="lnk_user">Anton Jay</a>
            </small> -->
          </h6>
          <div class="float-right">
            <div class="d-inline d-lg-none">
              <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                <i class="nav-icon fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu" style="">
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_addDocument">
                  <i class="fa fa-plus mr-1"></i>New Document
                </a>
                <!-- <a class="dropdown-item" href="javascript:void(0)" id="lnk_importUsers">
                  <i class="fa fa-upload mr-1"></i>Import
                </a> -->
              </div>
            </div>
            <div class="d-none d-lg-block">
              <button type="button" class="btn btn-default btn-sm" id="btn_addDocument">
                <i class="fa fa-plus mr-1"></i>New Document
              </button>
              <!-- <button type="button" class="btn btn-default btn-sm" id="btn_importUsers">
                <i class="fa fa-upload mr-1"></i> Import
              </button> -->
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
      
      <input type="hidden" id="txt_documentId" name="txt_documentId" value="{{ $documentId }}">

      @if($documentId == "")
      <div class="row">
        <div class="col-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <table id="tbl_documents" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2"></th>
                    <th class="p-2 pl-4" data-priority="1">Title</th>
                    <th class="p-2" data-priority="2">File Name</th>
                    <th class="p-2" data-priority="3">Modified Date & Time</th>
                    <th class="p-2">Assigned To</th>
                    <th class="p-2">Download Count</th>
                    <th class="p-2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->

      @else

      <div class="row">
        <div class="col-12">
          <div class="card card-primary card-outline mb-2">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-lg-4 col-sm-12">
                  <div class="info-box shadow-none bg-light mb-0">
                    <span class="info-box-icon">
                      <!-- <i class="far fa-image"></i> -->
                      <img class="img-square elevation-1" src="<?php echo base_url(); ?>assets/img/document-placeholder.png" alt="User Avatar">
                    </span>
                    <div class="info-box-content" style="line-height:1.7">
                      <span class="info-box-text" id="lbl_campaignName" style="font-size: 1.5em;">
                        <!-- Mr. Anton Jay Hermo -->
                      </span>
                      <span class="info-box-text" style="font-size: .9em;">
                        <i class="fa fa-clone mr-1"></i>
                        <span id="lbl_campaignStatus"><!-- Web Developer --></span>
                      </span>
                      <span class="info-box-text" style="font-size: .9em;">
                        <i class="fa fa-calendar mr-1"></i>
                        <span id="lbl_expectedCloseDate"><!-- ajhay.dev@gmail.com --></span>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                  
                </div>
                <div class="col-lg-4 col-sm-12">
                  <div class="d-inline d-lg-none"><hr></div>
                  <div class="form-group mb-0">
                    <button class="btn btn-sm btn-default" id="btn_editCampaign">
                      <i class="fa fa-pen mr-2"></i>Edit
                    </button>
                    <button class="btn btn-sm btn-default" id="btn_deleteCampaign">
                      <i class="fa fa-trash mr-2"></i>Delete Campaign
                    </button>
                    <!-- <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                      More <i class="nav-icon fas fa-caret-down ml-1"></i> 
                    </button>
                    <div class="dropdown-menu" style="">
                      <a class="dropdown-item hover-red" href="javascript:void(0)" id="">
                        <i class="fa fa-plus mr-2"></i>Add Event
                      </a>
                      <a class="dropdown-item" href="javascript:void(0)" id="">
                        <i class="fa fa-plus mr-2"></i>Add Task
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item text-red" href="javascript:void(0)" id="">
                        <i class="fa fa-trash mr-2"></i>Delete Organization
                      </a>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-1 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" id="lnk_details" data-toggle="pill" href="#div_details" role="tab" aria-controls="div_details" aria-selected="false">Details</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="lnk_updates" data-toggle="pill" href="#div_updates" role="tab" aria-controls="div_updates" aria-selected="false">Updates</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="lnk_contacts" data-toggle="pill" href="#div_contacts" role="tab" aria-controls="div_contacts" aria-selected="false">Contacts 
                    <span class="badge badge-danger ml-1" id="lbl_contactCount">0</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="lnk_organizations" data-toggle="pill" href="#div_organizations" role="tab" aria-controls="div_organizations" aria-selected="false">Organizations
                    <span class="badge badge-danger ml-1" id="lbl_organizationCount">0</span>
                  </a>
                </li>                
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane fade active show" id="div_details" role="tabpanel" aria-labelledby="lnk_details">
                  <div class="card shadow-none">
                    <div class="card-header p-0">
                      <h3 class="card-title">Campaign Details</h3>
                      <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      </div>
                    </div>
                    <div class="card-body p-0" style="display: block;">
                      <div class="row mt-2">
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Campaign Name</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Assigned To</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Campaign Status</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Campaign Type</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Product</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Target Audience</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Expected Close Date</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Sponsor</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Target Size</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Created Time</td>
                                <td class="p-1">
                                 ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Num Sent</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Modified Time</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="card shadow-none">
                    <div class="card-header p-0">
                      <h3 class="card-title">Expectations & Actuals</h3>
                      <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      </div>
                    </div>
                    <div class="card-body p-0" style="display: block;">
                      <div class="row mt-2">
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Budget Cost</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Expected Response</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Expected Sales Count</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Expected Response Count</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Expected ROI</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Actual Cost</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Expected Revenue</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Actual Sales Count</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Actual Response Count</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                              <tr>
                                <td class="p-1 text-muted" width="40%;" valign="middle">Actual ROI</td>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card shadow-none">
                    <div class="card-header p-0">
                      <h3 class="card-title">Description Details</h3>
                      <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      </div>
                    </div>
                    <div class="card-body p-0" style="display: block;">
                      <div class="row">
                        <div class="col-lg-6 col-sm-12">
                          <table class="table tbl mb-1">
                            <tbody>
                              <tr>
                                <td class="p-1">
                                  ---
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-lg-6 col-sm-12"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="div_updates" role="tabpanel" aria-labelledby="lnk_updates">
                  Updates
                </div>
                <div class="tab-pane fade" id="div_contacts" role="tabpanel" aria-labelledby="lnk_contacts">
                  <table id="tbl_contacts" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                    <thead>
                      <tr>
                        <th class="p-2">ID</th>
                        <th class="p-2" data-priority="1">Salutation</th>
                        <th class="p-2" data-priority="2">First Name</th>
                        <th class="p-2" data-priority="3">Last Name</th>
                        <th class="p-2">Position</th>
                        <th class="p-2">Company Name</th>
                        <th class="p-2">Primary Email</th>
                        <th class="p-2">Assigned To</th>
                        <th class="p-2">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="div_organizations" role="tabpanel" aria-labelledby="lnk_organizations">
                  <table id="tbl_organizations" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                    <thead>
                      <tr>
                        <th class="p-2">ID</th>
                        <th class="p-2" data-priority="1">Organization Name</th>
                        <th class="p-2" data-priority="2">Primary Email</th>
                        <th class="p-2" data-priority="3">Website</th>
                        <th class="p-2">State</th>
                        <th class="p-2">City</th>
                        <th class="p-2">Leads</th>
                        <th class="p-2">Assigned To</th>
                        <th class="p-2">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      @endif

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

<!-- FullCalendar -->
<script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/fullcalendar/main.js"></script>

<!-- Custom Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/portal/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_documents').addClass('active');

    //topNav icon & label

    let topNav = `<i class="fas fa-folder-open mr-2"></i>
                  <b>DOCUMENTS</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();

    let documentId = $('#txt_documentId').val();
    if(documentId == "")
    {
      // ===========================================================>
      // load Documents
      DOCUMENTS.loadDocuments();
    }
    else
    {

    }

  });
</script>

@endsection

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
                <a href="<?php echo base_url(); ?>index.php/contacts" class="text-muted">Contacts</a> -
              </span> 
              <small>
                <a href="<?php echo base_url(); ?>index.php/contacts" class="text-muted">All</a>
              </small> 
              @if($contactId != "")
              <small> - 
                <a href="javascript:void(0)" class="text-muted" id="lnk_contact"></a>
              </small>
              @endif
            </h6>
            <div class="float-right">
              <div class="d-inline d-lg-none">
                <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                  <i class="nav-icon fas fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu" style="">
                  <a class="dropdown-item" href="javascript:void(0)" id="lnk_addContacts">
                    <i class="fa fa-plus mr-1"></i>Add Contact
                  </a>
                  <a class="dropdown-item" href="javascript:void(0)" id="lnk_importContacts">
                    <i class="fa fa-upload mr-1"></i>Import
                  </a>
                </div>
              </div>
              <div class="d-none d-lg-block">
                <button type="button" class="btn btn-default btn-sm" id="btn_addContacts">
                  <i class="fa fa-plus mr-1"></i> Add Contact
                </button>
                <button type="button" class="btn btn-default btn-sm" id="btn_importContacts">
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

        <input type="hidden" id="txt_contactId" name="txt_contactId" value="{{ $contactId }}">

        @if($contactId == "")
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
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
                        <img class="img-square elevation-1" src="<?php echo base_url(); ?>assets/img/user-placeholder.png" alt="User Avatar">
                      </span>
                      <div class="info-box-content" style="line-height:1.7">
                        <span class="info-box-text" id="lbl_contactName" style="font-size: 1.5em;">
                          <!-- Mr. Anton Jay Hermo -->
                        </span>
                        <span class="info-box-text" style="font-size: .9em;">
                          <i class="fa fa-user-tie mr-1"></i>
                          <span id="lbl_contactPosition"><!-- Web Developer --></span>
                        </span>
                        <span class="info-box-text" style="font-size: .9em;">
                          <i class="fa fa-envelope mr-1"></i>
                          <span id="lbl_contactEmail"><!-- ajhay.dev@gmail.com --></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-sm-12">
                    
                  </div>
                  <div class="col-lg-4 col-sm-12">
                    <div class="d-inline d-lg-none"><hr></div>
                    <div class="form-group mb-0">
                      <button class="btn btn-sm btn-default" id="btn_editContact">
                        <i class="fa fa-pen mr-2"></i>Edit
                      </button>
                      <button class="btn btn-sm btn-default" id="btn_sendEmail">
                        <i class="fa fa-paper-plane mr-2"></i>Send Email
                      </button>
                      <!-- <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                        More <i class="nav-icon fas fa-caret-down ml-1"></i> 
                      </button>
                      <div class="dropdown-menu" style="">
                        <a class="dropdown-item hover-red" href="javascript:void(0)" id="lnk_addContacts">
                          <i class="fa fa-plus mr-2"></i>Add Event
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)" id="lnk_importContacts">
                          <i class="fa fa-plus mr-2"></i>Add Task
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-red" href="javascript:void(0)" id="lnk_importContacts">
                          <i class="fa fa-trash mr-2"></i>Delete Contact
                        </a>
                      </div> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-header p-1 border-bottom-0">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_summary" data-toggle="pill" href="#div_summary" role="tab" aria-controls="div_summary" aria-selected="true">Summary</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_details" data-toggle="pill" href="#div_details" role="tab" aria-controls="div_details" aria-selected="false">Details</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_updates" data-toggle="pill" href="#div_updates" role="tab" aria-controls="div_updates" aria-selected="false">Updates</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_activities" data-toggle="pill" href="#div_activities" role="tab" aria-controls="div_activities" aria-selected="false">Activities</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_emails" data-toggle="pill" href="#div_emails" role="tab" aria-controls="div_emails" aria-selected="false">Emails</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_documents" data-toggle="pill" href="#div_documents" role="tab" aria-controls="div_documents" aria-selected="false">Documents</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_campaigns" data-toggle="pill" href="#div_campaigns" role="tab" aria-controls="div_campaigns" aria-selected="false">
                      Campaigns
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lnk_comments" data-toggle="pill" href="#div_comments" role="tab" aria-controls="div_comments" aria-selected="false">
                      Comments
                      <span class="badge badge-danger ml-1">3</span>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane fade active show" id="div_summary" role="tabpanel" aria-labelledby="lnk_summary">
                    <div class="row">
                      <div class="col-lg-4 col-sm-12">
                        <h6>Key Fields</h6>
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">First Name</td>
                              <td class="p-1">
                                <span id="lbl_firstName">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Last Name</td>
                              <td class="p-1">
                                <span id="lbl_lastName">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Position</td>
                              <td class="p-1">
                                <span id="lbl_position">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Organization Name</td>
                              <td class="p-1">
                                <span id="lbl_organizationName">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Assigned To</td>
                              <td class="p-1">
                                <span id="lbl_assignedTo">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Mailing City</td>
                              <td class="p-1">
                                <span id="lbl_mailingCity">---</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1 text-muted" width="160px;" valign="middle">Mailing Country</td>
                              <td class="p-1">
                                <span id="lbl_mailingCountry">---</span>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        
                        <hr>

                        <h6>Documents</h6>
                        <table id="tbl_documents" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                          <tbody>
                            <tr>
                              <td class="p-1"><center>No related documents</center></td>
                            </tr>
                          </tbody>
                        </table>

                        <div class="d-inline d-lg-none"><hr></div>
                      </div>
                      <div class="col-lg-8 col-sm-12">
                        <h6>Activities</h6>
                        <table id="tbl_activities" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                          <tbody>
                            <tr>
                              <td class="p-1"><center>No pending activities</center></td>
                            </tr>
                          </tbody>
                        </table>
                        <hr>

                        <h6>Comments</h6>
                        <form id="form_summaryComments">
                          <textarea class="form-control mb-1" rows="3" id="txt_comments" name="txt_comments" placeholder="Post your comments here"></textarea>
                          <div class="row">
                            <div class="col-lg-4 col-sm-12"></div>
                            <div class="col-lg-4 col-sm-12"></div>
                            <div class="col-lg-4 col-sm-12">
                              <button type="submit" class="btn btn-primary btn-block btn-xs">Post Comment</button>
                            </div>
                          </div>
                        </form>
                        <div class="d-inline d-lg-none"><hr></div>
                        <h6>Recent Comments</h6>
                        <table id="tbl_recentComments" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                          <tbody>
                            <tr>
                              <td class="p-1"><center>No recent comments</center></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="div_details" role="tabpanel" aria-labelledby="lnk_details">
                    <div class="card shadow-none">
                      <div class="card-header p-0">
                        <h3 class="card-title">Basic Information</h3>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">First Name</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Last Name</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Position</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Company Name</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Primary Email</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Secondary Email</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Date of Birth</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Intro Letter</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Office Phone</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mobile Phone</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Home Phone</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Secondary Phone</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Fax</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Do not Call</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">LinkedIn</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Twitter</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Facebook</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Instagram</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Lead Source</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Department</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Reports To</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Email Opt Out</td>
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
                    <div class="card shadow-none">
                      <div class="card-header p-0">
                        <h3 class="card-title">Address Details</h3>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mailing Street</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mailing P.O. Box</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mailing City</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mailing State</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mailing Zip</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Mailing Country</td>
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
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other Street</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other P.O. Box</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other City</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other State</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other Zip</td>
                                  <td class="p-1">
                                    ---
                                  </td>
                                </tr>
                                <tr>
                                  <td class="p-1 text-muted" width="40%;" valign="middle">Other Country</td>
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
                    <div class="card shadow-none">
                      <div class="card-header p-0">
                        <h3 class="card-title">Profile Picture</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        </div>
                      </div>
                      <div class="card-body p-0" style="display: block;">
                        
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="div_updates" role="tabpanel" aria-labelledby="lnk_updates">
                    <div class="timeline timeline-inverse">

                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>

                      <div>
                        <i class="fas fa-envelope bg-primary"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>
                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                          <div class="timeline-body">
                              Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div>
                        </div>
                      </div>

                      <div>
                        <i class="fas fa-user bg-info"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>
                          <h3 class="timeline-header border-0">
                            <a href="#">Sarah Young</a> accepted your friend request
                          </h3>
                        </div>
                      </div>

                      <div>
                        <i class="fas fa-comments bg-warning"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>
                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                          </div>
                        </div>
                      </div>


                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>


                      <div>
                        <i class="fas fa-camera bg-purple"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 2 days ago</span>
                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                          <div class="timeline-body">
                            <!-- <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="..."> -->
                          </div>
                        </div>
                      </div>

                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="div_activities" role="tabpanel" aria-labelledby="lnk_activities">
                    Activities
                  </div>
                  <div class="tab-pane fade" id="div_emails" role="tabpanel" aria-labelledby="lnk_emails">
                    <table id="tbl_contactEmails" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                      <thead>
                        <tr>
                          <th class="p-2">ID</th>
                          <th class="p-2" data-priority="1">Sender Name</th>
                          <th class="p-2" data-priority="2">Subject</th>
                          <th class="p-2" data-priority="3">Parent Record</th>
                          <th class="p-2">Date Sent</th>
                          <th class="p-2">Time Sent</th>
                          <th class="p-2">Status</th>
                          <th class="p-2">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane fade" id="div_documents" role="tabpanel" aria-labelledby="lnk_documents">
                    Documents
                  </div>
                  <div class="tab-pane fade" id="div_campaigns" role="tabpanel" aria-labelledby="lnk_campaigns">
                    Campaigns
                  </div>
                  <div class="tab-pane fade" id="div_comments" role="tabpanel" aria-labelledby="lnk_comments">
                    <form id="form_comments">
                      <input type="hidden" id="txt_commentIndex" name="txt_commentIndex" value="0">
                      <textarea class="form-control mb-1" rows="3" id="txt_comments" name="txt_comments" placeholder="Post your comments here"></textarea>
                      <div class="row">
                        <div class="col-lg-4 col-sm-12"></div>
                        <div class="col-lg-4 col-sm-12"></div>
                        <div class="col-lg-4 col-sm-12">
                          <button type="submit" class="btn btn-primary btn-block btn-xs">Post Comment</button>
                        </div>
                      </div>
                    </form>
                    <hr>
                    <div>
                      <h6>Comments</h6>
                      <div class="card-comments p-2" id="div_loadComments" style="background: none;">
                        <div class="card-comment p-1">
                          <img class="img-circle img-sm" src="<?php echo base_url(); ?>assets/img/avatar.jpg" alt="User Image">
                          <div class="comment-text">
                            <span class="username">
                            Maria Gonzales
                            <span class="text-muted float-right">8:03 PM Today</span>
                            </span>
                            It is a long established fact that a reader will be distracted
                            by the readable content of a page when looking at its layout.
                            <br>
                            <a href="javascript:void(0)" onclick="CONTACTS.replyComment(this,1,1)" class="mr-2">Reply</a>
                            <a href="#" class="mr-2">Edit</a>
                            <div class="div-reply-to-comment"></div>
                          </div>
                          <div class="ml-3 pt-1">
                            <div class="card-comment p-0">
                              <img class="img-circle img-sm" src="<?php echo base_url(); ?>assets/img/avatar.jpg" alt="User Image">
                              <div class="comment-text">
                                <span class="username">
                                Maria Gonzales
                                <span class="text-muted float-right">8:03 PM Today</span>
                                </span>
                                It is a long established fact that a reader will be distracted
                                by the readable content of a page when looking at its layout.
                                <br>
                                <a href="javascript:void(0)" onclick="CONTACTS.replyComment(this,2,1)" class="mr-2">Reply</a>
                                <a href="#" class="mr-2">Edit</a>
                                <div class="div-reply-to-comment"></div>
                              </div>
                              <div class="ml-3 pt-1">
                                <div class="card-comment p-0">
                                  <img class="img-circle img-sm" src="<?php echo base_url(); ?>assets/img/avatar.jpg" alt="User Image">
                                  <div class="comment-text">
                                    <span class="username">
                                    Maria Gonzales
                                    <span class="text-muted float-right">8:03 PM Today</span>
                                    </span>
                                    It is a long established fact that a reader will be distracted
                                    by the readable content of a page when looking at its layout.
                                    <br>
                                    <a href="#" class="mr-2">Reply</a>
                                    <a href="#" class="mr-2">Edit</a>
                                    <div class="div-reply-to-comment"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="card-comment p-1">
                          <img class="img-circle img-sm" src="<?php echo base_url(); ?>assets/img/avatar.jpg" alt="User Image">
                          <div class="comment-text">
                            <span class="username">
                            Luna Stark
                            <span class="text-muted float-right">8:03 PM Today</span>
                            </span>
                            It is a long established fact that a reader will be distracted
                            by the readable content of a page when looking at its layout.
                            <br>
                            <a href="javascript:void(0)" onclick="CONTACTS.replyComment(this,3,1)" class="mr-2">Reply</a>
                            <a href="#" class="mr-2">Edit</a>
                            <div class="div-reply-to-comment"></div>
                          </div>
                        </div>
                      </div>

                      

                    </div>
                  </div>
                </div> 
              </div>

            </div>
          </div>
        </div>

        @endif
        
      </div><!-- container-fluid -->

      <div class="modal fade" id="modal_contact" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title" id="lbl_stateContact">
                <i class="fa fa-plus mr-1"></i> 
                <span>Add Contact</span>
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_contacts">
                
                <!-- <input type="hidden" id="txt_contactId" name="txt_contactId">   -->

                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">Basic Information - 
                      <small><i class="text-red">All fields with astirisk(*) is required </i></small>
                    </h5>
                  </div>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Salutation</td>
                              <td class="p-1">
                                <select class="form-control form-control-sm" id="slc_salutation" name="slc_salutation">
                                  <option value="" selected>--Salutation--</option>
                                  <option value="Mr.">Mr.</option>
                                  <option value="Ms.">Ms.</option>
                                  <option value="Mrs.">Mrs.</option>
                                  <option value="Dr.">Dr.</option>
                                  <option value="Prof.">Prof.</option>
                                </select>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12"></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">First Name</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Last Name *</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_lastName" name="txt_lastName" placeholder="(e.g. Dela Cruz)" required>
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
                              <td class="p-1" width="120px;" valign="middle">Position</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_position" name="txt_position" placeholder="(e.g. Web Developer)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Company Name</td>
                              <td class="p-1">
                                <select class="form-control select2" id="slc_companyName" name="slc_companyName" style="width:100%;">
                                  <option value="">--Select Organization--</option>
                                </select>
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
                              <td class="p-1" width="120px;" valign="middle">Primary Email</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_primaryEmail" name="txt_primaryEmail" placeholder="(e.g. juan@gmail.com)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Secondary Email</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_secondaryEmail" name="txt_secondaryEmail" placeholder="(e.g. juandelacruz@gmail.com)">
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
                              <td class="p-1" width="120px;" valign="middle">Date of Birth</td>
                              <td class="p-1">
                                <input type="date" class="form-control form-control-sm" id="txt_birthDate" name="txt_birthDate" placeholder="(e.g. yyyy/mm/dd)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Intro Letter</td>
                              <td class="p-1">
                                <select class="form-control form-control-sm" id="slc_introLetter" name="slc_introLetter">
                                  <option value="" selected>--Sent or Respond--</option>
                                  <option value="Sent">Sent</option>
                                  <option value="Respond">Respond</option>
                                </select>
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
                              <td class="p-1" width="120px;" valign="middle">Office Phone</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_officePhone" name="txt_officePhone" placeholder="(e.g. +63xxxxxxxx)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mobile Phone</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mobilePhone" name="txt_mobilePhone" placeholder="(e.g. +63xxxxxxxx)">
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
                              <td class="p-1" width="120px;" valign="middle">Home Phone</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_homePhone" name="txt_homePhone" placeholder="(e.g. +63xxxxxxxx)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Secondary Phone</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_secondaryPhone" name="txt_secondaryPhone" placeholder="(e.g. +63xxxxxxxx)">
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
                              <td class="p-1" width="120px;" valign="middle">Fax</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_fax" name="txt_fax" placeholder="(e.g. +63xxxxxxxx)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Do not Call</td>
                              <td class="p-1">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" id="chk_doNotCall" name="chk_doNotCall">
                                </div>
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
                              <td class="p-1" width="120px;" valign="middle">LinkedIn</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_linkedinUrl" name="txt_linkedinUrl" placeholder="(e.g. xxxxx)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Twitter</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_twitterUrl" name="txt_twitterUrl" placeholder="(e.g. xxxxx)">
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
                              <td class="p-1" width="120px;" valign="middle">Facebook</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_facebookUrl" name="txt_facebookUrl" placeholder="(e.g. xxxxx)">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Instagram</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_instagramUrl" name="txt_instagramUrl" placeholder="(e.g. xxxxx)">
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
                              <td class="p-1" width="120px;" valign="middle">Lead Source</td>
                              <td class="p-1">
                                <select class="form-control form-control-sm" id="slc_leadSource" name="slc_leadSource" style="width:100%;">
                                  <option value="" selected>--Select an option--</option>
                                  <option value="Cold-Call">Cold Call</option>
                                  <option value="Existing-Customer">Existing Customer</option>
                                  <option value="Self-Generated">Self Generated</option>
                                  <option value="Employee">Employee</option>
                                  <option value="Partner">Partner</option>
                                  <option value="Public-Relations">Public Relations</option>
                                  <option value="Direct-Mail">Direct Mail</option>
                                  <option value="Conference">Conference</option>
                                  <option value="Trade-Show">Trade Show</option>
                                  <option value="Web-Site">Web Site</option>
                                  <option value="Word-of-Mouth">Word of Mouth</option>
                                  <option value="Other">Other</option>
                                </select>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Department</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_department" name="txt_department" placeholder="(e.g. IT Department)">
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
                              <td class="p-1" width="120px;" valign="middle">Reports To</td>
                              <td class="p-1">
                                <select class="form-control select2" id="slc_reportsTo" name="slc_reportsTo" style="width:100%;">
                                  <option value="">--Select user--</option>
                                </select>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Assigned To *</td>
                              <td class="p-1">
                                <select class="form-control select2" id="slc_assignedTo" name="slc_assignedTo" required style="width:100%;">
                                  <option value="">--Select user--</option>
                                </select>
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
                              <td class="p-1" width="120px;" valign="middle">Email Opt Out</td>
                              <td class="p-1">
                                <select class="form-control form-control-sm" id="slc_emailOptOut" name="slc_emailOptOut">
                                  <option value="" selected>--Yes or No--</option>
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                                </select>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12"></div>
                    </div>

                  </div>
                </div>
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">Address Details</h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing Street</td>
                              <td class="p-1">
                                <textarea class="form-control" rows="3" id="txt_mailingStreet" name="txt_mailingStreet"></textarea>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing P.O. Box</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mailingPOBox" name="txt_mailingPOBox">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing City</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mailingCity" name="txt_mailingCity">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing State</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mailingState" name="txt_mailingState">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing Zip</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mailingZip" name="txt_mailingZip">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing Country</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_mailingCountry" name="txt_mailingCountry">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other Street</td>
                              <td class="p-1">
                                <textarea class="form-control" rows="3" id="txt_otherStreet" name="txt_otherStreet"></textarea>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other P.O. Box</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_otherPOBox" name="txt_otherPOBox">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other City</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_otherCity" name="txt_otherCity">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other State</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_otherState" name="txt_otherState">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other Zip</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_otherZip" name="txt_otherZip">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other Country</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_otherCountry" name="txt_otherCountry">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">Description Details</h5>
                  </div>
                  <div class="card-body">
                    <span>Description</span>
                    <textarea class="form-control" rows="5" id="txt_description" name="txt_description">sads</textarea>
                  </div>
                </div>
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">Profile Picture <span class="text-red">[under construction]</span></h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-6 col-sm-12">
                        <div class="info-box shadow-none bg-light mb-2">
                          <span class="info-box-icon bg-warning"><i class="far fa-image"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-number">Note:</span>
                            <span class="info-box-text">Accepted files (.jpg, .png, .jpeg)</span>
                          </div>
                        </div>
                        <input type="file" class="form-control" id="file_profilePicture" name="file_profilePicture" style="padding: 3px 3px 3px 3px !important;">
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        
                      </div>
                    </div>                    
                  </div>
                </div>

              </form>
                
            </div>
            <div class="modal-footer modal-footer--sticky">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" form="form_contacts">Save Contact</button>
            </div>

          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_importContacts" role="dialog">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-plus mr-1"></i> Import Contacts</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_importContacts">
                <center><h4 class="text-red">! Under construction</h4></center>
                <input type="file" class="form-control" style="padding: 3px 3px 3px 3px !important;" name="file_pdf" accept=".pdf">
                <a href="javascript:void(0)"><i>Download file format</i></a>
              </form>

            </div>
            <div class="modal-footer modal-footer--sticky">
              <button type="reset" class="btn btn-secondary">clear</button>
              <button type="submit" class="btn btn-primary" form="form_importContacts">Upload File</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_sendContactEmail" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-paper-plane mr-2"></i>Send Email</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="form_sendContactEmail">
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    <label class="col-form-label text-muted" for="inputError">
                      <i class="fa fa-info-circle"></i> Choose Email Template 
                    </label>
                    <select class="form-control select2" id="slc_emailTemplate" style="width:100%;">
                      <option value="">--Optional--</option>
                    </select>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <label class="col-form-label text-muted" for="inputError">
                      <i class="fa fa-info-circle"></i> Choose Signature
                    </label>
                    <select class="form-control select2" id="slc_emailSignature" style="width:100%;">
                      <option value="">--Optional--</option>
                    </select>
                  </div>
                </div>

                <label class="col-form-label text-muted" for="inputError">
                  <i class="fa fa-info-circle"></i> To *
                </label>
                <div class="input-group">
                  <!-- <div class="input-group-prepend">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Add
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Add Cc</a>
                      <a class="dropdown-item" href="#">Add Bcc</a>
                    </div>
                  </div> -->
                  <input type="text" id="txt_to" name="txt_to" class="form-control form-control-sm" placeholder="Required" required>
                </div>
                <!-- <div class="input-group mt-1">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn-default btn-sm">
                    Cc
                    </button>
                  </div>
                  <input type="text" class="form-control form-control-sm" placeholder="Required" required>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-default btn-sm">
                    <i class="fa fa-times text-red"></i>
                    </button>
                  </div>
                </div>
                <div class="input-group mt-1">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn-default btn-sm">
                    Bcc
                    </button>
                  </div>
                  <input type="text" class="form-control form-control-sm" placeholder="Required" required>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-default btn-sm">
                    <i class="fa fa-times text-red"></i>
                    </button>
                  </div>
                </div> -->

                <label class="col-form-label text-muted" for="inputError">
                  <i class="fa fa-info-circle"></i> Subject *
                </label>
                <input type="text" class="form-control form-control-sm" id="txt_subject" name="txt_subject" placeholder="Required" required>
                <label class="col-form-label text-muted" for="inputError">
                  <i class="fa fa-info-circle"></i> Content *
                </label>
                <textarea id="txt_content" name="txt_content" required></textarea>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="chk_unsubscribe" name="chk_unsubscribe">
                  <label class="form-check-label" for="chk_unsubscribe">Include unsubscribe link</label>
                </div>

                <hr>
                <label class="col-form-label text-muted" for="inputError">
                  <i class="fa fa-info-circle"></i> Possible Subtitutions 
                </label>
              </form>

            </div>
            <div class="modal-footer modal-footer--sticky">
              <button type="button" class="btn btn-secondary">clear</button>
              <button type="submit" class="btn btn-primary" id="btn_sendContactEmail" form="form_sendContactEmail">
                <i class="fa fa-paper-plane mr-1"></i> Send Email
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /.content -->
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
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/portal/marketing/{{ $customScripts }}.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      //jQuery Events

      //sideNav active/inactive

      $('.nav-item').removeClass('menu-open');
      $('#nav_marketing').parent('li').addClass('menu-open');
      $('.nav-link').removeClass('active');
      $('#nav_marketing').addClass('active'); // menu
      $('#nav_contacts').addClass('active');  // sub-menu

      //topNav icon & label

      let topNav = `<i class="fas fa-users mr-2"></i>
                    <b>MARKETING</b>`;
      $('#lnk_topNav').html(topNav);

      //events

      $('.select2').select2();

      $('#btn_addContacts').on('click',function(){
        CONTACTS.loadUsers(['#slc_reportsTo','#slc_assignedTo']);
        CONTACTS.loadOrganizations('#slc_companyName');
        $('#lbl_stateContact span').text('Add Contact');
        $('#lbl_stateContact i').removeClass('fa-pen');
        $('#lbl_stateContact i').addClass('fa-plus');
        $('#modal_contact').modal('show');
      });

      $('#btn_importContacts').on('click',function(){
        $('#modal_importContacts').modal('show');
      });

      $('#lnk_addContacts').on('click',function(){
        CONTACTS.loadUsers('#slc_reportsTo');
        CONTACTS.loadUsers('#slc_assignedTo');
        CONTACTS.loadOrganizations('#slc_companyName');
        $('#lbl_stateContact span').text('Add Contact');
        $('#lbl_stateContact i').removeClass('fa-pen');
        $('#lbl_stateContact i').addClass('fa-plus');
        $('#modal_contact').modal('show');
      });

      $('#lnk_importContacts').on('click',function(){
        $('#modal_importContacts').modal('show');
      });

      $('#form_contacts').on('submit',function(e){
        e.preventDefault();
        ($('#txt_contactId').val() == "")? CONTACTS.addContact(this) : CONTACTS.editContact(this);
      });

      let contactId = $('#txt_contactId').val();
      if(contactId == "")
      {
        // ===========================================================>
        // load Contacts

        CONTACTS.loadContacts();
      }
      else
      {
        // ===========================================================>
        // select Contact

        $('#lnk_summary').addClass('active');

        CONTACTS.selectContact('load',contactId);
        CONTACTS.loadContactSummary(contactId);
        
        $('#btn_editContact').on('click',function(){
          CONTACTS.selectContact('edit',contactId);
        });

        $('#btn_sendEmail').on('click',function(){
          CONTACTS.loadEmailTemplates();
          $('#txt_to').val($('#lbl_contactEmail').text());
          $('#txt_content').summernote(summernoteConfig);
          $('#modal_sendContactEmail').modal('show');
        });

        $('#lnk_summary').on('click',function(){
          CONTACTS.loadContactSummary(contactId);
        });

        $('#lnk_details').on('click',function(){
          CONTACTS.loadContactDetails(contactId);
        });

        $('#lnk_updates').on('click',function(){

        });

        $('#lnk_activities').on('click',function(){

        });

        $('#lnk_emails').on('click',function(){
          CONTACTS.loadContactEmails(contactId);
        });

        $('#lnk_documents').on('click',function(){

        });

        $('#lnk_campaigns').on('click',function(){

        });

        $('#lnk_comments').on('click',function(){
          CONTACTS.loadContactComments(contactId);
        });


        // comments
        $('#form_comments').on('submit',function(e){
          e.preventDefault();
          CONTACTS.addContactComment(this);
        });

        $('#form_replyToComment').on('submit',function(e){
          e.preventDefault();
          CONTACTS.replyContactComment(this);
        });
      }

      $('#slc_emailTemplate').on('change',function(){
        let contactId = $('#txt_contactId').val();
        let templateId = $(this).val();
        CONTACTS.selectEmailTemplate(contactId,templateId);
      });

      $('#form_sendContactEmail').on('submit',function(e){
        e.preventDefault();
        CONTACTS.sendContactEmail(this);
      });





      //test code for uploading pdf
      $('#form_importContacts').on('submit',function(e){
        e.preventDefault();
        CONTACTS.uploadPdf(this);
      });  

      

      // test codes

      $('#summernote').summernote({height: 300});

      $(document).ready( function () {
        $('#myTable').DataTable();
      } );

      // $('body').addClass('layout-footer-fixed');
      // $('body').removeClass('layout-footer-fixed');

      $('#form_email').on('submit',function(e){
        e.preventDefault();

        let formData = new FormData(this);
        $.ajax({
          /*  */
          url : `${baseUrl}index.php/submit-sample-email`,
          method : 'post',
          dataType: 'json',
          processData: false, // important
          contentType: false, // important
          data : formData,
          success : function(result)
          {
            console.log(result);
          }
        });

      });
    });
  </script>

  @endsection

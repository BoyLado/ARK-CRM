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
              <a href="<?php echo base_url(); ?>index.php/organizations" class="text-muted">Campaigns</a> -
            </span> 
            <small>
              <a href="<?php echo base_url(); ?>index.php/organizations" class="text-muted">All</a>
            </small> 
            @if($campaignId != "")
            <small> - 
              <a href="javascript:void(0)" class="text-muted" id="lnk_campaign"></a>
            </small>
            @endif
          </h6>
          <div class="float-right">
            <div class="d-inline d-lg-none">
              <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                <i class="nav-icon fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu" style="">
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_addCampaign">
                  <i class="fa fa-plus mr-1"></i>Add Campaign
                </a>
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_importCampaigns">
                  <i class="fa fa-upload mr-1"></i>Import
                </a>
              </div>
            </div>
            <div class="d-none d-lg-block">
              <button type="button" class="btn btn-default btn-sm" id="btn_addCampaign">
                <i class="fa fa-plus mr-1"></i> Add Campaign
              </button>
              <button type="button" class="btn btn-default btn-sm" id="btn_importCampaigns">
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

      <input type="hidden" id="txt_campaignId" name="txt_campaignId" value="{{ $campaignId }}">

      @if($campaignId == "")
      <div class="row">
        <div class="col-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <table id="tbl_campaigns" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2" data-priority="1">Campaign Name</th>
                    <th class="p-2" data-priority="2">Campaign Type</th>
                    <th class="p-2" data-priority="3">Campaign Status</th>
                    <th class="p-2">Expected Revenue</th>
                    <th class="p-2">Expected Close Date</th>
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
                      <img class="img-square elevation-1" src="<?php echo base_url(); ?>assets/img/campaign-placeholder.png" alt="User Avatar">
                    </span>
                    <div class="info-box-content" style="line-height:1.7">
                      <span class="info-box-text" id="lbl_campaignName" style="font-size: 1.5em;">
                        <!-- Mr. Anton Jay Hermo -->
                      </span>
                      <span class="info-box-text" style="font-size: .9em;">
                        <i class="fa fa-globe mr-1"></i>
                        <span id="lbl_organizationWebSite"><!-- Web Developer --></span>
                      </span>
                      <span class="info-box-text" style="font-size: .9em;">
                        <i class="fa fa-envelope mr-1"></i>
                        <span id="lbl_organizationEmail"><!-- ajhay.dev@gmail.com --></span>
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
                  <a class="nav-link" id="lnk_contacts" data-toggle="pill" href="#div_contacts" role="tab" aria-controls="div_contacts" aria-selected="false">Contacts</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="lnk_activities" data-toggle="pill" href="#div_activities" role="tab" aria-controls="div_activities" aria-selected="false">Activities</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="lnk_organizations" data-toggle="pill" href="#div_organizations" role="tab" aria-controls="div_organizations" aria-selected="false">Organizations</a>
                </li>                
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane fade active show" id="div_details" role="tabpanel" aria-labelledby="lnk_details">
                  Details
                </div>
                <div class="tab-pane fade" id="div_updates" role="tabpanel" aria-labelledby="lnk_updates">
                  Updates
                </div>
                <div class="tab-pane fade" id="div_contacts" role="tabpanel" aria-labelledby="lnk_contacts">
                  Contacts
                </div>
                <div class="tab-pane fade" id="div_activities" role="tabpanel" aria-labelledby="lnk_activities">
                  Activities
                </div>
                <div class="tab-pane fade" id="div_organizations" role="tabpanel" aria-labelledby="lnk_organizations">
                  Organizations
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      @endif
      
    </div><!-- container-fluid -->

    <div class="modal fade" id="modal_campaign" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title" id="lbl_stateOrganization">
              <i class="fa fa-plus mr-1"></i> 
              <span>Add Campaign</span>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_campaign">
              
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
                            <td class="p-1" width="120px;" valign="middle">Organization *</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_organizationName" name="txt_organizationName" placeholder="(Organization name is regquired)">
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
                              <select class="form-control select2" id="slc_assignedTo" name="slc_assignedTo" style="width:100%;">
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
                            <td class="p-1" width="120px;" valign="middle">Primary Email *</td>
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
                              <input type="text" class="form-control form-control-sm" id="txt_secondaryEmail" name="txt_secondaryEmail" placeholder="(e.g. juantwo@gmail.com)">
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
                            <td class="p-1" width="120px;" valign="middle">Main Website</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_mainWebsite" name="txt_mainWebsite" placeholder="(e.g. https://www.oragon.com)">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Other Website</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_otherWebsite" name="txt_otherWebsite" placeholder="(e.g. https://www.crm.oragon.com)">
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
                            <td class="p-1" width="120px;" valign="middle">Phone Number</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_phoneNumber" name="txt_phoneNumber" placeholder="(e.g. 09395202340)">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Fax</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_fax" name="txt_fax" placeholder="(e.g. 09395202340)">
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
                              <input type="text" class="form-control form-control-sm" id="txt_linkedinUrl" name="txt_linkedinUrl" placeholder="(e.g. xxxxxxx)">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Facebook</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_facebookUrl" name="txt_facebookUrl" placeholder="(e.g. xxxxxxx)">
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
                            <td class="p-1" width="120px;" valign="middle">Twitter</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_twitterUrl" name="txt_twitterUrl" placeholder="(e.g. xxxxxxx)">
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
                              <input type="text" class="form-control form-control-sm" id="txt_instagramUrl" name="txt_instagramUrl" placeholder="(e.g. xxxxxxx)">
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
                            <td class="p-1" width="120px;" valign="middle">Industry</td>
                            <td class="p-1">
                              <select class="form-control select2" id="slc_industry" name="slc_industry" style="width:100%;">
                                <option value="">--Select industry--</option>
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
                            <td class="p-1" width="120px;" valign="middle">NAICS Code</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_naicsCode" name="txt_naicsCode" placeholder="(e.g. xxxxxxx)">
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
                            <td class="p-1" width="120px;" valign="middle">Employee Count</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_employeeCount" name="txt_employeeCount" placeholder="(e.g. 5-10)">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Annual Revenue</td>
                            <td class="p-1">
                              <input type="number" class="form-control form-control-sm" id="txt_annualRevenue" name="txt_annualRevenue" placeholder="(e.g. 1,000,000)">
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
                            <td class="p-1" width="120px;" valign="middle">Type</td>
                            <td class="p-1">
                              <select class="form-control select2" id="slc_type" name="slc_type" style="width:100%;">
                                <option value="">--Select type--</option>
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
                            <td class="p-1" width="120px;" valign="middle">Ticket Symbol</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_ticketSymbol" name="txt_ticketSymbol" placeholder="(e.g. xxxxx)">
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
                            <td class="p-1" width="120px;" valign="middle">Member Of</td>
                            <td class="p-1">
                              <select class="form-control select2" id="slc_memberOf" name="slc_memberOf" style="width:100%;">
                                <option value="">--Select organization--</option>
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
                  </div>

                </div>
              </div>
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="m-0">Address Details</h5>
                </div>
                <div class="card-body">

                  <div class="row mb-0">
                    <div class="col-lg-4 col-sm-12">
                      <label>Is Billing the same as Shipping?</label>
                    </div>
                    <div class="col-lg-8 col-sm-12">
                      <label class="radio-inline">
                        <input type="radio" class="mr-1" name="rdb_optradio" checked>Yes
                      </label>
                      <label class="radio-inline">
                        <input type="radio" class="mr-1" name="rdb_optradio">No
                      </label>
                    </div>
                    <!-- <div class="col-lg-12 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="220px;" valign="middle">
                              <label>Is Billing the same as Shipping?</label>
                            </td>
                            <td class="p-1">
                              <label class="radio-inline">
                                <input type="radio" class="mr-1" name="rdb_optradio" checked>Yes
                              </label>
                              <label class="radio-inline">
                                <input type="radio" class="mr-1" name="rdb_optradio">No
                              </label>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div> -->
                  </div>

                  <hr>

                  <div class="row">
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Billing Street</td>
                            <td class="p-1">
                              <textarea class="form-control" rows="3" id="txt_billingStreet" name="txt_billingStreet"></textarea>
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Billing City</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_billingCity" name="txt_billingCity">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Billing State</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_billingState" name="txt_billingState">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Billing Zip</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_billingZip" name="txt_billingZip">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Billing Country</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_billingCountry" name="txt_billingCountry">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <table class="table tbl mb-1">
                        <tbody>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Shipping Street</td>
                            <td class="p-1">
                              <textarea class="form-control" rows="3" id="txt_shippingStreet" name="txt_shippingStreet"></textarea>
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Shipping City</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_shippingCity" name="txt_shippingCity">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Shipping State</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_shippingState" name="txt_shippingState">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Shipping Zip</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_shippingZip" name="txt_shippingZip">
                            </td>
                          </tr>
                          <tr>
                            <td class="p-1" width="120px;" valign="middle">Shipping Country</td>
                            <td class="p-1">
                              <input type="text" class="form-control form-control-sm" id="txt_shippingCountry" name="txt_shippingCountry">
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
                  <textarea class="form-control" rows="5" id="txt_description" name="txt_description"></textarea>
                </div>
              </div>
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="m-0">Profile Picture</h5>
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
            <button type="submit" class="btn btn-primary" form="form_campaign">Save Organization</button>
          </div>

        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_importCampaigns" role="dialog">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title"><i class="fa fa-plus mr-1"></i> Import Campaigns</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_importCampaigns">
              <center><h4 class="text-red">! Under construction</h4></center>
              <input type="file" class="form-control" style="padding: 3px 3px 3px 3px !important;" name="file_pdf" accept=".pdf">
              <a href="javascript:void(0)"><i>Download file format</i></a>
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="reset" class="btn btn-secondary">clear</button>
            <button type="submit" class="btn btn-primary" form="form_importCampaigns">Upload File</button>
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
    $('#nav_campaigns').addClass('active');  // sub-menu

    //topNav icon & label

    let topNav = `<i class="fas fa-users mr-2"></i>
                    <b>MARKETING</b>`;
    $('#lnk_topNav').html(topNav);

    //events

    $('.select2').select2();

    $('#btn_addCampaign').on('click',function(){
      CAMPAIGN.loadUsers('#slc_assignedTo');
      CAMPAIGN.loadCampaigns('select');
      $('#lbl_stateOrganization span').text('Add Organization');
      $('#lbl_stateOrganization i').removeClass('fa-pen');
      $('#lbl_stateOrganization i').addClass('fa-plus');
      $('#modal_organization').modal('show');
    });

    $('#btn_importCampaigns').on('click',function(){
      $('#modal_importCampaigns').modal('show');
    });

    $('#lnk_addOrganization').on('click',function(){
      CAMPAIGN.loadUsers('#slc_assignedTo');
      CAMPAIGN.loadCampaigns('select');
      $('#lbl_stateOrganization span').text('Add Organization');
      $('#lbl_stateOrganization i').removeClass('fa-pen');
      $('#lbl_stateOrganization i').addClass('fa-plus');
      $('#modal_organization').modal('show');
    });

    $('#lnk_importCampaigns').on('click',function(){
      $('#modal_importCampaigns').modal('show');
    });

    $('#form_organization').on('submit',function(e){
      e.preventDefault();
      CAMPAIGN.addOrganization(this);
    });

    let campaignId = $('#txt_campaignId').val();
    if(campaignId == "")
    {
      // ===========================================================>
      // load Organizations
      CAMPAIGN.loadCampaigns('table');
    }
    else
    {
      // ===========================================================>
      // select Organization

      $('#lnk_details').addClass('active');

      CAMPAIGN.selectOrganization('load',campaignId);

      $('#btn_editOrganization').on('click',function(){
        CAMPAIGN.selectOrganization('edit',campaignId);
      });

      $('#btn_sendEmail').on('click',function(){
        CAMPAIGN.loadEmailTemplates();
        $('#txt_to').val($('#lbl_organizationEmail').text());
        $('#txt_content').summernote(summernoteConfig);
        $('#modal_sendOrganizationEmail').modal('show');
      });
    }

    $('#slc_emailTemplate').on('change',function(){
      let campaignId = $('#txt_campaignId').val();
      let templateId = $(this).val();
      CAMPAIGN.selectEmailTemplate(campaignId,templateId);
    });

    $('#form_sendOrganizationEmail').on('submit',function(e){
      e.preventDefault();
      CAMPAIGN.sendOrganizationEmail(this);
    });



  });
</script>

@endsection

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
                <a href="<?php echo base_url(); ?>contacts" class="text-muted">Contacts</a> -
              </span> 
              <small>
                <a href="<?php echo base_url(); ?>contacts" class="text-muted">All</a>
              </small> 
              <small> - 
                <a href="#" class="text-muted" id="lnk_contact">Anton Jay</a>
              </small>
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
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <table id="tbl_contacts" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                  <thead>
                    <tr>
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

        <!-- <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <form id="form_email">
                  <textarea id="summernote" name="summernote">
                    Place <em>some</em> <u>text</u> <strong>here</strong>
                  </textarea>
                  <button type="submit" class="btn btn-default btn-sm">
                    <i class="fa fa-paper-plane mr-1"></i> Send Mail
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div> -->
        
      </div><!-- container-fluid -->

      <div class="modal fade" id="modal_addContacts" role="dialog">
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
                
                <input type="hidden" id="txt_contactId" name="txt_contactId">  

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
                                  <option value="">--salutation--</option>
                                  <option value="Mr.">Mr.</option>
                                  <option value="Mrs.">Mrs.</option>
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
                                <input type="text" class="form-control form-control-sm" id="txt_lastName" name="txt_lastName" placeholder="(e.g. Dela Cruz)">
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
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Web Developer)">
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
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Oragon IT Solution)">
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
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. juan@gmail.com)">
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
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. juandelacruz@gmail.com)">
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
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. yyyy/mm/dd)">
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
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="">
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
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. xxxxx)">
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
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. xxxxx)">
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
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. xxxxx)">
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
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. xxxxx)">
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
                                <select class="form-control form-control-sm"></select>
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
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
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
                              <td class="p-1" width="120px;" valign="middle">Assigned To *</td>
                              <td class="p-1">
                                <select class="form-control select2" style="width:100%;">
                                  <option value="">Select User</option>
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
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
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
                                <textarea class="form-control" rows="3"></textarea>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing P.O. Box</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing City</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing State</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing Zip</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Mailing Country</td>
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
                              <td class="p-1" width="120px;" valign="middle">Other Street</td>
                              <td class="p-1">
                                <textarea class="form-control" rows="3"></textarea>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other P.O. Box</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other City</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other State</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other Zip</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
                              </td>
                            </tr>
                            <tr>
                              <td class="p-1" width="120px;" valign="middle">Other Country</td>
                              <td class="p-1">
                                <input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName" placeholder="(e.g. Juan)">
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
                    <textarea class="form-control" rows="5"></textarea>
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
                        <input type="file" class="form-control" style="padding: 3px 3px 3px 3px !important;" name="">
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
              <button type="submit" class="btn btn-primary" form="form_contacts">Save changes</button>
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

      CONTACTS.loadContacts();

      $('#btn_addContacts').on('click',function(){
        $('#lbl_stateContact span').text('Add Contact');
        $('#lbl_stateContact i').removeClass('fa-pen');
        $('#lbl_stateContact i').addClass('fa-plus');
        $('#modal_addContacts').modal('show');
      });

      $('#btn_importContacts').on('click',function(){
        $('#modal_importContacts').modal('show');
      });

      $('#lnk_addContacts').on('click',function(){
        $('#lbl_stateContact span').text('Add Contact');
        $('#lbl_stateContact i').removeClass('fa-pen');
        $('#lbl_stateContact i').addClass('fa-plus');
        $('#modal_addContacts').modal('show');
      });

      $('#lnk_importContacts').on('click',function(){
        $('#modal_importContacts').modal('show');
      });

      $('#form_contacts').on('submit',function(e){
        e.preventDefault();
        CONTACTS.addContact(this);
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
          url : `${baseUrl}submit-sample-email`,
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

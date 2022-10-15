@extends('template.layout')

@section('page_title',$pageTitle)



@section('custom_styles')
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/css/select2.min.css">

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
              <a href="<?php echo base_url(); ?>index.php/email-template" class="text-muted">Email Templates</a> -
            </span> 
            <small>
              <a href="<?php echo base_url(); ?>index.php/email-template" class="text-muted">All</a>
            </small> 
            <!-- <small> - 
              <a href="#" class="text-muted" id="lnk_contact">Anton Jay</a>
            </small> -->
          </h6>
          <div class="float-right">
            <div class="d-inline d-lg-none">
              <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown">
                <i class="nav-icon fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu" style="">
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_createTemplate">
                  <i class="fa fa-plus mr-1"></i>Create Template
                </a>
                <a class="dropdown-item" href="javascript:void(0)" id="lnk_importTemplate">
                  <i class="fa fa-upload mr-1"></i>Import
                </a>
              </div>
            </div>
            <div class="d-none d-lg-block">
              <button type="button" class="btn btn-default btn-sm" id="btn_createTemplate">
                <i class="fa fa-plus mr-1"></i> Create Template
              </button>
              <button type="button" class="btn btn-default btn-sm" id="btn_importTemplate">
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
        <div class="col-lg-3 col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <table id="tbl_categories" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2" colspan="2">Categories</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="p-2"><center>Empty!</center></td>
                  </tr>
                </tbody>
              </table>
              <hr>
              <form id="form_category">
                <input type="text" class="form-control form-control-sm" id="txt_categoryName" name="txt_categoryName" placeholder="Category Name (required)" required>
                <div class="mb-2"></div>
                <textarea class="form-control form-control-sm" rows="5" id="txt_categoryDescription" name="txt_categoryDescription" placeholder="Description (optional)"></textarea>
                <div class="mb-2"></div>
                <button type="submit" class="btn btn-primary btn-sm btn-block">
                  <i class="fa fa-plus mr-1"></i> Add New Category
                </button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-9 col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <table id="tbl_emailTemplates" class="table display nowrap" style="border: .5px solid #DEE2E6;" width="100%">
                <thead>
                  <tr>
                    <th class="p-2 pl-4" data-priority="1">Name/Code</th>
                    <th class="p-2" data-priority="2">Category</th>
                    <th class="p-2" data-priority="3">Owner</th>
                    <th class="p-2">Subject</th>
                    <th class="p-2">Access</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Date Created</th>
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
          <div class="card">
            <div class="card-header">
              <h5 class="m-0">Email Template Preview</h5>
            </div>
            <div class="card-body">
              
            </div>
          </div>
        </div>
      </div> -->

    </div> <!-- container-fluid -->

    <div class="modal fade" id="modal_createTemplate" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header--sticky">
            <h5 class="modal-title"><i class="fa fa-plus mr-2"></i>Create Email Template</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="form_emailTemplate">
              <div class="row">
                <div class="col-lg-4 col-sm-12">
                  <label class="col-form-label text-muted" for="inputError">
                    <i class="fa fa-info-circle"></i> Template Name/Code *
                  </label>
                  <input type="text" class="form-control form-control-sm" id="txt_templateName" name="txt_templateName" required> 
                </div>
                <div class="col-lg-4 col-sm-12">
                  <label class="col-form-label text-muted" for="inputError">
                    <i class="fa fa-info-circle"></i> Category * 
                  </label>
                  <select class="form-control form-control-sm" id="slc_category" name="slc_category" required>
                  </select>
                </div>
                <div class="col-lg-4 col-sm-12">
                  <label class="col-form-label text-muted" for="inputError">
                    <i class="fa fa-info-circle"></i> Accessibility *
                  </label>
                  <select class="form-control form-control-sm" id="slc_templateVisibility" name="slc_templateVisibility">
                    <option value="">--Select Private or Public--</option>
                    <option value="Public">Public</option>
                    <option value="Private">Private</option>
                  </select>
                </div>
              </div>
              <label class="col-form-label text-muted" for="inputError">
                <i class="fa fa-info-circle"></i> Description 
              </label>
              <textarea class="form-control form-control-sm" rows="4" id="txt_description" name="txt_description" placeholder="Description (optional)"></textarea>
              <hr>
              <label class="col-form-label text-muted" for="inputError">
                <i class="fa fa-info-circle"></i> Subject *
              </label>
              <input type="text" class="form-control form-control-sm" id="txt_subject" name="txt_subject" required>
              <label class="col-form-label text-muted" for="inputError">
                <i class="fa fa-info-circle"></i> Content *
              </label>
              <textarea id="txt_content" name="txt_content" required></textarea>
              <!-- <button type="submit" class="btn btn-default btn-sm">
                <i class="fa fa-paper-plane mr-1"></i> Send Mail
              </button> -->

              <hr>
              <div class="card shadow-none">
                <div class="card-header p-0">
                  <label class="col-form-label text-muted" for="inputError">
                    <i class="fa fa-info-circle"></i> Possible Subtitutions 
                  </label>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <div class="card-body p-0" style="display: block;">
                  __salutation__<br>
                  __first_name__<br>
                  __last_name__<br>
                </div>
              </div>
            </form>

          </div>
          <div class="modal-footer modal-footer--sticky">
            <button type="reset" class="btn btn-secondary">clear</button>
            <button type="submit" class="btn btn-primary" form="form_emailTemplate">
              <i class="fa fa-save mr-1"></i> Save Template 
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
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/js/select2.full.min.js"></script>

<!-- Custom Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/tools/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('#nav_tools').parent('li').addClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_tools').addClass('active'); // menu
    $('#nav_emailTemplate').addClass('active');  // sub-menu

    //topNav icon & label

    let topNav = `<i class="fas fa-tools mr-2"></i>
                  <b>TOOLS</b>`;
    $('#lnk_topNav').html(topNav);

    //methods

    EMAIL_TEMPLATE.loadCategories('tbl','#tbl_categories');
    EMAIL_TEMPLATE.loadTemplates();

    $('#form_category').on('submit',function(e){
      e.preventDefault();
      EMAIL_TEMPLATE.addCategory(this);
    });

    $('#lnk_createTemplate').on('click',function(){
      EMAIL_TEMPLATE.loadCategories('slc','#slc_category');
      $('#txt_content').summernote({
        toolbar: [
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontname','fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']]
        ],
        height: 300
      });
      $('#modal_createTemplate').modal('show');
    });

    $('#btn_createTemplate').on('click',function(){
      EMAIL_TEMPLATE.loadCategories('slc','#slc_category');
      $('#txt_content').summernote({
        toolbar: [
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontname','fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']]
        ],
        height: 300
      });
      $('#modal_createTemplate').modal('show');
    });

    $('#form_emailTemplate').on('submit',function(e){
      e.preventDefault();
      EMAIL_TEMPLATE.addTemplate(this);
    });

    $('.select2').select2();

    
    

    // test codes

    

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

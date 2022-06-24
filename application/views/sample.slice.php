  @extends('template.layout')

  @section('page_title',$pageTitle)



  @section('custom_styles')

  <style type="text/css">
    /*INTERNAL STYLES*/
    
  </style>

  @endsection



  @section('page_content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header pt-1 pb-1">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h6 class="mt-1">Contacts > <small>All</small></h6>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <div class="float-sm-right">
              <button type="button" class="btn btn-default btn-sm"><i class="fa fa-plus mr-1"></i> Add Contact</button>
              <button type="button" class="btn btn-default btn-sm"><i class="fa fa-upload mr-1"></i> Import</button>
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
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <br>
                <table id="myTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Contact Number</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Name</td>
                      <td>Address</td>
                      <td>Contact Number</td>
                    </tr>
                    <tr>
                      <td>Name</td>
                      <td>Address</td>
                      <td>Contact Number</td>
                    </tr>
                    <tr>
                      <td>Name</td>
                      <td>Address</td>
                      <td>Contact Number</td>
                    </tr>
                  </tbody>
                </table>

                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>

                <p class="card-text">
                  Some quick example text to build on the card title and make up the bulk of the card's
                  content.
                </p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
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

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Special title treatment</h6>

                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>

                <p class="card-text">
                  Some quick example text to build on the card title and make up the bulk of the card's
                  content.
                </p>

                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>

                <p class="card-text">
                  Some quick example text to build on the card title and make up the bulk of the card's
                  content.
                </p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Special title treatment</h6>

                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-xs btn-primary ">Go somewhere</a>
                <button type="button" class="btn btn-block btn-default btn-sm">Default</button>
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Special title treatment</h6>

                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer pt-2 pb-2">
    <!-- <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div> -->
    <center>
      <button type="button" class="btn btn-info btn-sm"><i class="fa fa-save mr-1"></i> Save</button>
      <button type="button" class="btn btn-default btn-sm"><i class="fa fa-times mr-1"></i> Cancel</button>
    </center>
  </footer>

  @endsection



  @section('custom_scripts')

  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/backend_custom_scripts.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      //jQuery Events
      MODULENAME.testFunc();

      $('#summernote').summernote({height: 300});

      $(document).ready( function () {
        $('#myTable').DataTable();
      } );

      $('body').addClass('layout-footer-fixed');
      // $('body').removeClass('layout-footer-fixed');

      $('#form_email').on('submit',function(e){
        e.preventDefault();

        let formData = new FormData(this);
        $.ajax({
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

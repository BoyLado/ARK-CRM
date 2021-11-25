@extends('template.layout')

@section('page_title',$pageTitle)



@section('custom_styles')

<style type="text/css">
	/*INTERNAL STYLES*/

</style>

@endsection



@section('page_content')

<div id="div_pageContent">
	<div class="row py-3">
	    <div class="col-3 order-2" id="sticky-sidebar">
	        <div class="sticky-top">
	            <div class="nav flex-column">
	            	<h4 class="text-muted">Page Content</h4>
	                <a href="#templateStructure" class="nav-link">Template Structure</a>
	                <a href="#commonLibraries" class="nav-link">Common Libraries</a>
	                <a href="https://github.com/BoyLado/ci-template" target="_blank" class="nav-link">Download Template</a>
	                

	                <h4 class="text-muted">Source Links</h4>
	                <a href="https://github.com/GustMartins/Slice-Library" target="_blank" class="nav-link">PHP Slice Library</a>
	                <a href="https://phpspreadsheet.readthedocs.io/en/latest/" target="_blank" class="nav-link">PHP Spreadsheet Library</a>
	                <a href="https://jquery.com/" target="_blank" class="nav-link">JQuery</a>
	                <a href="https://getbootstrap.com/docs/5.0/getting-started/introduction/" target="_blank" class="nav-link">Bootstrap 4</a>
	            </div>
	        </div>
	    </div>
	    <div class="col" id="main">
	        <h4 class="text-muted">Captivate Template</h4>
	        <hr>
	        <h5 id="templateStructure" class="text-primary">Template Structure</h5> 
	        <h6 class="text-muted">[ <code>application</code> <small>folder</small> ]</h6>
	        <img src="<?php echo base_url(); ?>assets/img/navigation.png" class="rounded img-thumbnail" alt="Navigation Controller">
	        <p></p>
	        <img src="<?php echo base_url(); ?>assets/img/layout.png" class="rounded img-thumbnail" alt="Navigation Controller">
	        <p></p>

	        <h6 class="text-muted">[ <code>assets</code> <small>folder</small> ]</h6>
	        <img src="<?php echo base_url(); ?>assets/img/assets.png" class="rounded img-thumbnail" alt="Navigation Controller">
	        <p></p>

	        <hr>

	        <h5 id="commonLibraries" class="text-primary">Common Libraries</h5>
	        
			<div class="card">
			  	<div class="card-body">
			    	<code>composer require phpoffice/phpspreadsheet</code>
			  	</div>
			</div>
	        
	        <br>
	    </div>
	</div>
</div>

@endsection



@section('custom_scripts')

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/backend_custom_scripts.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
    //jQuery Events
    MODULENAME.testFunc();
	});
</script>

@endsection
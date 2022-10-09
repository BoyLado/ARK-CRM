$(document).ready(function(){
	GLOBAL.loadProfile();
});

const GLOBAL = (function(){

  let thisGlobal = {};

  let baseUrl = $('#txt_baseUrl').val();

  thisGlobal.loadProfile = function()
  {
  	$.ajax({
  	  /* UserController->loadProfile() */
  	  url : `${baseUrl}/load-profile`,
  	  method : 'get',
  	  dataType: 'json',
  	  success : function(data)
  	  {
  	    console.log(data);
  	    $('#lbl_thisUserCompleteName1').html(data['complete_name']);
  	    $('#lbl_thisUserCompleteName2').html(data['complete_name']);
  	    $('#img_thisUserProfilePicture').prop('src',`${baseUrl}/public/assets/uploads/img/${data['picture']}`);
  	  }
  	});
  }

  return thisGlobal;

})();
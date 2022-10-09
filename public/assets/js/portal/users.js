let baseUrl = $('#txt_baseUrl').val();

const USERS = (function(){

	let thisUsers = {};

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisUsers.loadUsers = function()
  {
		$.ajax({
			/* UserController->loadUsers() */
		  url : `${baseUrl}/load-users`,
		  method : 'get',
		  dataType: 'json',
		  success : function(data)
		  {
		    console.log(data);
		    let tbody = '';
		    data.forEach(function(value,key){
		    	let userStatus = (value['user_status'] == 1)? '<span class="text-green">Active</span>' : '<span class="text-red">Inactive</span>';
		    	tbody += `<tr>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1">${value['first_name']}</td>
                      <td class="p-1">${value['last_name']}</td>
                      <td class="p-1">${value['user_email']}</td>
                      <td class="p-1 text-center">${userStatus}</td>
                      <td class="p-1 text-center">
                        <a href="javascript:void(0)" onclick="CONTACTS.selectContact(${value['id']})" class="mr-2">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="CONTACTS.removeContact(${value['id']})">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                    </tr>`;
		    });

		    $('#tbl_users').DataTable().destroy();
		    $('#tbl_users tbody').html(tbody);
		    $('#tbl_users').DataTable({
		    	"responsive": true,
		    	"columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            { responsivePriority: 10001, targets: 0 }
	        ]
		    });
		  }
		});
  }

  thisUsers.loadPendingInvites = function()
  {
		$.ajax({
			/* UserController->loadUsers() */
		  url : `${baseUrl}/load-pending-invites`,
		  method : 'get',
		  dataType: 'json',
		  success : function(data)
		  {
		    console.log(data);
		    let tbody = '';
		    data.forEach(function(value,key){
		    	tbody += `<tr>
	                    <td class="p-2">${value['user_email']}</td>
	                    <td class="p-2" width="40">
	                      <a href="#">
	                        <i class="fa fa-trash"></i>
	                      </a>
	                    </td>
	                  </tr>`;
		    });

		    if(tbody == '')
		    {
		    	tbody = '<tr><td><center>Empty!</center></td></tr>';
		    }

		    $('#tbl_invites tbody').html(tbody);
		  }
		});
  }

  thisUsers.inviteNewUser = function(thisForm)
  {
  	let formData = new FormData(thisForm);

  	$('#btn_submitInvitation').text('Please wait...');
  	$('#btn_submitInvitation').prop('disabled',true);

  	$.ajax({
  		/* UserController->inviteNewUser() */
  	  url : `${baseUrl}/invite-new-user`,
  	  method : 'post',
  	  dataType: 'json',
  	  processData: false, // important
  	  contentType: false, // important
  	  data : formData,
  	  success : function(result)
  	  {
  	    if(result == "Success")
        {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>Invitation sent, please wait...',
		      });
          $('#modal_inviteNewUser').modal('hide');
          setTimeout(function(){
            window.location.replace(`${baseUrl}/users`);
          }, 1000);
        }
        else
        {
          Toast.fire({
		        icon: 'error',
		        title: result,
		      });
        }
  	    $('#btn_submitInvitation').text('Submit Invitation');
  	    $('#btn_submitInvitation').prop('disabled',false);
  	  }
  	});
  }

	return thisUsers;

})();
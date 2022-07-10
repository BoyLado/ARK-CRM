let baseUrl = $('#txt_baseUrl').val();

const CONTACTS = (function(){

	let thisContacts = {};

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  //test code for uploading pdf
  thisContacts.uploadPdf = function(thisForm)
  {
		let formData = new FormData(thisForm);
		$.ajax({
			/* ContactController->uploadPdf() */
		  url : `${baseUrl}upload-pdf`,
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
  }

	thisContacts.loadContacts = function()
	{
		$.ajax({
			/* ContactController->loadContacts() */
		  url : `${baseUrl}load-contacts`,
		  method : 'get',
		  dataType: 'json',
		  success : function(data)
		  {
		    console.log(data);
		    let tbody = '';
		    data.forEach(function(value,key){
		    	tbody += `<tr>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1">${value['first_name']}</td>
                      <td class="p-1">${value['last_name']}</td>
                      <td class="p-1">Leader</td>
                      <td class="p-1">Fujitsu</td>
                      <td class="p-1">${value['primary_email']}</td>
                      <td class="p-1">Juan</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="CONTACTS.selectContact(${value['id']})" class="mr-2">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="CONTACTS.removeContact(${value['id']})">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                    </tr>`;
		    });

		    $('#tbl_contacts').DataTable().destroy();
		    $('#tbl_contacts tbody').html(tbody);
		    $('#tbl_contacts').DataTable({
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

	thisContacts.addContact = function(thisForm)
	{
		let formData = new FormData(thisForm);
		$.ajax({
			/* ContactController->addContact() */
		  url : `${baseUrl}add-contact`,
		  method : 'post',
		  dataType: 'json',
		  processData: false, // important
		  contentType: false, // important
		  data : formData,
		  success : function(result)
		  {
		    console.log(result);
		    $('#modal_addContacts').modal('hide');
		    if(result == 'Success')
		    {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>New contact added successfully.',
		      });
		    }
		    else
		    {
          Toast.fire({
		        icon: 'error',
		        title: 'Error! <br>Database error!'
		      });
		    }
		    CONTACTS.loadContacts();
		  }
		});
	}

	thisContacts.selectContact = function(contactId)
	{
    $('#lbl_stateContact span').text('Edit Contact');
    $('#lbl_stateContact i').removeClass('fa-plus');
    $('#lbl_stateContact i').addClass('fa-pen');
		$('#modal_addContacts').modal('show');
		$('#txt_contactId').val(contactId);
	}

	return thisContacts;

})();
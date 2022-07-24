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
		  url : `${baseUrl}marketing/load-contacts`,
		  method : 'get',
		  dataType: 'json',
		  success : function(data)
		  {
		    console.log(data);
		    let tbody = '';
		    data.forEach(function(value,key){
		    	tbody += `<tr>
		    							<td class="p-1">${value['id']}</td>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1"><a href="${baseUrl}contact-preview/${value['id']}">${value['first_name']}</a></td>
                      <td class="p-1"><a href="${baseUrl}contact-preview/${value['id']}">${value['last_name']}</a></td>
                      <td class="p-1">Leader</td>
                      <td class="p-1"><a href="${baseUrl}organization-preview/${value['organization_id']}">${value['organization_name']}</a></td>
                      <td class="p-1"><a href="javascript:void(0)" onclick="CONTACTS.selectContactEmail(${value['id']},'${value['primary_email']}')">${value['primary_email']}</a></td>
                      <td class="p-1">Juan</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="CONTACTS.selectContact('edit',${value['id']})" class="mr-2">
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
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 10001, targets: 1 },
            {
              "targets": [0],
              "visible": false,
              "searchable": false
            }
	        ],
	        "order": [[ 0, "desc" ]]
		    });
		  }
		});
	}

	thisContacts.loadUsers = function(elemId)
	{
	  $.ajax({
	    /* UserController->loadUsers() */
	    url : `${baseUrl}load-users`,
	    method : 'get',
	    dataType: 'json',
	    success : function(data)
	    {
	      console.log(data);
	      let options = '<option value="">--Select user--</option>';
	      data.forEach(function(value,key){
	        options += `<option value="${value['user_id']}">${value['salutation']} ${value['first_name']} ${value['last_name']}</option>`;
	      });
	      $(elemId[0]).html(options);
	      $(elemId[1]).html(options);
	    }
	  });
	}

	thisContacts.loadOrganizations = function(elemId)
	{
	  $.ajax({
	    /* OrganizationController->loadOrganizations() */
	    url : `${baseUrl}marketing/load-organizations`,
	    method : 'get',
	    dataType: 'json',
	    success : function(data)
	    {
	      console.log(data);
        let options = '<option value="">--Select organization--</option>';
        data.forEach(function(value,key){
          options += `<option value="${value['id']}">${value['organization_name']}</option>`;
        });
        $(elemId).html(options);
	    }
	  });
	}

	thisContacts.addContact = function(thisForm)
	{
		let formData = new FormData(thisForm);

		formData.set("chk_doNotCall", ($('#chk_doNotCall').is(':checked'))? 1 : 0);

		$.ajax({
			/* ContactController->addContact() */
		  url : `${baseUrl}marketing/add-contact`,
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
		      setTimeout(function(){
            window.location.replace(`${baseUrl}contacts`);
          }, 1000);
		    }
		    else
		    {
          Toast.fire({
		        icon: 'error',
		        title: 'Error! <br>Database error!'
		      });
		    }
		  }
		});
	}

	thisContacts.selectContact = function(action, contactId)
	{
		$.ajax({
			/* ContactController->selectContact() */
		  url : `${baseUrl}marketing/select-contact`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
	    	if(action == 'edit')
	    	{
	        $('#lbl_stateContact span').text('Edit Contact');
	        $('#lbl_stateContact i').removeClass('fa-plus');
	        $('#lbl_stateContact i').addClass('fa-pen');
	    		$('#modal_addContacts').modal('show');
	    		$('#txt_contactId').val(contactId);
	    	}
	    	else if(action == 'load')
	    	{
	    		let contactName = `${data['first_name']} ${data['last_name']}`;
	    		$('#lnk_contact').text(contactName);
	    		$('#lnk_contact').attr('href',`${baseUrl}contact-preview/${data['id']}`);

	    		let contactFullName = `${data['salutation']} ${data['first_name']} ${data['last_name']}`;
	    		$('#lbl_contactName').text(contactFullName);

	    		let contactPosition = (data['position'] != null)? data['position'] : '---';
	    		$('#lbl_contactPosition').text(contactPosition);

	    		let contactEmail = (data['primary_email'] != null)? data['primary_email'] : '---';
	    		$('#lbl_contactEmail').text(contactEmail);
	    	}
		  }
		});
	}

	thisContacts.selectContactSummary = function(contactId)
	{
		$.ajax({
			/* ContactController->selectContactSummary() */
		  url : `${baseUrl}marketing/select-contact-summary`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Summary
    		$('#lbl_firstName').text(data['first_name']);
    		$('#lbl_lastName').text(data['last_name']);
    		$('#lbl_position').text(data['position']);
    		// $('#lbl_organizationName').text(data['organization_name']);
    		let organizationName = `<a href="${baseUrl}organization-preview/${data['organization_id']}" target="_blank">
    															${data['organization_name']}
    														</a>`;
    		$('#lbl_organizationName').html(organizationName);
    		$('#lbl_assignedTo').text(data['assigned_to']);
    		$('#lbl_mailingCity').text(data['mailing_city']);
    		$('#lbl_mailingCountry').text(data['mailing_country']);
		  }
		});
	}

	thisContacts.selectContactDetails = function(contactId)
	{
		$.ajax({
			/* ContactController->selectContactDetails() */
		  url : `${baseUrl}marketing/select-contact-details`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Details
    		
		  }
		});
	}

	thisContacts.selectContactEmail = function(contactId, contactEmail)
	{
		CONTACTS.loadEmailTemplates();
		$('#txt_contactId').val(contactId);
		$('#txt_to').val(contactEmail);
		$('#txt_content').summernote(summernoteConfig);
		$('#modal_sendContactEmail').modal('show');
	}


	thisContacts.loadEmailTemplates = function()
	{
		$.ajax({
		  /* EmailTemplateController->loadTemplates() */
		  url : `${baseUrl}tools/load-templates`,
		  method : 'get',
		  dataType: 'json',
		  success : function(data)
		  {
		    console.log(data);
		    let options = '<option value="">--Optional--</option>';
		    data.forEach(function(value,key){
		      options += `<option value="${value['id']}">${value['template_name']}</option>`;
		    });

		    $('#slc_emailTemplate').html(options);
		  }
		});
	}

	thisContacts.selectEmailTemplate = function(contactId,templateId)
	{
		$.ajax({
		  /* ContactController->selectEmailTemplate() */
		  url : `${baseUrl}marketing/select-email-template`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId, templateId : templateId},
		  success : function(data)
		  {
		    console.log(data);
		    $('#txt_subject').val(data['template_subject']);
		    $('#txt_content').summernote('destroy');
		    $('#txt_content').val(data['template_content']);
		    $('#txt_content').summernote(summernoteConfig);
		  }
		});
	}

	thisContacts.sendContactEmail = function(thisForm)
	{
		let formData = new FormData(thisForm);

		formData.set("txt_contactId", $('#txt_contactId').val());

		if($('#chk_unsubscribe').is(':checked'))
		{
			formData.set("chk_unsubscribe", 1);
		}

		$('#btn_sendContactEmail').html('<i class="fa fa-paper-plane mr-1"></i> Sending...');
		$('#btn_sendContactEmail').prop('disabled',true);

		$.ajax({
			/* ContactController->sendContactEmail() */
		  url : `${baseUrl}marketing/send-contact-email`,
		  method : 'post',
		  dataType: 'json',
		  processData: false, // important
		  contentType: false, // important
		  data : formData,
		  success : function(result)
		  {
		    console.log(result);
		    $('#modal_sendContactEmail').modal('hide');
		    if(result == 'Success')
		    {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>Message sent successfully.',
		      });
		    }
		    else
		    {
          Toast.fire({
		        icon: 'error',
		        title: 'Error! <br>Database error!'
		      });
		    }
		    $('#btn_sendContactEmail').html('<i class="fa fa-paper-plane mr-1"></i> Send Email');
		    $('#btn_sendContactEmail').prop('disabled',false);
		  }
		});
	}

	return thisContacts;

})();
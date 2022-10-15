$(document).ready(function(){

});

let baseUrl = $('#txt_baseUrl').val();

const CONTACTS = (function(){

	let thisContacts = {};

	let _arrSelectedDocuments = []; //global variable
	let _arrSelectedCampaigns = []; //global variable

	let _arrEmptyValues = [null,""];

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
		  url : `${baseUrl}/upload-pdf`,
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
		  url : `${baseUrl}/marketing/load-contacts`,
		  method : 'get',
		  dataType: 'json',
		  success : function(data)
		  {
		    console.log(data);
		    let tbody = '';
		    data.forEach(function(value,key){
		    	let organizationName = (_arrEmptyValues.includes(value['organization_id']))? '---' : `<a href="${baseUrl}/organization-preview/${value['organization_id']}">${value['organization_name']}</a>`;
		    	tbody += `<tr>
		    							<td class="p-1">${value['id']}</td>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['id']}">${value['first_name']}</a></td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['id']}">${value['last_name']}</a></td>
                      <td class="p-1">Leader</td>
                      <td class="p-1">${organizationName}</td>
                      <td class="p-1"><a href="javascript:void(0)" onclick="CONTACTS.selectContactEmail(${value['id']},'${value['primary_email']}')">${value['primary_email']}</a></td>
                      <td class="p-1">Juan</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="CONTACTS.selectContact('edit',${value['id']})" class="mr-2">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="CONTACTS.removeContact(${value['id']})" class="text-red">
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

	thisContacts.loadUsers = function(elemId, userId = '')
	{
	  $.ajax({
	    /* UserController->loadUsers() */
	    url : `${baseUrl}/load-users`,
	    method : 'get',
	    dataType: 'json',
	    success : function(data)
	    {
	      console.log(data);
	      let options = '<option value="">--Select user--</option>';
	      data.forEach(function(value,key){
	      	if(userId == value['user_id'])
	      	{
	      		options += `<option value="${value['user_id']}" selected>${value['salutation']} ${value['first_name']} ${value['last_name']}</option>`;
	      	}
	      	else
	      	{
	      		options += `<option value="${value['user_id']}">${value['salutation']} ${value['first_name']} ${value['last_name']}</option>`;
	      	}	        
	      });
	      $(elemId).html(options);
	    }
	  });
	}

	thisContacts.loadOrganizations = function(elemId, organizationId = '')
	{
	  $.ajax({
	    /* OrganizationController->loadOrganizations() */
	    url : `${baseUrl}/marketing/load-organizations`,
	    method : 'get',
	    dataType: 'json',
	    success : function(data)
	    {
	      console.log(data);
        let options = '<option value="">--Select organization--</option>';
        data.forEach(function(value,key){
        	if(organizationId == value['id'])
        	{
        		options += `<option value="${value['id']}" selected>${value['organization_name']}</option>`;
        	}
        	else
        	{
        		options += `<option value="${value['id']}">${value['organization_name']}</option>`;
        	}
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
		  url : `${baseUrl}/marketing/add-contact`,
		  method : 'post',
		  dataType: 'json',
		  processData: false, // important
		  contentType: false, // important
		  data : formData,
		  success : function(result)
		  {
		    console.log(result);
		    $('#modal_contact').modal('hide');
		    if(result == 'Success')
		    {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>New contact added successfully.',
		      });
		      setTimeout(function(){
            window.location.replace(`${baseUrl}/contacts`);
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
		CONTACTS.loadUsers(['#slc_reportsTo','#slc_assignedTo']);
		$.ajax({
			/* ContactController->selectContact() */
		  url : `${baseUrl}/marketing/select-contact`,
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
	    		$('#modal_contact').modal('show');
	    		$('#txt_contactId').val(contactId);

	    		$('#slc_salutation').val(data['salutation']);
	    		$('#txt_firstName').val(data['first_name']);
	    		$('#txt_lastName').val(data['last_name']);
	    		$('#txt_position').val(data['position']);
	    		CONTACTS.loadOrganizations('#slc_companyName', data['organization_id']);
	    		$('#txt_primaryEmail').val(data['primary_email']);
	    		$('#txt_secondaryEmail').val(data['secondary_email']);
	    		$('#txt_birthDate').val(data['date_of_birth']);
	    		$('#slc_introLetter').val(data['intro_letter']);
	    		$('#txt_officePhone').val(data['office_phone']);
	    		$('#txt_mobilePhone').val(data['mobile_phone']);
	    		$('#txt_homePhone').val(data['home_phone']);
	    		$('#txt_secondaryPhone').val(data['secondary_email']);
	    		$('#txt_fax').val(data['fax']);
	    		$('#chk_doNotCall').prop('checked',(data['do_not_call'] == 1)? true : false);
	    		$('#txt_linkedinUrl').val(data['linkedin_url']);
	    		$('#txt_twitterUrl').val(data['twitter_url']);
	    		$('#txt_facebookUrl').val(data['facebook_url']);
	    		$('#txt_instagramUrl').val(data['instagram_url']);
	    		$('#slc_leadSource').val(data['lead_source']);
	    		$('#txt_department').val(data['department']);
	    		CONTACTS.loadUsers('#slc_reportsTo', data['reports_to']);
       		CONTACTS.loadUsers('#slc_assignedTo', data['assigned_to']);
	    		$('#slc_emailOptOut').val(data['email_opt_out']);

	    		$('#txt_mailingStreet').val(data['mailing_street']);
	    		$('#txt_mailingPOBox').val(data['mailing_po_box']);
	    		$('#txt_mailingCity').val(data['mailing_city']);
	    		$('#txt_mailingState').val(data['mailing_state']);
	    		$('#txt_mailingZip').val(data['mailing_zip']);
	    		$('#txt_mailingCountry').val(data['mailing_country']);
	    		$('#txt_otherStreet').val(data['other_street']);
	    		$('#txt_otherPOBox').val(data['other_po_box']);
	    		$('#txt_otherCity').val(data['other_city']);
	    		$('#txt_otherState').val(data['other_state']);
	    		$('#txt_otherZip').val(data['other_zip']);
	    		$('#txt_otherCountry').val(data['other_country']);

	    		$('#txt_description').val(data['description']);
	    	}
	    	else if(action == 'load')
	    	{
	    		let contactName = `${data['first_name']} ${data['last_name']}`;
	    		$('#lnk_contact').text(contactName);
	    		$('#lnk_contact').attr('href',`${baseUrl}/contact-preview/${data['id']}`);

	    		let contactFullName = `${data['salutation']} ${data['first_name']} ${data['last_name']}`;
	    		$('#lbl_contactName').text(contactFullName);
   		
	    		let contactPosition = (_arrEmptyValues.includes(data['position']))? '---' : data['position'];
	    		$('#lbl_contactPosition').text(contactPosition);

	    		let contactEmail = (_arrEmptyValues.includes(data['primary_email']))? '---' : data['primary_email'];
	    		$('#lbl_contactEmail').text(contactEmail);
	    	}
		  }
		});
	}

	thisContacts.editContact = function(thisForm)
	{
		let formData = new FormData(thisForm);

		formData.set("txt_contactId", $('#txt_contactId').val());
		formData.set("chk_doNotCall", ($('#chk_doNotCall').is(':checked'))? 1 : 0);

		$.ajax({
			/* ContactController->editContact() */
		  url : `${baseUrl}/marketing/edit-contact`,
		  method : 'post',
		  dataType: 'json',
		  processData: false, // important
		  contentType: false, // important
		  data : formData,
		  success : function(result)
		  {
		    console.log(result);
		    $('#modal_contact').modal('hide');
		    if(result == 'Success')
		    {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>Contact updated successfully.',
		      });
		      setTimeout(function(){
            window.location.replace(`${baseUrl}/contact-preview/${$('#txt_contactId').val()}`);
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

	thisContacts.removeContact = function(contactId)
	{
		if(confirm('Please Confirm'))
		{
			let formData = new FormData();

			formData.set("contactId", contactId);

			$.ajax({
				/* ContactController->removeContact() */
			  url : `${baseUrl}/marketing/remove-contact`,
			  method : 'post',
			  dataType: 'json',
			  processData: false, // important
			  contentType: false, // important
			  data : formData,
			  success : function(result)
			  {
			    if(result == 'Success')
			    {
	          Toast.fire({
			        icon: 'success',
			        title: 'Success! <br>Contact removed successfully.',
			      });
			      setTimeout(function(){
	            window.location.replace(`${baseUrl}/contacts`);
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
	}

	//start of details

	//summary
	thisContacts.loadContactSummary = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactSummary() */
		  url : `${baseUrl}/marketing/load-contact-summary`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Summary
    		$('#lbl_firstName').text((_arrEmptyValues.includes(data['first_name']))? '---' : data['first_name']);
    		$('#lbl_lastName').text((_arrEmptyValues.includes(data['last_name']))? '---' : data['last_name']);
    		$('#lbl_position').text((_arrEmptyValues.includes(data['position']))? '---' : data['position']);
    		let organizationName = `<a href="${baseUrl}/organization-preview/${data['organization_id']}" target="_blank">
    															${data['organization_name']}
    														</a>`;
    		$('#lbl_organizationName').html(organizationName);
    		$('#lbl_assignedTo').text((_arrEmptyValues.includes(data['assigned_to']))? '---' : data['assigned_to']);
    		$('#lbl_mailingCity').text((_arrEmptyValues.includes(data['mailing_city']))? '---' : data['mailing_city']);
    		$('#lbl_mailingCountry').text((_arrEmptyValues.includes(data['mailing_country']))? '---' : data['mailing_country']);
		  }
		});
	}

	//details
	thisContacts.loadContactDetails = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactDetails() */
		  url : `${baseUrl}/marketing/load-contact-details`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Details
    		let orgName = (_arrEmptyValues.includes(data['organization_id']))? '---' : `<a href="${baseUrl}/organization-preview/${data['organization_id']}">${data['organization_name']}</a>`;
    		
    		$('#div_details table:eq(0) tbody tr td:eq(1)').html(`${data['salutation']} ${data['first_name']}`);
    		$('#div_details table:eq(1) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['last_name']))? '---' : data['last_name']);
    		$('#div_details table:eq(2) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['position']))? '---' : data['position']);
    		$('#div_details table:eq(3) tbody tr td:eq(1)').html(orgName);
    		$('#div_details table:eq(4) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['primary_email']))? '---' : data['primary_email']);
    		$('#div_details table:eq(5) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['secondary_email']))? '---' : data['secondary_email']);
    		$('#div_details table:eq(6) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['date_of_birth']))? '---' : data['date_of_birth']);
    		$('#div_details table:eq(7) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['intro_letter']))? '---' : data['intro_letter']);
    		$('#div_details table:eq(8) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['office_phone']))? '---' : data['office_phone']);
    		$('#div_details table:eq(9) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['mobile_phone']))? '---' : data['mobile_phone']);
    		$('#div_details table:eq(10) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['home_phone']))? '---' : data['home_phone']);
    		$('#div_details table:eq(11) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['secondary_phone']))? '---' : data['secondary_phone']);
    		$('#div_details table:eq(12) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['fax']))? '---' : data['fax']);
    		$('#div_details table:eq(13) tbody tr td:eq(1)').html((data['do_not_call'] == 0)? 'No':'Yes');
    		$('#div_details table:eq(14) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['linkedin_url']))? '---' : data['linkedin_url']);
    		$('#div_details table:eq(15) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['twitter_url']))? '---' : data['twitter_url']);
    		$('#div_details table:eq(16) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['facebook_url']))? '---' : data['facebook_url']);
    		$('#div_details table:eq(17) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['instagram_url']))? '---' : data['instagram_url']);
    		$('#div_details table:eq(18) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['lead_source']))? '---' : data['lead_source']);
    		$('#div_details table:eq(19) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['department']))? '---' : data['department']);
    		$('#div_details table:eq(20) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['reports_to_name']))? '---' : data['reports_to_name']);
    		$('#div_details table:eq(21) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['assigned_to_name']))? '---' : data['assigned_to_name']);
    		$('#div_details table:eq(22) tbody tr td:eq(1)').html((data['email_opt_out'] == 0)? 'No':'Yes');

    		$('#div_details table:eq(23) tbody tr:eq(0) td:eq(1)').html((_arrEmptyValues.includes(data['mailing_street']))? '---' : data['mailing_street']);
    		$('#div_details table:eq(23) tbody tr:eq(1) td:eq(1)').html((_arrEmptyValues.includes(data['mailing_po_box']))? '---' : data['mailing_po_box']);
    		$('#div_details table:eq(23) tbody tr:eq(2) td:eq(1)').html((_arrEmptyValues.includes(data['mailing_city']))? '---' : data['mailing_city']);
    		$('#div_details table:eq(23) tbody tr:eq(3) td:eq(1)').html((_arrEmptyValues.includes(data['mailing_state']))? '---' : data['mailing_state']);
    		$('#div_details table:eq(23) tbody tr:eq(4) td:eq(1)').html((_arrEmptyValues.includes(data['mailing_zip']))? '---' : data['mailing_zip']);
    		$('#div_details table:eq(23) tbody tr:eq(5) td:eq(1)').html((_arrEmptyValues.includes(data['mailing_country']))? '---' : data['mailing_country']);

    		$('#div_details table:eq(24) tbody tr:eq(0) td:eq(1)').html((_arrEmptyValues.includes(data['other_street']))? '---' : data['other_street']);
    		$('#div_details table:eq(24) tbody tr:eq(1) td:eq(1)').html((_arrEmptyValues.includes(data['other_po_box']))? '---' : data['other_po_box']);
    		$('#div_details table:eq(24) tbody tr:eq(2) td:eq(1)').html((_arrEmptyValues.includes(data['other_city']))? '---' : data['other_city']);
    		$('#div_details table:eq(24) tbody tr:eq(3) td:eq(1)').html((_arrEmptyValues.includes(data['other_state']))? '---' : data['other_state']);
    		$('#div_details table:eq(24) tbody tr:eq(4) td:eq(1)').html((_arrEmptyValues.includes(data['other_zip']))? '---' : data['other_zip']);
    		$('#div_details table:eq(24) tbody tr:eq(5) td:eq(1)').html((_arrEmptyValues.includes(data['other_country']))? '---' : data['other_country']);

    		$('#div_details table:eq(25) tbody tr td').html((_arrEmptyValues.includes(data['description']))? '---' : data['description']);
		  }
		});
	}

	//Activities
	thisContacts.loadContactActivities = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactActivities() */
		  url : `${baseUrl}/marketing/load-contact-activities`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Activities
		    let tbody = '';
		    let count = 0;
		    data.forEach(function(value,key){
		    	tbody += `<tr>
	                    <td class="p-1">${value['id']}</td>
	                    <td class="p-1 pl-4">${value['sent_by_name']}</td>
	                    <td class="p-1">${value['email_subject']}</td>
	                    <td class="p-1">${value['sent_to_name']}</td>
	                    <td class="p-1">${value['date_sent']}</td>
	                    <td class="p-1">${value['time_sent']}</td>
	                    <td class="p-1">${value['email_status']}</td>
	                    <td class="p-1">Action</td>
	                  </tr>`;
	        count++;
		    });

		    $('#tbl_contactActivities').DataTable().destroy();
		    $('#tbl_contactActivities tbody').html(tbody);
		    $('#tbl_contactActivities').DataTable({
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

		    if(count > 0)
		    {
		      $('#lbl_activityCount').prop('hidden',false);
		      $('#lbl_activityCount').text(count);
		    }
		    else
		    {
		      $('#lbl_activityCount').prop('hidden',true);
		      $('#lbl_activityCount').text(count);
		    }
		  }
		});
	}

	//emails
	thisContacts.loadContactEmails = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactEmails() */
		  url : `${baseUrl}/marketing/load-contact-emails`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Emails
		    let tbody = '';
		    let count = 0;
		    data.forEach(function(value,key){
		    	tbody += `<tr>
	                    <td class="p-1">${value['id']}</td>
	                    <td class="p-1 pl-4">${value['sent_by_name']}</td>
	                    <td class="p-1">${value['email_subject']}</td>
	                    <td class="p-1">${value['sent_to_name']}</td>
	                    <td class="p-1">${value['date_sent']}</td>
	                    <td class="p-1">${value['time_sent']}</td>
	                    <td class="p-1">${value['email_status']}</td>
	                    <td class="p-1">Action</td>
	                  </tr>`;
	        count++;
		    });

		    $('#tbl_contactEmails').DataTable().destroy();
		    $('#tbl_contactEmails tbody').html(tbody);
		    $('#tbl_contactEmails').DataTable({
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

		    if(count > 0)
		    {
		      $('#lbl_emailCount').prop('hidden',false);
		      $('#lbl_emailCount').text(count);
		    }
		    else
		    {
		      $('#lbl_emailCount').prop('hidden',true);
		      $('#lbl_emailCount').text(count);
		    }
		  }
		});
	}

	//documents
	thisContacts.loadContactDocuments = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactDocuments() */
		  url : `${baseUrl}/marketing/load-contact-documents`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Documents
		    let tbody = '';
		    let count = 0;
		    data.forEach(function(value,key){
		    	let fileLink = '';
		    	if(value['file_url'] != null)
		    	{
		    		fileLink = `<a href="${value['file_url']}" target="_blank">${value['file_url'].substring(0, 20)}...</a>`;
		    	}
		    	else
		    	{
		    		fileLink = `<a href="${baseUrl}assets/uploads/documents/${value['file_name']}" target="_blank">${value['file_name'].substring(0, 20)}...</a>`;
		    	}
		    	tbody += `<tr>
	                    <td class="p-1">${value['id']}</td>
	                    <td class="p-1 pl-4">${value['title']}</td>
	                    <td class="p-1">${fileLink}</td>
	                    <td class="p-1">${value['created_date']}</td>
	                    <td class="p-1">${value['assigned_to_name']}</td>
	                    <td class="p-1">${(_arrEmptyValues.includes(value['download_count']))? 0 : value['download_count']}</td>
	                    <td class="p-1">
	                    	<a href="javascript:void(0)" onclick="alert('Coming Soon')" class="mr-2" title="Download">
	                    	  <i class="fa fa-download"></i>
	                    	</a>
	                    	<a href="javascript:void(0)" onclick="CONTACTS.unlinkContactDocument(${value['id']})" title="Unlink">
	                    	  <i class="fa fa-unlink"></i>
	                    	</a>
	                    </td>
	                  </tr>`;
	        count++;
		    });

		    $('#tbl_contactDocuments').DataTable().destroy();
		    $('#tbl_contactDocuments tbody').html(tbody);
		    $('#tbl_contactDocuments').DataTable({
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

		    let buttons = `<button type="button" onclick="CONTACTS.selectDocumentModal(${contactId})" class="btn btn-sm btn-default"><i class="fa fa-file mr-1"></i> Select Documents</button>
		    								<button type="button" onclick="CONTACTS.addDocumentModal()" class="btn btn-sm btn-default"><i class="fa fa-plus mr-1"></i> New Document</button>`;

		    $(`#tbl_contactDocuments_length`).html(buttons);

		    if(count > 0)
		    {
		      $('#lbl_documentCount').prop('hidden',false);
		      $('#lbl_documentCount').text(count);
		    }
		    else
		    {
		      $('#lbl_documentCount').prop('hidden',true);
		      $('#lbl_documentCount').text(count);
		    }
		  }
		});
	}

	thisContacts.unlinkContactDocument = function(contactDocumentId)
	{
		if(confirm('Please confirm!'))
		{
			let formData = new FormData();

			formData.set("contactDocumentId", contactDocumentId);

			$.ajax({
				/* ContactController->unlinkContactDocument() */
			  url : `${baseUrl}/marketing/unlink-contact-document`,
			  method : 'post',
			  dataType: 'json',
			  processData: false, // important
			  contentType: false, // important
			  data : formData,
			  success : function(result)
			  {
			    console.log(result);
			    if(result == 'Success')
			    {
	          Toast.fire({
			        icon: 'success',
			        title: 'Success! <br>Document unlinked successfully.',
			      });
			      CONTACTS.loadContactDocuments($('#txt_contactId').val());
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
	}

	thisContacts.selectDocumentModal = function(contactId)
	{
		$('#modal_selectDocuments').modal('show');
		$('#btn_addSelectedDocuments').prop('disabled',true);
		_arrSelectedDocuments = [];
		CONTACTS.loadUnlinkContactDocuments(contactId);
	}

	thisContacts.loadUnlinkContactDocuments = function(contactId)
	{
		$.ajax({
			/* ContactController->loadUnlinkContactDocuments() */
		  url : `${baseUrl}/marketing/load-unlink-contact-documents`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId:contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Emails
		    let tbody = '';
		    data.forEach(function(value,key){
		    	let fileLink = '';
		    	if(value['file_url'] != null)
		    	{
		    		fileLink = `<a href="${value['file_url']}" target="_blank">${value['file_url'].substring(0, 20)}...</a>`;
		    	}
		    	else
		    	{
		    		fileLink = `<a href="${baseUrl}assets/uploads/documents/${value['file_name']}" target="_blank">${value['file_name'].substring(0, 20)}...</a>`;
		    	}
		    	tbody += `<tr>
	                    <td class="p-1 pl-4"><input type="checkbox" onchange="CONTACTS.selectDocuments(this)" value="${value['id']}"/></td>
	                    <td class="p-1 pl-4">${value['title']}</td>
	                    <td class="p-1">${fileLink}</td>
	                    <td class="p-1">${value['created_date']}</td>
	                    <td class="p-1">${value['assigned_to_name']}</td>
	                    <td class="p-1">${(_arrEmptyValues.includes(value['download_count']))? 0 : value['download_count']}</td>
	                  </tr>`;
		    });

		    $(`#tbl_allDocuments`).DataTable().destroy();
		    $(`#tbl_allDocuments tbody`).html(tbody);
		    $(`#tbl_allDocuments`).DataTable({
		    	"responsive": true,
		    	"columnDefs": [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 10001, targets: 1 }
	        ],
	        "order": [[ 0, "desc" ]]
		    });
		  }
		});
	}

	thisContacts.selectDocuments = function(thisCheckBox)
	{
		if($(thisCheckBox).is(':checked'))
		{
			_arrSelectedDocuments.push($(thisCheckBox).val());
		}
		else
		{
			let index = _arrSelectedDocuments.indexOf($(thisCheckBox).val());
			if (index > -1) 
			{
			  _arrSelectedDocuments.splice(index, 1); 
			}
		}

		$('#btn_addSelectedDocuments').prop('disabled',(_arrSelectedDocuments.length > 0)? false : true);
	}

	thisContacts.addSelectedDocuments = function()
	{
		let formData = new FormData();

		formData.set("contactId", $('#txt_contactId').val());
		formData.set("arrSelectedDocuments", _arrSelectedDocuments);

		$.ajax({
			/* ContactController->addSelectedContactDocuments() */
		  url : `${baseUrl}/marketing/add-selected-contact-documents`,
		  method : 'post',
		  dataType: 'json',
		  processData: false, // important
		  contentType: false, // important
		  data : formData,
		  success : function(result)
		  {
		    console.log(result);
		    $('#modal_selectDocuments').modal('hide');
		    if(result == 'Success')
		    {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>New document/s added successfully.',
		      });
		      CONTACTS.loadContactDocuments($('#txt_contactId').val());
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

	thisContacts.addDocumentModal = function()
	{
		$('#div_fileName').hide();
		$('#div_fileUrl').hide();
		CONTACTS.loadUsers('#slc_assignedToDocument');
		$('#modal_addDocument').modal('show');
	}

	thisContacts.addContactDocument = function(thisForm)
	{
		let formData = new FormData(thisForm);

		formData.set("txt_contactId", $('#txt_contactId').val());

		$.ajax({
			/* ContactController->addContactDocument() */
		  url : `${baseUrl}/marketing/add-contact-document`,
		  method : 'post',
		  dataType: 'json',
		  processData: false, // important
		  contentType: false, // important
		  data : formData,
		  success : function(result)
		  {
		    console.log(result);
		    $('#modal_addDocument').modal('hide');
		    if(result == 'Success')
		    {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>New document added successfully.',
		      });
		      setTimeout(function(){
            CONTACTS.loadContactDocuments($('#txt_contactId').val());
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

	//campaigns
	thisContacts.loadContactCampaigns = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactCampaigns() */
		  url : `${baseUrl}/marketing/load-contact-campaigns`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Emails
		    let tbody = '';
		    let count = 0;
		    data.forEach(function(value,key){
		    	tbody += `<tr>
	                    <td class="p-1">${value['id']}</td>
	                    <td class="p-1 pl-4">${value['campaign_name']}</td>
	                    <td class="p-1">${value['assigned_to_name']}</td>
	                    <td class="p-1">${value['campaign_status']}</td>
	                    <td class="p-1">${value['campaign_type']}</td>
	                    <td class="p-1">${value['expected_close_date']}</td>
	                    <td class="p-1">$ ${value['expected_revenue']}</td>
	                    <td class="p-1">
	                    	<a href="javascript:void(0)" onclick="alert('Coming Soon')" class="mr-2" title="Edit">
	                    	  <i class="fa fa-pen"></i>
	                    	</a>
	                    	<a href="javascript:void(0)" onclick="CONTACTS.unlinkContactCampaign(${value['id']})" title="Unlink">
	                    	  <i class="fa fa-unlink"></i>
	                    	</a>
	                    </td>
	                  </tr>`;
	        count++;
		    });

		    $(`#tbl_campaigns`).DataTable().destroy();
		    $(`#tbl_campaigns tbody`).html(tbody);
		    $(`#tbl_campaigns`).DataTable({
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

		    $(`#tbl_campaigns_length`).html(`<button type="button" onclick="CONTACTS.selectCampaignModal(${contactId})" class="btn btn-sm btn-default"><i class="fa fa-bullhorn mr-1"></i> Select Campaigns</button>`);
		  
		    if(count > 0)
		    {
		      $('#lbl_campaignCount').prop('hidden',false);
		      $('#lbl_campaignCount').text(count);
		    }
		    else
		    {
		      $('#lbl_campaignCount').prop('hidden',true);
		      $('#lbl_campaignCount').text(count);
		    }
		  }
		});
	}

	thisContacts.unlinkContactCampaign = function(contactCampaignId)
	{
		if(confirm('Please confirm!'))
		{
			let formData = new FormData();

			formData.set("contactCampaignId", contactCampaignId);

			$.ajax({
				/* ContactController->unlinkContactCampaign() */
			  url : `${baseUrl}/marketing/unlink-contact-campaign`,
			  method : 'post',
			  dataType: 'json',
			  processData: false, // important
			  contentType: false, // important
			  data : formData,
			  success : function(result)
			  {
			    console.log(result);
			    if(result == 'Success')
			    {
	          Toast.fire({
			        icon: 'success',
			        title: 'Success! <br>Campaign unlinked successfully.',
			      });
			      CONTACTS.loadContactCampaigns($('#txt_contactId').val());
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
	}

	thisContacts.selectCampaignModal = function(contactId)
	{
		$('#modal_selectCampaigns').modal('show');
		$('#btn_addSelectedCampaigns').prop('disabled',true);
		_arrSelectedCampaigns = [];
		CONTACTS.loadUnlinkContactCampaigns(contactId);
	}

	thisContacts.loadUnlinkContactCampaigns = function(contactId)
	{
		$.ajax({
			/* ContactController->loadUnlinkContactCampaigns() */
		  url : `${baseUrl}/marketing/load-unlink-contact-campaigns`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId:contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Emails
		    let tbody = '';
		    data.forEach(function(value,key){
		    	tbody += `<tr>
	                    <td class="p-1 pl-4"><input type="checkbox" onchange="CONTACTS.selectCampaigns(this)" value="${value['id']}"/></td>
	                    <td class="p-1 pl-4">${value['campaign_name']}</td>
	                    <td class="p-1">${value['assigned_to_name']}</td>
	                    <td class="p-1">${value['campaign_status']}</td>
	                    <td class="p-1">${value['campaign_type']}</td>
	                    <td class="p-1">${value['expected_close_date']}</td>
	                    <td class="p-1">$ ${value['expected_revenue']}</td>
	                  </tr>`;
		    });

		    $(`#tbl_allCampaigns`).DataTable().destroy();
		    $(`#tbl_allCampaigns tbody`).html(tbody);
		    $(`#tbl_allCampaigns`).DataTable({
		    	"responsive": true,
		    	"columnDefs": [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 10001, targets: 1 }
	        ],
	        "order": [[ 0, "desc" ]]
		    });
		  }
		});
	}

	thisContacts.selectCampaigns = function(thisCheckBox)
	{
		if($(thisCheckBox).is(':checked'))
		{
			_arrSelectedCampaigns.push($(thisCheckBox).val());
		}
		else
		{
			let index = _arrSelectedCampaigns.indexOf($(thisCheckBox).val());
			if (index > -1) 
			{
			  _arrSelectedCampaigns.splice(index, 1); 
			}
		}

		$('#btn_addSelectedCampaigns').prop('disabled',(_arrSelectedCampaigns.length > 0)? false : true);		
	}

	thisContacts.addSelectedCampaigns = function()
	{
		let formData = new FormData();

		formData.set("contactId", $('#txt_contactId').val());
		formData.set("arrSelectedCampaigns", _arrSelectedCampaigns);

		$.ajax({
			/* ContactController->addSelectedContactCampaigns() */
		  url : `${baseUrl}/marketing/add-selected-contact-campaigns`,
		  method : 'post',
		  dataType: 'json',
		  processData: false, // important
		  contentType: false, // important
		  data : formData,
		  success : function(result)
		  {
		    console.log(result);
		    $('#modal_selectCampaigns').modal('hide');
		    if(result == 'Success')
		    {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>New campaign/s added successfully.',
		      });
		      CONTACTS.loadContactCampaigns($('#txt_contactId').val());
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


	//comments
	thisContacts.loadContactComments = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactComments() */
		  url : `${baseUrl}/marketing/load-contact-comments`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
    		
		  }
		});
	}

	thisContacts.addContactComment = function(thisForm)
	{
		let formData = new FormData(thisForm);

		formData.set("txt_contactId", $('#txt_contactId').val());

		$.ajax({
			/* ContactController->addContactComment() */
		  url : `${baseUrl}/marketing/add-contact-comment`,
		  method : 'post',
		  dataType: 'json',
		  processData: false, // important
		  contentType: false, // important
		  data : formData,
		  success : function(result)
		  {
		    console.log(result);
		    if(result == 'Success')
		    {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>New comment posted successfully.',
		      });
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

	thisContacts.replyComment = function(elem,commentId,commentIndex)
	{
		let formComment = `<form id="form_replyToComment">
												<input type="hidden" id="txt_replyCommentId" name="txt_replyCommentId" value="${commentId}">
                        <input type="hidden" id="txt_replyCommentIndex" name="txt_replyCommentIndex" value="${commentIndex}">
                        <textarea class="form-control mb-1" rows="2" id="txt_replyComments" name="txt_replyComments" placeholder="Post your comments here"></textarea>
                        <div class="row">
                          <div class="col-lg-4 col-sm-12"></div>
                          <div class="col-lg-4 col-sm-12"></div>
                          <div class="col-lg-4 col-sm-12">
                            <button type="submit" class="btn btn-primary btn-block btn-xs">Post Comment</button>
                          </div>
                        </div>
                      </form>`;
    $('.div-reply-to-comment').html('');              
    $(elem).closest('div').find('.div-reply-to-comment').html(formComment);              
	}

	thisContacts.replyContactComment


	//Sending Email
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
		  url : `${baseUrl}/tools/load-templates`,
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
		  url : `${baseUrl}/marketing/select-contact-email-template`,
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
		  url : `${baseUrl}/marketing/send-contact-email`,
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

		      setTimeout(function(){
            window.location.replace(`${baseUrl}/contact-preview/${$('#txt_contactId').val()}`);
          }, 1000);
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
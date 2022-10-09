let baseUrl = $('#txt_baseUrl').val();

const ORGANIZATION = (function(){

	let thisOrganization = {};

  let _arrSelectedDocuments = [];
  let _arrSelectedCampaigns = [];

  let _arrEmptyValues = [null,""];

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisOrganization.loadOrganizations = function(loadTo)
  {
    $.ajax({
      /* OrganizationController->loadOrganizations() */
      url : `${baseUrl}index.php/marketing/load-organizations`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        if(loadTo == 'table')
        {
          let tbody = '';
          data.forEach(function(value,key){
            let website = (_arrEmptyValues.includes(value['main_website']))? '---' : `<a href="${baseUrl}index.php/contact-preview/${value['id']}">${value['main_website']}</a>`;
            tbody += `<tr>
                        <td class="p-1 pl-4"><a href="${baseUrl}index.php/organization-preview/${value['id']}">${value['organization_name']}</a></td>
                        <td class="p-1"><a href="javascript:void(0)" onclick="ORGANIZATION.selectContactEmail(${value['id']},'${value['primary_email']}')">${value['primary_email']}</a></td>
                        <td class="p-1">${website}</td>
                        <td class="p-1">N/A</td>
                        <td class="p-1">N/A</td>
                        <td class="p-1">N/A</td>
                        <td class="p-1">${value['assigned_to']}</td>
                        <td class="p-1">
                          <a href="javascript:void(0)" onclick="ORGANIZATION.selectContact('edit',${value['id']})" class="mr-2">
                            <i class="fa fa-pen"></i>
                          </a>
                          <a href="javascript:void(0)" onclick="ORGANIZATION.removeOrganization(${value['id']})" class="text-red">
                            <i class="fa fa-trash"></i>
                          </a>
                        </td>
                      </tr>`;
          });

          $('#tbl_organizations').DataTable().destroy();
          $('#tbl_organizations tbody').html(tbody);
          $('#tbl_organizations').DataTable({
            "responsive": true,
            "columnDefs": [
              { responsivePriority: 1, targets: 0 },
              { responsivePriority: 2, targets: 1 },
              { responsivePriority: 3, targets: 2 },
              { responsivePriority: 10001, targets: 0 }
            ]
          });
        }
        else if(loadTo == 'select')
        {
          let options = '<option value="">--Select organization--</option>';
          data.forEach(function(value,key){
            options += `<option value="${value['id']}">${value['organization_name']}</option>`;
          });
          $('#slc_memberOf').html(options);
        }
      }
    });
  }

  thisOrganization.loadUsers = function(elemId, userId = '')
  {
    $.ajax({
      /* UserController->loadUsers() */
      url : `${baseUrl}index.php/load-users`,
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

  thisOrganization.addOrganization = function(thisForm)
  {
    let formData = new FormData(thisForm);
    $.ajax({
      /* OrganizationController->addOrganization() */
      url : `${baseUrl}index.php/marketing/add-organization`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_organization').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New organization added successfully.',
          });

          setTimeout(function(){
            window.location.replace(`${baseUrl}index.php/organizations`);
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

  thisOrganization.selectOrganization = function(action, organizationId)
  {
    $.ajax({
      /* OrganizationController->selectOrganization() */
      url : `${baseUrl}index.php/marketing/select-organization`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);
        if(action == 'edit')
        {
          $('#lbl_stateOrganization span').text('Edit Organization');
          $('#lbl_stateOrganization i').removeClass('fa-plus');
          $('#lbl_stateOrganization i').addClass('fa-pen');
          $('#modal_organization').modal('show');
          $('#txt_organizationId').val(organizationId);

          $('#txt_organizationName').val(data['organization_name']);
          ORGANIZATION.loadUsers('#slc_assignedTo', data['assigned_to']);
          $('#txt_primaryEmail').val(data['primary_email']);
          $('#txt_secondaryEmail').val(data['secondary_email']);
          $('#txt_mainWebsite').val(data['main_website']);
          $('#txt_otherWebsite').val(data['other_website']);
          $('#txt_phoneNumber').val(data['phone_number']);
          $('#txt_fax').val(data['fax']);
          $('#txt_linkedinUrl').val(data['linkedin_url']);
          $('#txt_facebookUrl').val(data['facebook_url']);
          $('#txt_twitterUrl').val(data['twitter_url']);
          $('#txt_instagramUrl').val(data['instagram_url']);
          $('#slc_industry').val(data['industry']);
          $('#txt_naicsCode').val(data['naics_code']);
          $('#txt_employeeCount').val(data['employee_count']);
          $('#txt_annualRevenue').val(data['annual_revenue']);
          $('#slc_type').val(data['type']);
          $('#txt_ticketSymbol').val(data['ticket_symbol']);
          // $('#slc_memberOf').val(data['member_of']);
          $('#slc_emailOptOut').val(data['email_opt_out']);

          $('#txt_billingStreet').val(data['billing_street']);
          $('#txt_billingCity').val(data['billing_city']);
          $('#txt_billingState').val(data['billing_state']);
          $('#txt_billingZip').val(data['billing_zip']);
          $('#txt_billingCountry').val(data['billing_country']);
          $('#txt_shippingStreet').val(data['shipping_street']);
          $('#txt_shippingCity').val(data['shipping_city']);
          $('#txt_shippingState').val(data['shipping_state']);
          $('#txt_shippingZip').val(data['shipping_zip']);
          $('#txt_shippingCountry').val(data['shipping_country']);

          $('#txt_description').val(data['description']);
        }
        else if(action == 'load')
        {
          let organizationName = `${data['organization_name']}`;
          $('#lnk_organization').text(organizationName);
          $('#lnk_organization').attr('href',`${baseUrl}index.php/organization-preview/${data['id']}`);

          $('#lbl_organizationName').text(organizationName);

          let organizationWebsite = (_arrEmptyValues.includes(data['main_website']))? '---' : `<a href="${data['main_website']}" target="_blank">${data['main_website']}</a>`;
          $('#lbl_organizationWebSite').html(organizationWebsite);

          let organizationEmail = (_arrEmptyValues.includes(data['primary_email']))? '---' : data['primary_email'];
          $('#lbl_organizationEmail').text(organizationEmail);
        }
      }
    });
        
  }

  thisOrganization.editOrganization = function(thisForm)
  {
    let formData = new FormData(thisForm);

    formData.set("txt_organizationId", $('#txt_organizationId').val());

    $.ajax({
      /* OrganizationController->editOrganization() */
      url : `${baseUrl}index.php/marketing/edit-organization`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_organization').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Organization edited successfully.',
          });
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
        ORGANIZATION.loadOrganizations('table');
      }
    });
  }

  thisOrganization.removeOrganization = function(organizationId)
  {
    if(confirm('Please Confirm!'))
    {
      let formData = new FormData();

      formData.set("organizationId", organizationId);

      $.ajax({
        /* OrganizationController->removeOrganization() */
        url : `${baseUrl}index.php/marketing/remove-organization`,
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
              title: 'Success! <br>Organization removed successfully.',
            });
            setTimeout(function(){
              window.location.replace(`${baseUrl}index.php/organizations`);
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

  thisOrganization.loadEmailTemplates = function()
  {
    $.ajax({
      /* EmailTemplateController->loadTemplates() */
      url : `${baseUrl}index.php/tools/load-templates`,
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

  thisOrganization.selectEmailTemplate = function(organizationId,templateId)
  {
    $.ajax({
      /* OrganizationController->selectEmailTemplate() */
      url : `${baseUrl}index.php/marketing/select-organization-email-template`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId, templateId : templateId},
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

  // start of details

  //summary
  thisOrganization.loadOrganizationSummary = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationSummary() */
      url : `${baseUrl}index.php/marketing/load-organization-summary`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);
        // Summary
        $('#lbl_orgName').html(data['organization_name']);
        $('#lbl_assignedTo').text(data['assigned_to_name']);
        $('#lbl_billingCity').text((_arrEmptyValues.includes(data['billing_city']))? '---' : data['billing_city']);
        $('#lbl_billingCountry').text((_arrEmptyValues.includes(data['billing_country']))? '---' : data['billing_country']);
      }
    });
  }

  //details
  thisOrganization.loadOrganizationDetails = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationDetails() */
      url : `${baseUrl}index.php/marketing/load-organization-details`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);

        let mainWebsite = (_arrEmptyValues.includes(data['main_website']))? '---' : `<a href="${data['main_website']}" target="_blank">${data['main_website']}</a>`;
        let otherWebsite = (_arrEmptyValues.includes(data['other_website']))? '---' : `<a href="${data['other_website']}" target="_blank">${data['other_website']}</a>`;

        let linkedIn = (_arrEmptyValues.includes(data['linkedin_url']))? '---' : `<a href="${data['linkedin_url']}" target="_blank">${data['linkedin_url']}</a>`;
        let facebook = (_arrEmptyValues.includes(data['facebook_url']))? '---' : `<a href="${data['facebook_url']}" target="_blank">${data['facebook_url']}</a>`;
        let twitter = (_arrEmptyValues.includes(data['twitter_url']))? '---' : `<a href="${data['twitter_url']}" target="_blank">${data['twitter_url']}</a>`;
        let instagram = (_arrEmptyValues.includes(data['instagram_url']))? '---' : `<a href="${data['instagram_url']}" target="_blank">${data['instagram_url']}</a>`;
        // Details
        $('#div_details table:eq(0) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['organization_name']))? '---' : data['organization_name']);
        $('#div_details table:eq(1) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['assigned_to_name']))? '---' : data['assigned_to_name']);
        $('#div_details table:eq(2) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['primary_email']))? '---' : data['primary_email']);
        $('#div_details table:eq(3) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['secondary_email']))? '---' : data['secondary_email']);
        $('#div_details table:eq(4) tbody tr td:eq(1)').html(mainWebsite);
        $('#div_details table:eq(5) tbody tr td:eq(1)').html(otherWebsite);
        $('#div_details table:eq(6) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['phone_number']))? '---' : data['phone_number']);
        $('#div_details table:eq(7) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['fax']))? '---' : data['fax']);
        $('#div_details table:eq(8) tbody tr td:eq(1)').html(linkedIn);
        $('#div_details table:eq(9) tbody tr td:eq(1)').html(facebook);
        $('#div_details table:eq(10) tbody tr td:eq(1)').html(twitter);
        $('#div_details table:eq(11) tbody tr td:eq(1)').html(instagram);
        $('#div_details table:eq(12) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['industry']))? '---' : data['industry']);
        $('#div_details table:eq(13) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['naics_code']))? '---' : data['naics_code']);
        $('#div_details table:eq(14) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['employee_count']))? '---' : data['employee_count']);
        $('#div_details table:eq(15) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['annual_revenue']))? '---' : `$ ${data['annual_revenue']}`);
        $('#div_details table:eq(16) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['type']))? '---' : data['type']);
        $('#div_details table:eq(17) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['ticket_symbol']))? '---' : data['ticket_symbol']);
        $('#div_details table:eq(18) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['member_of']))? '---' : data['member_of']);
        $('#div_details table:eq(19) tbody tr td:eq(1)').html((data['email_opt_out'] == 0)? 'No':'Yes');

        $('#div_details table:eq(20) tbody tr:eq(0) td:eq(1)').html((_arrEmptyValues.includes(data['billing_street']))? '---' : data['billing_street']);
        $('#div_details table:eq(20) tbody tr:eq(1) td:eq(1)').html((_arrEmptyValues.includes(data['billing_city']))? '---' : data['billing_city']);
        $('#div_details table:eq(20) tbody tr:eq(2) td:eq(1)').html((_arrEmptyValues.includes(data['billing_state']))? '---' : data['billing_state']);
        $('#div_details table:eq(20) tbody tr:eq(3) td:eq(1)').html((_arrEmptyValues.includes(data['billing_zip']))? '---' : data['billing_zip']);
        $('#div_details table:eq(20) tbody tr:eq(4) td:eq(1)').html((_arrEmptyValues.includes(data['billing_country']))? '---' : data['billing_country']);

        $('#div_details table:eq(21) tbody tr:eq(0) td:eq(1)').html((_arrEmptyValues.includes(data['shipping_street']))? '---' : data['shipping_street']);
        $('#div_details table:eq(21) tbody tr:eq(1) td:eq(1)').html((_arrEmptyValues.includes(data['shipping_city']))? '---' : data['shipping_city']);
        $('#div_details table:eq(21) tbody tr:eq(2) td:eq(1)').html((_arrEmptyValues.includes(data['shipping_state']))? '---' : data['shipping_state']);
        $('#div_details table:eq(21) tbody tr:eq(3) td:eq(1)').html((_arrEmptyValues.includes(data['shipping_zip']))? '---' : data['shipping_zip']);
        $('#div_details table:eq(21) tbody tr:eq(4) td:eq(1)').html((_arrEmptyValues.includes(data['shipping_country']))? '---' : data['shipping_country']);

        $('#div_details table:eq(22) tbody tr td').html((_arrEmptyValues.includes(data['description']))? '---' : data['description']);
      }
    });
  }

  //contacts
  thisOrganization.loadOrganizationContacts = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationContacts() */
      url : `${baseUrl}index.php/marketing/load-organization-contacts`,
      method : 'get',
      dataType: 'json',
      data : {organizationId:organizationId},
      success : function(data)
      {
        console.log(data);
        let tbody = '';
        let count = 0;
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1">${value['id']}</td>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1"><a href="${baseUrl}index.php/contact-preview/${value['id']}">${value['first_name']}</a></td>
                      <td class="p-1"><a href="${baseUrl}index.php/contact-preview/${value['id']}">${value['last_name']}</a></td>
                      <td class="p-1">Leader</td>
                      <td class="p-1"><a href="${baseUrl}index.php/organization-preview/${value['organization_id']}">${value['organization_name']}</a></td>
                      <td class="p-1"><a href="javascript:void(0)" onclick="CONTACTS.selectContactEmail(${value['id']},'${value['primary_email']}')">${value['primary_email']}</a></td>
                      <td class="p-1">Juan</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="ORGANIZATION.selectContact('edit',${value['id']})" class="mr-2">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="ORGANIZATION.unlinkOrganizationContact(${value['id']},${organizationId})">
                          <i class="fa fa-unlink"></i>
                        </a>
                      </td>
                    </tr>`;
          count++;
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

        $(`#tbl_contacts_length`).html(`<button type="button" onclick="ORGANIZATION.selectContactModal(${organizationId})" class="btn btn-sm btn-default"><i class="fa fa-user mr-1"></i> Select Contact</button>`);
        
        if(count > 0)
        {
          $('#lbl_contactCount').prop('hidden',false);
          $('#lbl_contactCount').text(count);
        }
        else
        {
          $('#lbl_contactCount').prop('hidden',true);
          $('#lbl_contactCount').text(count);
        }
      }
    });
  }

  thisOrganization.unlinkOrganizationContact = function(contactId, organizationId)
  {
    if(confirm('Please confirm!'))
    {
      let formData = new FormData();

      formData.set("contactId", contactId);

      $.ajax({
        /* OrganizationController->unlinkOrganizationContact() */
        url : `${baseUrl}index.php/marketing/unlink-organization-contact`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          console.log(result);
          $('#modal_organization').modal('hide');
          if(result == 'Success')
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>Contact unlinked successfully.',
            });
            ORGANIZATION.loadOrganizationContacts(organizationId);
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

  thisOrganization.selectContactModal = function(organizationId)
  {
    $('#modal_selectContact').modal('show');
    $('#btn_addSelectedContacts').prop('disabled',true);
    _arrSelectedContacts = [];
    ORGANIZATION.loadUnlinkContacts(organizationId);
  }

  thisOrganization.loadUnlinkContacts = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadUnlinkOrganizationContacts() */
      url : `${baseUrl}index.php/marketing/load-unlink-organization-contacts`,
      method : 'get',
      dataType: 'json',
      data : {organizationId:organizationId},
      success : function(data)
      {
        console.log(data);
        // Emails
        let tbody = '';
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1"><input type="checkbox" onchange="ORGANIZATION.selectContacts(this)" value="${value['id']}"/></td>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1">${value['first_name']}</td>
                      <td class="p-1">${value['last_name']}</td>
                      <td class="p-1">${value['position']}</td>
                      <td class="p-1">${value['organization_name']}</td>
                      <td class="p-1">${value['primary_email']}</td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                    </tr>`;
        });

        $(`#tbl_allContacts`).DataTable().destroy();
        $(`#tbl_allContacts tbody`).html(tbody);
        $(`#tbl_allContacts`).DataTable({
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

  thisOrganization.selectContacts = function(thisCheckBox)
  {
    if($(thisCheckBox).is(':checked'))
    {
      _arrSelectedContacts.push($(thisCheckBox).val());
    }
    else
    {
      let index = _arrSelectedContacts.indexOf($(thisCheckBox).val());
      if (index > -1) 
      {
        _arrSelectedContacts.splice(index, 1); 
      }
    }

    $('#btn_addSelectedContacts').prop('disabled',(_arrSelectedContacts.length > 0)? false : true);    
  }

  thisOrganization.addSelectedContacts = function()
  {
    let formData = new FormData();

    formData.set("organizationId", $('#txt_organizationId').val());
    formData.set("arrSelectedContacts", _arrSelectedContacts);

    $.ajax({
      /* OrganizationController->addSelectedOrganizationContacts() */
      url : `${baseUrl}index.php/marketing/add-selected-organization-contacts`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_selectContact').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New contact added successfully.',
          });
          ORGANIZATION.loadOrganizationContacts($('#txt_organizationId').val());
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

  //emails
  thisOrganization.loadOrganizationEmails = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationEmails() */
      url : `${baseUrl}index.php/marketing/load-organization-emails`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
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

        $('#tbl_organizationEmails').DataTable().destroy();
        $('#tbl_organizationEmails tbody').html(tbody);
        $('#tbl_organizationEmails').DataTable({
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
  thisOrganization.loadOrganizationDocuments = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationDocuments() */
      url : `${baseUrl}index.php/marketing/load-organization-documents`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
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
                        <a href="javascript:void(0)" onclick="ORGANIZATION.unlinkOrganizationDocument(${value['id']})" title="Unlink">
                          <i class="fa fa-unlink"></i>
                        </a>
                      </td>
                    </tr>`;
          count++;
        });

        $('#tbl_organizationDocuments').DataTable().destroy();
        $('#tbl_organizationDocuments tbody').html(tbody);
        $('#tbl_organizationDocuments').DataTable({
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

        let buttons = `<button type="button" onclick="ORGANIZATION.selectDocumentModal(${organizationId})" class="btn btn-sm btn-default"><i class="fa fa-file mr-1"></i> Select Documents</button>
                        <button type="button" onclick="ORGANIZATION.addDocumentModal()" class="btn btn-sm btn-default"><i class="fa fa-plus mr-1"></i> New Document</button>`;

        $(`#tbl_organizationDocuments_length`).html(buttons);

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

  thisOrganization.unlinkOrganizationDocument = function(organizationDocumentId)
  {
    if(confirm('Please confirm!'))
    {
      let formData = new FormData();

      formData.set("organizationDocumentId", organizationDocumentId);

      $.ajax({
        /* OrganizationController->unlinkOrganizationDocument() */
        url : `${baseUrl}index.php/marketing/unlink-organization-document`,
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
            ORGANIZATION.loadOrganizationDocuments($('#txt_organizationId').val());
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

  thisOrganization.selectDocumentModal = function(organizationId)
  {
    $('#modal_selectDocuments').modal('show');
    $('#btn_addSelectedDocuments').prop('disabled',true);
    _arrSelectedDocuments = [];
    ORGANIZATION.loadUnlinkOrganizationDocuments(organizationId);
  }

  thisOrganization.loadUnlinkOrganizationDocuments = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadUnlinkOrganizationDocuments() */
      url : `${baseUrl}index.php/marketing/load-unlink-organization-documents`,
      method : 'get',
      dataType: 'json',
      data : {organizationId:organizationId},
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
                      <td class="p-1"><input type="checkbox" onchange="ORGANIZATION.selectDocuments(this)" value="${value['id']}"/></td>
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

  thisOrganization.selectDocuments = function(thisCheckBox)
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

  thisOrganization.addSelectedDocuments = function()
  {
    let formData = new FormData();

    formData.set("organizationId", $('#txt_organizationId').val());
    formData.set("arrSelectedDocuments", _arrSelectedDocuments);

    $.ajax({
      /* OrganizationController->addSelectedOrganizationDocuments() */
      url : `${baseUrl}index.php/marketing/add-selected-organization-documents`,
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
          ORGANIZATION.loadOrganizationDocuments($('#txt_organizationId').val());
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

  thisOrganization.addDocumentModal = function()
  {
    $('#div_fileName').hide();
    $('#div_fileUrl').hide();
    ORGANIZATION.loadUsers('#slc_assignedToDocument');
    $('#modal_addDocument').modal('show');
  }

  thisOrganization.addOrganizationDocument = function(thisForm)
  {
    let formData = new FormData(thisForm);

    formData.set("txt_organizationId", $('#txt_organizationId').val());

    $.ajax({
      /* OrganizationController->addOrganizationDocument() */
      url : `${baseUrl}index.php/marketing/add-organization-document`,
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
            ORGANIZATION.loadOrganizationDocuments($('#txt_organizationId').val());
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

  //Campaigns
  thisOrganization.loadOrganizationCampaigns = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationCampaigns() */
      url : `${baseUrl}index.php/marketing/load-organization-campaigns`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
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
                        <a href="javascript:void(0)" onclick="ORGANIZATION.unlinkOrganizationCampaign(${value['id']})" title="Unlink">
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

        $(`#tbl_campaigns_length`).html(`<button type="button" onclick="ORGANIZATION.selectCampaignModal(${organizationId})" class="btn btn-sm btn-default"><i class="fa fa-bullhorn mr-1"></i> Select Campaigns</button>`);
      
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

  thisOrganization.loadUnlinkOrganizationCampaigns = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadUnlinkOrganizationCampaigns() */
      url : `${baseUrl}index.php/marketing/load-unlink-organization-campaigns`,
      method : 'get',
      dataType: 'json',
      data : {organizationId:organizationId},
      success : function(data)
      {
        console.log(data);
        // Emails
        let tbody = '';
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1"><input type="checkbox" onchange="ORGANIZATION.selectCampaigns(this)" value="${value['id']}"/></td>
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

  thisOrganization.selectCampaignModal = function(organizationId)
  {
    $('#modal_selectCampaigns').modal('show');
    $('#btn_addSelectedCampaigns').prop('disabled',true);
    _arrSelectedCampaigns = [];
    ORGANIZATION.loadUnlinkOrganizationCampaigns(organizationId);
  }

  thisOrganization.selectCampaigns = function(thisCheckBox)
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

  thisOrganization.addSelectedCampaign = function()
  {
    let formData = new FormData();

    formData.set("organizationId", $('#txt_organizationId').val());
    formData.set("arrSelectedCampaigns", _arrSelectedCampaigns);

    $.ajax({
      /* OrganizationController->addSelectedOrganizationCampaigns() */
      url : `${baseUrl}index.php/marketing/add-selected-organization-campaigns`,
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
            title: 'Success! <br>New campaign added successfully.',
          });
          ORGANIZATION.loadOrganizationCampaigns($('#txt_organizationId').val());
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

  thisOrganization.unlinkOrganizationCampaign = function(organizationCampaignId)
  {
    if(confirm('Please confirm!'))
    {
      let formData = new FormData();

      formData.set("organizationCampaignId", organizationCampaignId);

      $.ajax({
        /* OrganizationController->unlinkOrganizationCampaign() */
        url : `${baseUrl}index.php/marketing/unlink-organization-campaign`,
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
            ORGANIZATION.loadOrganizationCampaigns($('#txt_organizationId').val());
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

  return thisOrganization;

})();
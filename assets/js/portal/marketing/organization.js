let baseUrl = $('#txt_baseUrl').val();

const ORGANIZATION = (function(){

	let thisOrganization = {};

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
            let website = (value['main_website'] == null)? '---' : `<a href="${baseUrl}index.php/contact-preview/${value['id']}">${value['main_website']}</a>`;
            tbody += `<tr>
                        <td class="p-1 pl-4"><a href="${baseUrl}index.php/organization-preview/${value['id']}">${value['organization_name']}</a></td>
                        <td class="p-1"><a href="javascript:void(0)" onclick="CONTACTS.selectContactEmail(${value['id']},'${value['primary_email']}')">${value['primary_email']}</a></td>
                        <td class="p-1">${website}</td>
                        <td class="p-1">N/A</td>
                        <td class="p-1">N/A</td>
                        <td class="p-1">N/A</td>
                        <td class="p-1">${value['assigned_to']}</td>
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

  thisOrganization.loadUsers = function(elemId)
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
          options += `<option value="${value['user_id']}">${value['salutation']} ${value['first_name']} ${value['last_name']}</option>`;
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
        }
        else if(action == 'load')
        {
          let organizationName = `${data['organization_name']}`;
          $('#lnk_organization').text(organizationName);
          $('#lnk_organization').attr('href',`${baseUrl}index.php/organization-preview/${data['id']}`);

          $('#lbl_organizationName').text(organizationName);

          let organizationWebsite = (data['main_website'] != null)? `<a href="${data['main_website']}" target="_blank">${data['main_website']}</a>` : '---';
          $('#lbl_organizationWebSite').html(organizationWebsite);

          let organizationEmail = (data['primary_email'] != null)? data['primary_email'] : '---';
          $('#lbl_organizationEmail').text(organizationEmail);
        }
      }
    });
        
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

  return thisOrganization;

})();
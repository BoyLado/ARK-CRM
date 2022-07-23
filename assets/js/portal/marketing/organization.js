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
      url : `${baseUrl}marketing/load-organizations`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        if(loadTo == 'table')
        {
          let tbody = '';
          data.forEach(function(value,key){
            let website = (value['main_website'] == null)? '---' : `<a href="${baseUrl}contact-preview/${value['id']}">${value['main_website']}</a>`;
            tbody += `<tr>
                        <td class="p-1 pl-4"><a href="${baseUrl}organization-preview/${value['id']}">${value['organization_name']}</a></td>
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
        $(elemId).html(options);
      }
    });
  }

  thisOrganization.addOrganization = function(thisForm)
  {
    let formData = new FormData(thisForm);
    $.ajax({
      /* OrganizationController->addOrganization() */
      url : `${baseUrl}marketing/add-organization`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_addOrganization').modal('hide');
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
      url : `${baseUrl}marketing/select-organization`,
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
          $('#modal_addOrganizations').modal('show');
          $('#txt_organizationId').val(organizationId);
        }
        else if(action == 'load')
        {
          let organizationName = `${data['organization_name']}`;
          $('#lnk_organization').text(organizationName);
          $('#lnk_organization').attr('href',`${baseUrl}organization-preview/${data['id']}`);

          $('#lbl_organizationName').text(organizationName);

          let organizationWebsite = (data['main_website'] != null)? data['main_website'] : '---';
          $('#lbl_organizationWebSite').text(organizationWebsite);

          let organizationEmail = (data['primary_email'] != null)? data['primary_email'] : '---';
          $('#lbl_organizationEmail').text(organizationEmail);
        }
      }
    });
        
  }

  return thisOrganization;

})();
let baseUrl = $('#txt_baseUrl').val();

const CAMPAIGN = (function(){

	let thisCampaign = {};

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisCampaign.loadCampaigns = function(loadTo)
  {
    $.ajax({
      /* CampaignController->loadCampaigns() */
      url : `${baseUrl}index.php/marketing/load-campaigns`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        if(loadTo == 'table')
        {
          let tbody = '';
          data.forEach(function(value,key){
            tbody += `<tr>
                        <td class="p-1 pl-4"><a href="${baseUrl}index.php/campaign-preview/${value['id']}">${value['campaign_name']}</a></td>
                        <td class="p-1"></td>
                        <td class="p-1"></td>
                        <td class="p-1">N/A</td>
                        <td class="p-1">N/A</td>
                        <td class="p-1">N/A</td>
                        <td class="p-1">
                          <a href="javascript:void(0)" onclick="CAMPAIGN.selectContact('edit',${value['id']})" class="mr-2">
                            <i class="fa fa-pen"></i>
                          </a>
                          <a href="javascript:void(0)" onclick="CAMPAIGN.removeContact(${value['id']})">
                            <i class="fa fa-trash"></i>
                          </a>
                        </td>
                      </tr>`;
          });

          $('#tbl_campaigns').DataTable().destroy();
          $('#tbl_campaigns tbody').html(tbody);
          $('#tbl_campaigns').DataTable({
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
          let options = '<option value="">--Select campaign--</option>';
          data.forEach(function(value,key){
            options += `<option value="${value['id']}">${value['campaign_name']}</option>`;
          });
          $('#slc_memberOf').html(options);
        }
      }
    });
  }

  thisCampaign.loadUsers = function(elemId)
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

  thisCampaign.addOrganization = function(thisForm)
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

  thisCampaign.selectOrganization = function(action, organizationId)
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

  thisCampaign.loadEmailTemplates = function()
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

  thisCampaign.selectEmailTemplate = function(organizationId,templateId)
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

  return thisCampaign;

})();
let baseUrl = $('#txt_baseUrl').val();

const EMAIL_TEMPLATE = (function(){

	let thisEmailTemplate = {};

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisEmailTemplate.loadCategories = function(containerType,containerId)
  {
    $.ajax({
      /* EmailTemplateController->loadCategories() */
      url : `${baseUrl}tools/load-categories`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        if(containerType == 'tbl')
        {
          let tbody = '';
          data.forEach(function(value,key){
            tbody += `<tr>
                        <td class="p-1">${value['category_name']}</td>
                        <td class="p-1" width="40">
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

          $(`${containerId} tbody`).html(tbody);
        }
        else
        {
          let options = '<option value="">--Select Category--</option>';
          data.forEach(function(value,key){
            options += `<option value="${value['id']}">${value['category_name']}</option>`;
          });

          $(containerId).html(options);
        }
      }
    });
  }

  thisEmailTemplate.addCategory = function(thisForm)
  {
    let formData = new FormData(thisForm);

    $.ajax({
      /* EmailTemplateController->addCategory() */
      url : `${baseUrl}tools/add-category`,
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
            title: 'Success! <br>New category has been saved.',
          });
          EMAIL_TEMPLATE.loadCategories('tbl','#tbl_categories');
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: result,
          });
        }
      }
    });
  }

  thisEmailTemplate.loadTemplates = function()
  {
    $.ajax({
      /* EmailTemplateController->loadTemplates() */
      url : `${baseUrl}tools/load-templates`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        let tbody = '';
        data.forEach(function(value,key){
          let templateStatus = (value['template_status'] == "1")? 'Active' : 'Inactive';
          tbody += `<tr>
                      <td class="p-1 pl-4">${value['template_name']}</td>
                      <td class="p-1">${value['category_name']}</td>
                      <td class="p-1">${value['created_by']}</td>
                      <td class="p-1">${value['template_subject']}</td>
                      <td class="p-1">${value['template_visibility']}</td>
                      <td class="p-1">${templateStatus}</td>
                      <td class="p-1">${value['created_date']}</td>
                      <td class="p-1" width="40">
                        <a href="javascript:void(0)" class="mr-2">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a href="#" class="mr-2">
                          <i class="fa fa-trash"></i>
                        </a>
                        <a href="#">
                          <i class="fa fa-eye"></i>
                        </a>
                      </td>
                    </tr>`;
        });

        $('#tbl_emailTemplates').DataTable().destroy();
        $('#tbl_emailTemplates tbody').html(tbody);
        $('#tbl_emailTemplates').DataTable({
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

  thisEmailTemplate.addTemplate = function(thisForm)
  {
    let formData = new FormData(thisForm);

    $.ajax({
      /* EmailTemplateController->addTemplate() */
      url : `${baseUrl}tools/add-template`,
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
            title: 'Success! <br>New email template has been saved.',
          });
          $('#modal_createTemplate').modal('hide');
          EMAIL_TEMPLATE.loadTemplates();
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: result,
          });
        }
      }
    });
  }

  return thisEmailTemplate;

})();
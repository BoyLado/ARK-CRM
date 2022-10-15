let baseUrl = $('#txt_baseUrl').val();

const DOCUMENTS = (function(){

	let thisDocuments = {};

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  let _arrSelectedContacts = [];
  let _arrSelectedOrganizations = [];

  let _arrEmptyValues = [null,""];

  thisDocuments.loadDocuments = function()
  {
    $.ajax({
      /* DocumentController->loadDocuments() */
      url : `${baseUrl}/load-documents`,
      method : 'get',
      dataType: 'json',
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
            fileLink = `<a href="${value['file_url']}" target="_blank" title="${value['file_url']}">${value['file_url'].substring(0, 20)}...</a>`;
          }
          else
          {
            fileLink = `<a href="${baseUrl}assets/uploads/documents/${value['file_name']}" target="_blank">${value['file_name'].substring(0, 20)}...</a>`;
          }
          let documentPreview = `<a href="${baseUrl}/document-preview/${value['id']}">${value['title']}</a>`;
          tbody += `<tr>
                      <td class="p-1">${value['id']}</td>
                      <td class="p-1 pl-4">${documentPreview}</td>
                      <td class="p-1">${fileLink}</td>
                      <td class="p-1">${value['created_date']}</td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                      <td class="p-1">${(value['download_count'] != null)? value['download_count'] : 0}</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="alert('Coming Soon')" class="mr-2" title="Edit">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="alert('Coming Soon')" class="mr-2" title="Download">
                          <i class="fa fa-download"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="DOCUMENTS.removeDocument(${value['id']})" class="text-red" title="Unlink">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                    </tr>`;
          count++;
        });

        $('#tbl_documents').DataTable().destroy();
        $('#tbl_documents tbody').html(tbody);
        $('#tbl_documents').DataTable({
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

  thisDocuments.removeDocument = function(documentId)
  {
    if(confirm('Please Confirm'))
    {
      let formData = new FormData();

      formData.set("documentId", documentId);

      $.ajax({
        /* DocumentController->removeDocument() */
        url : `${baseUrl}/remove-document`,
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
              title: 'Success! <br>Document removed successfully.',
            });
            setTimeout(function(){
              window.location.replace(`${baseUrl}/documents`);
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

  thisDocuments.addDocumentModal = function()
  {
    $('#div_fileName').hide();
    $('#div_fileUrl').hide();
    DOCUMENTS.loadUsers('#slc_assignedToDocument');
    $('#txt_documentState').val('add');
    $('#modal_document').modal('show');
  }

  thisDocuments.loadUsers = function(elemId, userId = '')
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

  thisDocuments.addDocument = function(thisForm)
  {
    let formData = new FormData(thisForm);

    $.ajax({
      /* DocumentController->addDocument() */
      url : `${baseUrl}/add-document`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_document').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New document added successfully.',
          });

          setTimeout(function(){
            window.location.replace(`${baseUrl}/documents`);
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

  thisDocuments.selectDocument = function(action, documentId)
  {
    // CONTACTS.loadUsers(['#slc_reportsTo','#slc_assignedTo']);
    $.ajax({
      /* DocumentController->selectDocument() */
      url : `${baseUrl}/select-document`,
      method : 'get',
      dataType: 'json',
      data : {documentId : documentId},
      success : function(data)
      {
        console.log(data);
        if(action == 'edit')
        {
          $('#lbl_stateDocument span').text('Edit Document');
          $('#lbl_stateDocument i').removeClass('fa-plus');
          $('#lbl_stateDocument i').addClass('fa-pen');
          $('#modal_document').modal('show');
          $('#txt_documentId').val(documentId);

          $('#txt_title').val(data['title']);
          DOCUMENTS.loadUsers('#slc_assignedToDocument', data['assigned_to']);
          $('#slc_uploadtype').val((_arrEmptyValues.includes(data['type']))? '' : data['type']);

          if(data['type'] == 1)
          {
            $('#div_fileName').show();
            $('#div_fileUrl').hide();
          }
          else
          {
            $('#div_fileName').hide();
            $('#div_fileUrl').show();
          }
          $('#txt_fileUrl').val(data['file_url']);
          $('#txt_notes').val(data['notes']);
        }
        else if(action == 'load')
        {
          let documentTitle = data['title'];
          $('#lnk_document').text(documentTitle);
          $('#lnk_document').attr('href',`${baseUrl}/document-preview/${data['id']}`);

          $('#lbl_documentTitle').text(documentTitle);

          let documentUploadLast = data['uploadLast'];
          $('#lbl_documentUploadedLast').text(documentUploadLast);

          let documentDownload = '';
          if(data['type'] == 2)
          {
            documentDownload = `<i class="fa fa-link mr-1" title="Open link in new tab"></i>
                                <span>
                                  <a href="${data['file_url']}" target="_blank">Open link</a>
                                </span>`;
          }
          else
          {
            documentDownload = `<i class="fa fa-download mr-1" title="Download"></i>
                                <span>
                                  <a href="javascript:void(0)" onclick="DOCUMENTS.downloadDocument('${baseUrl}assets/uploads/documents/${data['file_name']}');">Download</a>
                                </span>`;
          }
          $('#lbl_documentDownload').html(documentDownload);
        }
      }
    });
  }

  thisDocuments.editDocument = function(thisForm)
  {
    let formData = new FormData(thisForm);

    formData.set("txt_documentId", $('#txt_documentId').val());

    $.ajax({
      /* DocumentController->editDocument() */
      url : `${baseUrl}/edit-document`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_document').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Document updated successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/document-preview/${$('#txt_documentId').val()}`);
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

  thisDocuments.downloadDocument = function(filePath)
  {
    alert(filePath);
  }







  //details
  thisDocuments.loadDocumentDetails = function(documentId)
  {
    $.ajax({
      /* DocumentController->selectDocument() */
      url : `${baseUrl}/select-document`,
      method : 'get',
      dataType: 'json',
      data : {documentId : documentId},
      success : function(data)
      {
        $('#div_details table:eq(0) tbody tr td:eq(1)').text(data['title']);
        $('#div_details table:eq(1) tbody tr td:eq(1)').text(data['assigned_to_name']);
        // $('#div_details table:eq(2) tbody tr td:eq(1)').text(data['assigned_to_name']);
        // $('#div_details table:eq(3) tbody tr td:eq(1)').text(data['assigned_to_name']);
        $('#div_details table:eq(4) tbody tr td:eq(1)').text(data['created_date']);
        $('#div_details table:eq(5) tbody tr td:eq(1)').text((data['updated_date'] == null)? '---' : data['updated_date']);

        $('#div_details table:eq(6) tbody tr td:eq(0)').html((data['notes'] == "")? '---' : data['notes']);

        $('#div_details table:eq(7) tbody tr td:eq(1)').html((data['file_name'] == null)? '---' : data['file_name']);
        $('#div_details table:eq(8) tbody tr td:eq(1)').html((data['file_size'] == null)? '---' : data['file_size']);
        $('#div_details table:eq(9) tbody tr td:eq(1)').html((data['file_type'] == null)? '---' : data['file_type']);
        $('#div_details table:eq(10) tbody tr td:eq(1)').html((data['download_count'] == null)? '---' : data['download_count']);
      }
    });
  }









  //contacts
  thisDocuments.loadSelectedContactDocuments = function(documentId)
  {
    $.ajax({
      /* DocumentController->loadSelectedContactDocuments() */
      url : `${baseUrl}/load-selected-contact-documents`,
      method : 'get',
      dataType: 'json',
      data : {documentId : documentId},
      success : function(data)
      {
        console.log(data);
        let count = 0;
        let tbody = '';
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1">${value['contact_id']}</td>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['contact_id']}">${value['first_name']}</a></td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['contact_id']}">${value['last_name']}</a></td>
                      <td class="p-1">${value['position']}</td>
                      <td class="p-1"><a href="${baseUrl}/organization-preview/${value['organization_id']}">${value['organization_name']}</a></td>
                      <td class="p-1"><a href="javascript:void(0)" onclick="CONTACTS.selectContactEmail(${value['contact_id']},'${value['primary_email']}')">${value['primary_email']}</a></td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="alert('Coming Soon')" class="mr-2" title="Edit">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="DOCUMENTS.unlinkContactDocument(${value['id']})" title="Unlink">
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

        $(`#tbl_contacts_length`).html(`<button type="button" onclick="DOCUMENTS.selectContactModal(${documentId})" class="btn btn-sm btn-default"><i class="fa fa-user mr-1"></i> Select Contact</button>`);
      
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

  thisDocuments.unlinkContactDocument = function(contactDocumentId)
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
            DOCUMENTS.loadSelectedContactDocuments($('#txt_documentId').val());
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

  thisDocuments.selectContactModal = function(documentId)
  {
    $('#modal_selectContact').modal('show');
    $('#btn_addSelectedContacts').prop('disabled',true);
    _arrSelectedContacts = [];
    DOCUMENTS.loadUnlinkContacts(documentId);
  }

  thisDocuments.loadUnlinkContacts = function(documentId)
  {
    $.ajax({
      /* DocumentController->loadUnlinkContacts() */
      url : `${baseUrl}/load-unlink-contacts`,
      method : 'get',
      dataType: 'json',
      data : {documentId:documentId},
      success : function(data)
      {
        console.log(data);
        // Emails
        let tbody = '';
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1 pl-4"><input type="checkbox" onchange="DOCUMENTS.selectContacts(this)" value="${value['id']}"/></td>
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

  thisDocuments.selectContacts = function(thisCheckBox)
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

  thisDocuments.addSelectedContact = function()
  {
    let formData = new FormData();

    formData.set("documentId", $('#txt_documentId').val());
    formData.set("arrSelectedContacts", _arrSelectedContacts);

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
        $('#modal_selectContact').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New contact added successfully.',
          });
          DOCUMENTS.loadSelectedContactDocuments($('#txt_documentId').val());
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

  










  //organization
  thisDocuments.loadSelectedOrganizationDocuments = function(documentId)
  {
    $.ajax({
      /* DocumentController->loadSelectedOrganizationDocuments() */
      url : `${baseUrl}/load-selected-organization-documents`,
      method : 'get',
      dataType: 'json',
      data : {documentId : documentId},
      success : function(data)
      {
        console.log(data);
        let count = 0;
        let tbody = '';
        data.forEach(function(value,key){
          let website = (value['main_website'] == null)? '---' : `<a href="${baseUrl}/contact-preview/${value['id']}">${value['main_website']}</a>`;
          tbody += `<tr>
                      <td class="p-1">${value['organization_id']}</td>
                      <td class="p-1 pl-4"><a href="${baseUrl}/organization-preview/${value['organization_id']}">${value['organization_name']}</a></td>
                      <td class="p-1"><a href="javascript:void(0)" >${value['primary_email']}</a></td>
                      <td class="p-1">${website}</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="alert('Coming Soon')" class="mr-2" title="Edit">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="DOCUMENTS.unlinkOrganizationDocument(${value['id']})" title="Unlink">
                          <i class="fa fa-unlink"></i>
                        </a>
                      </td>
                    </tr>`;
          count++;          
        });

        $('#tbl_organizations').DataTable().destroy();
        $('#tbl_organizations tbody').html(tbody);
        $('#tbl_organizations').DataTable({
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

        $(`#tbl_organizations_length`).html(`<button type="button" onclick="DOCUMENTS.selectOrganizationModal(${documentId})" class="btn btn-sm btn-default"><i class="fa fa-building mr-1"></i> Select Organization</button>`);
      
        if(count > 0)
        {
          $('#lbl_organizationCount').prop('hidden',false);
          $('#lbl_organizationCount').text(count);
        }
        else
        {
          $('#lbl_organizationCount').prop('hidden',true);
          $('#lbl_organizationCount').text(count);
        }
      }
    });
  }

  thisDocuments.unlinkOrganizationDocument = function(organizationDocumentId)
  {
    if(confirm('Please confirm!'))
    {
      let formData = new FormData();

      formData.set("organizationDocumentId", organizationDocumentId);

      $.ajax({
        /* OrganizationController->unlinkOrganizationDocument() */
        url : `${baseUrl}/marketing/unlink-organization-document`,
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
            DOCUMENTS.loadSelectedOrganizationDocuments($('#txt_documentId').val());
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

  thisDocuments.selectOrganizationModal = function(documentId)
  {
    $('#modal_selectOrganization').modal('show');
    $('#btn_addSelectedOrganizations').prop('disabled',true);
    _arrSelectedOrganizations = [];
    DOCUMENTS.loadUnlinkOrganizations(documentId);
  }

  thisDocuments.loadUnlinkOrganizations = function(documentId)
  {
    $.ajax({
      /* DocumentController->loadUnlinkOrganizations() */
      url : `${baseUrl}/load-unlink-organizations`,
      method : 'get',
      dataType: 'json',
      data : {documentId:documentId},
      success : function(data)
      {
        console.log(data);
        // Emails
        let tbody = '';
        data.forEach(function(value,key){
          let website = (value['main_website'] == null)? '---' : `<a href="${baseUrl}/contact-preview/${value['id']}">${value['main_website']}</a>`;
          tbody += `<tr>
                      <td class="p-1 pl-4"><input type="checkbox" onchange="DOCUMENTS.selectOrganizations(this)" value="${value['id']}"/></td>
                      <td class="p-1 pl-4">${value['organization_name']}</td>
                      <td class="p-1">${value['primary_email']}</td>
                      <td class="p-1">${website}</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                    </tr>`;
        });

        $(`#tbl_allOrganizations`).DataTable().destroy();
        $(`#tbl_allOrganizations tbody`).html(tbody);
        $(`#tbl_allOrganizations`).DataTable({
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

  thisDocuments.selectOrganizations = function(thisCheckBox)
  {
    if($(thisCheckBox).is(':checked'))
    {
      _arrSelectedOrganizations.push($(thisCheckBox).val());
    }
    else
    {
      let index = _arrSelectedOrganizations.indexOf($(thisCheckBox).val());
      if (index > -1) 
      {
        _arrSelectedOrganizations.splice(index, 1); 
      }
    }

    $('#btn_addSelectedOrganizations').prop('disabled',(_arrSelectedOrganizations.length > 0)? false : true);    
  }

  thisDocuments.addSelectedOrganization = function()
  {
    let formData = new FormData();

    formData.set("documentId", $('#txt_documentId').val());
    formData.set("arrSelectedOrganizations", _arrSelectedOrganizations);

    // console.log(_arrSelectedOrganizations)

    $.ajax({
      /* OrganizationController->addSelectedOrganizationDocuments() */
      url : `${baseUrl}/marketing/add-selected-organization-documents`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_selectOrganization').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New organization added successfully.',
          });
          DOCUMENTS.loadSelectedOrganizationDocuments($('#txt_documentId').val());
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

  

  return thisDocuments;

})();
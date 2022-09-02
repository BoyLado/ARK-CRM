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

  thisDocuments.loadDocuments = function()
  {
    $.ajax({
      /* DocumentController->loadDocuments() */
      url : `${baseUrl}index.php/load-documents`,
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
            fileLink = `<a href="${value['file_url']}" target="_blank">${value['file_url'].substring(0, 20)}...</a>`;
          }
          else
          {
            fileLink = `<a href="${baseUrl}assets/uploads/documents/${value['file_name']}" target="_blank">${value['file_name'].substring(0, 20)}...</a>`;
          }
          let documentPreview = `<a href="${baseUrl}index.php/document-preview/${value['id']}">${value['title']}</a>`;
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
                        <a href="javascript:void(0)" onclick="DOCUMENTS.removeDocument(${value['id']})" title="Unlink">
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
    alert(documentId);
  }

  thisDocuments.addDocumentModal = function()
  {
    $('#div_fileName').hide();
    $('#div_fileUrl').hide();
    DOCUMENTS.loadUsers('#slc_assignedToDocument');
    $('#modal_addDocument').modal('show');
  }

  thisDocuments.loadUsers = function(elemId, userId = '')
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

  thisDocuments.addDocument = function(thisForm)
  {
    let formData = new FormData(thisForm);

    $.ajax({
      /* DocumentController->addDocument() */
      url : `${baseUrl}index.php/add-document`,
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
      url : `${baseUrl}index.php/select-document`,
      method : 'get',
      dataType: 'json',
      data : {documentId : documentId},
      success : function(data)
      {
        console.log(data);
        if(action == 'edit')
        {
          // $('#lbl_stateContact span').text('Edit Contact');
          // $('#lbl_stateContact i').removeClass('fa-plus');
          // $('#lbl_stateContact i').addClass('fa-pen');
          // $('#modal_contact').modal('show');
          // $('#txt_contactId').val(contactId);

          // $('#slc_salutation').val(data['salutation']);
          // $('#txt_firstName').val(data['first_name']);
          // $('#txt_lastName').val(data['last_name']);
          // $('#txt_position').val(data['position']);
          // CONTACTS.loadOrganizations('#slc_companyName', data['organization_id']);
          // $('#txt_primaryEmail').val(data['primary_email']);
          // $('#txt_secondaryEmail').val(data['secondary_email']);
          // $('#txt_birthDate').val(data['date_of_birth']);
          // $('#slc_introLetter').val(data['intro_letter']);
          // $('#txt_officePhone').val(data['office_phone']);
          // $('#txt_mobilePhone').val(data['mobile_phone']);
          // $('#txt_homePhone').val(data['home_phone']);
          // $('#txt_secondaryPhone').val(data['secondary_email']);
          // $('#txt_fax').val(data['fax']);
          // $('#chk_doNotCall').prop('checked',(data['do_not_call'] == 1)? true : false);
          // $('#txt_linkedinUrl').val(data['linkedin_url']);
          // $('#txt_twitterUrl').val(data['twitter_url']);
          // $('#txt_facebookUrl').val(data['facebook_url']);
          // $('#txt_instagramUrl').val(data['instagram_url']);
          // $('#slc_leadSource').val(data['lead_source']);
          // $('#txt_department').val(data['department']);
          // CONTACTS.loadUsers('#slc_reportsTo', data['reports_to']);
          // CONTACTS.loadUsers('#slc_assignedTo', data['assigned_to']);
          // $('#slc_emailOptOut').val(data['email_opt_out']);

          // $('#txt_mailingStreet').val(data['mailing_street']);
          // $('#txt_mailingPOBox').val(data['mailing_po_box']);
          // $('#txt_mailingCity').val(data['mailing_city']);
          // $('#txt_mailingState').val(data['mailing_state']);
          // $('#txt_mailingZip').val(data['mailing_zip']);
          // $('#txt_mailingCountry').val(data['mailing_country']);
          // $('#txt_otherStreet').val(data['other_street']);
          // $('#txt_otherPOBox').val(data['other_po_box']);
          // $('#txt_otherCity').val(data['other_city']);
          // $('#txt_otherState').val(data['other_state']);
          // $('#txt_otherZip').val(data['other_zip']);
          // $('#txt_otherCountry').val(data['other_country']);

          // $('#txt_description').val(data['description']);
        }
        else if(action == 'load')
        {
          let documentTitle = data['title'];
          $('#lnk_document').text(documentTitle);
          $('#lnk_document').attr('href',`${baseUrl}index.php/document-preview/${data['id']}`);

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

  thisDocuments.downloadDocument = function(filePath)
  {
    alert(filePath);
  }







  //details
  thisDocuments.loadDocumentDetails = function(documentId)
  {
    $.ajax({
      /* DocumentController->selectDocument() */
      url : `${baseUrl}index.php/select-document`,
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
      url : `${baseUrl}index.php/load-selected-contact-documents`,
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
                      <td class="p-1"><a href="${baseUrl}index.php/contact-preview/${value['contact_id']}">${value['first_name']}</a></td>
                      <td class="p-1"><a href="${baseUrl}index.php/contact-preview/${value['contact_id']}">${value['last_name']}</a></td>
                      <td class="p-1">${value['position']}</td>
                      <td class="p-1"><a href="${baseUrl}index.php/organization-preview/${value['organization_id']}">${value['organization_name']}</a></td>
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
        url : `${baseUrl}index.php/marketing/unlink-contact-document`,
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
      url : `${baseUrl}index.php/load-unlink-contacts`,
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
                      <td class="p-1"><input type="checkbox" onchange="DOCUMENTS.selectContacts(this)" value="${value['id']}"/></td>
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
      url : `${baseUrl}index.php/marketing/add-selected-contact-documents`,
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
      url : `${baseUrl}index.php/load-selected-organization-documents`,
      method : 'get',
      dataType: 'json',
      data : {documentId : documentId},
      success : function(data)
      {
        console.log(data);
        let count = 0;
        let tbody = '';
        data.forEach(function(value,key){
          let website = (value['main_website'] == null)? '---' : `<a href="${baseUrl}index.php/contact-preview/${value['id']}">${value['main_website']}</a>`;
          tbody += `<tr>
                      <td class="p-1">${value['organization_id']}</td>
                      <td class="p-1 pl-4"><a href="${baseUrl}index.php/organization-preview/${value['organization_id']}">${value['organization_name']}</a></td>
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
      url : `${baseUrl}index.php/load-unlink-organizations`,
      method : 'get',
      dataType: 'json',
      data : {documentId:documentId},
      success : function(data)
      {
        console.log(data);
        // Emails
        let tbody = '';
        data.forEach(function(value,key){
          let website = (value['main_website'] == null)? '---' : `<a href="${baseUrl}index.php/contact-preview/${value['id']}">${value['main_website']}</a>`;
          tbody += `<tr>
                      <td class="p-1"><input type="checkbox" onchange="DOCUMENTS.selectOrganizations(this)" value="${value['id']}"/></td>
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
      url : `${baseUrl}index.php/marketing/add-selected-organization-documents`,
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
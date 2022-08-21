let baseUrl = $('#txt_baseUrl').val();

const DOCUMENTS = (function(){

	let thisDocuments = {};

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

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

  return thisDocuments;

})();
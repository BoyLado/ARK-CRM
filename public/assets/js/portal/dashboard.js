let baseUrl = $('#txt_baseUrl').val();

const DASHBOARD = (function(){

	let thisDashboard = {};

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisDashboard.loadAllCampaigns = function()
  {
    $.ajax({
      /* DashboardController->loadAllCampaigns() */
      url : `${baseUrl}/dashboard/load-all-campaigns`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('#lbl_campaignsCount').text(data);
      }
    });
  }

  thisDashboard.loadAllContacts = function()
  {
    $.ajax({
      /* DashboardController->loadAllContacts() */
      url : `${baseUrl}/dashboard/load-all-contacts`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('#lbl_contactsCount').text(data);
      }
    });
  }

  thisDashboard.loadAllOrganizations = function()
  {
    $.ajax({
      /* DashboardController->loadAllOrganizations() */
      url : `${baseUrl}/dashboard/load-all-organizations`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('#lbl_organizationsCount').text(data);
      }
    });
  }

  thisDashboard.loadAllThirdParties = function()
  {

  }

  return thisDashboard;

})();
let baseUrl = $('#txt_baseUrl').val();

const CALENDAR = (function(){

  let thisCalendar = {};

  var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisCalendar.loadCalendars = function()
  {
    $.ajax({
      /* CalendarController->loadCalendars() */
      url : `${baseUrl}index.php/load-calendars`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        let divCalendar = '<div class="row">';
        let divCounter = 1;
        data['arrCalendars'].forEach(function(value,key){
          divCalendar += `<div class="col-lg-6 col-sm-12">
                          <div class="card card-primary card-outline">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-12 col-lg-5">
                                  <h5>${value['calendar_name']}</h5>
                                </div>
                                <div class="col-sm-12 col-lg-7">
                                  <h5>${moment().tz(value['timezone']).format('(Z) ddd MM/DD/y H:mm:ss')}</h5>
                                </div>
                              </div>
                              <hr>
                              <div id='div_calendar${divCounter}'></div>
                            </div>
                          </div>
                        </div>`;
          divCounter++;
        });

        divCalendar+= '</div>';

        $('#div_calendars').html(divCalendar);

        let arrEventsAndTasks = [];

        //events
        let arrEvents = [];
        let eventStart = '';
        let eventEnd = '';

        


        divCounter = 1;
        let objTimezones = moment.tz._names;
        data['arrCalendars'].forEach(function(value,key){

          data['arrEvents'].forEach(function(cValue,key){
            eventStart = `${cValue['start_date']}${(cValue['start_time'] == null)? '' : 'T'+cValue['start_time']}`;
            eventEnd = `${(cValue['end_date'] == null)? '' : cValue['end_date']}${(cValue['end_time'] == null)? '' : 'T'+cValue['end_time']}`;

            arrEvents['title'] = cValue['subject'];
            arrEvents['start'] = moment(eventStart).tz(objTimezones[value['timezone']]).format();

            if(eventEnd != '')
            {
              arrEvents['end'] = moment(eventEnd).tz(objTimezones[value['timezone']]).format();
            }

            arrEventsAndTasks.push(arrEvents);
          });

          console.log(`div_calendar${divCounter}`);

          let objCalendar = new FullCalendar.Calendar(document.getElementById(`div_calendar${divCounter}`),{
            headerToolbar: {
              left  : 'prev,next today',
              center: 'title',
              right : 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'bootstrap',
            timeZone: objTimezones[value['timezone']],
            now: moment().tz(objTimezones[value['timezone']]).format(),
            events: arrEventsAndTasks,
            eventTimeFormat: { hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }
          });
          objCalendar.render();

          arrEventsAndTasks = [];

          divCounter++;        
        });

        // console.log(data['arrCalendars'].length);
        // console.log(arrEventsAndTasks);

      }
    });
  }

  thisCalendar.loadTimezones = function()
  {
    let objTimezones = moment.tz._names;
    let slcTimezones = '<option value="">--Select Timezone--</option>';

    slcTimezones += '<option value="local">Local</option>';
    slcTimezones += '<option value="UTC">UTC</option>';

    Object.keys(objTimezones).forEach(function(key){
      slcTimezones += `<option value="${key}">(${moment().tz(objTimezones[key]).format('Z')}) ${objTimezones[key]}</option>`;
    });

    $('#slc_timezone').html(slcTimezones);
  }

  thisCalendar.addCalendar = function(thisForm)
  {
    let formData = new FormData(thisForm);

    $('#btn_saveCalendar').prop('disabled',true);

    $.ajax({
      /* CalendarController->addCalendar() */
      url : `${baseUrl}index.php/add-calendar`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_calendar').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New calendar added successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}index.php/calendar`);
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

  thisCalendar.selectCalendar = function(calendarId)
  {

  }

  thisCalendar.editCalendar = function(thisForm)
  {

  }

  thisCalendar.removeCalendar = function(calendarId)
  {

  }

  thisCalendar.loadUsers = function(elemId, userId = '')
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


  thisCalendar.addEvent = function(thisForm)
  {
    let formData = new FormData(thisForm);

    $('#btn_saveEvent').prop('disabled',true);

    $.ajax({
      /* EventController->addEvent() */
      url : `${baseUrl}index.php/add-event`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_events').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New event added successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}index.php/calendar`);
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

  thisCalendar.clearEvent = function()
  {
    $('#txt_eventId').val('');
    $('#txt_eventSubject').val('');
    $('#txt_eventStartDate').val('');
    $('#txt_eventStartTime').val('');
    $('#txt_eventEndDate').val('');
    $('#txt_eventEndTime').val('');
    $('#slc_eventAssignedTo').val('');
    $('#slc_eventStatus').val('');
    $('#slc_eventType').val('');
  }

  thisCalendar.selectEvent = function(eventId)
  {

  }

  thisCalendar.editEvent = function(thisForm)
  {
    
  }

  thisCalendar.removeEvent = function(eventId)
  {

  }


  thisCalendar.addTask = function(thisForm)
  {
    let formData = new FormData(thisForm);

    $('#btn_saveTask').prop('disabled',true);

    $.ajax({
      /* TaskController->addTask() */
      url : `${baseUrl}index.php/add-task`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_events').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New tasks added successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}index.php/calendar`);
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

  thisCalendar.clearTask = function()
  {
    $('#txt_taskId').val('');
    $('#txt_taskSubject').val('');
    $('#txt_taskStartDate').val('');
    $('#txt_taskStartTime').val('');
    $('#txt_taskEndDate').val('');
    $('#txt_taskEndTime').val('');
    $('#slc_taskAssignedTo').val('');
    $('#slc_taskStatus').val('');
  }

  thisCalendar.selectTask = function(taskId)
  {
    
  }

  thisCalendar.editTask = function(thisForm)
  {
    
  }

  thisCalendar.removeTask = function(taskId)
  {

  }

  return thisCalendar;

})();
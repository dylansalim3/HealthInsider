
		var idPlus = 4;
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');

			var calendar = new FullCalendar.Calendar(calendarEl, {
				plugins: [ 'interaction','timeGrid','dayGrid'],
				defaultView: 'dayGridMonth',
				header :{
					left: 'prev,next today',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay'
				},
				editable: true,
				navLinks: true,
				selectable: true,
				selectHelper: true,
				select: function(arg) {
					$("#myPrompt").modal({show: true});
					var promptBut = document.getElementById("promptBut");
					promptBut.addEventListener("click",function(){
						var patientName = document.querySelector("#patientName").value;
						var docName = document.querySelector("#doctorName").value;
						var title ='Patient Name: '+patientName +' Doctor:'+docName;

						var startTime = document.querySelector("#StartTime").value;
						var endTime = document.querySelector("#EndTime").value;
						console.log(startTime);
						console.log(arg.start);
						if(title){
						calendar.addEvent({
							id:idPlus,
							title: title,
							start: startTime,
							end: endTime,
							// allDay: arg.allDay

						});

						}
						calendar.unselect()
						console.log(idPlus);
						idPlus++;
					});
					
					
				},
				eventClick:function(info){
					if(confirm("Are you sure you want to remove this event?")){
						console.log(info.event.id);
						var myId = info.event.id;
						var myevent = calendar.getEventById(myId);
						myevent.remove();
					}
				},

				eventColor: '#2C3E50',
				eventTextColor: 'white',
				displayEventEnd: true,
				eventLimit: 5,
				slotDuration: '00:05',

				events: [
				{
					id:1,
					title: 'Patient: Ali Doctor: Dr.Khor',
					start: '2019-04-02T09:30:00',
					end: '2019-04-02T09:55:00'
				},
				{
					id:2,
					title: 'Patient: Ali Doctor: Dr.Khor',
					start: '2019-04-07T10:30:00',
					end: '2019-04-07T11:30:00'
				},

				{
					id:3,
					title: 'Patient:Jinx Doctor:Dr. Caitlyn',
					start: '2019-04-03T09:30:00',
					end: '2019-04-03T10:30:00'
				}
				]

			});
			calendar.render();
		});


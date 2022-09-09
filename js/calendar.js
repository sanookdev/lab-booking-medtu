//calendar api : https://classes.engineering.wustl.edu/cse330/content/calendar.js
(function () { Date.prototype.deltaDays = function (c) { return new Date(this.getFullYear(), this.getMonth(), this.getDate() + c) }; Date.prototype.getSunday = function () { return this.deltaDays(-1 * this.getDay()) } })();
function Week(c) { this.sunday = c.getSunday(); this.nextWeek = function () { return new Week(this.sunday.deltaDays(7)) }; this.prevWeek = function () { return new Week(this.sunday.deltaDays(-7)) }; this.contains = function (b) { return this.sunday.valueOf() === b.getSunday().valueOf() }; this.getDates = function () { for (var b = [], a = 0; 7 > a; a++)b.push(this.sunday.deltaDays(a)); return b } }
function Month(c, b) { this.year = c; this.month = b; this.nextMonth = function () { return new Month(c + Math.floor((b + 1) / 12), (b + 1) % 12) }; this.prevMonth = function () { return new Month(c + Math.floor((b - 1) / 12), (b + 11) % 12) }; this.getDateObject = function (a) { return new Date(this.year, this.month, a) }; this.getWeeks = function () { var a = this.getDateObject(1), b = this.nextMonth().getDateObject(0), c = [], a = new Week(a); for (c.push(a); !a.contains(b);)a = a.nextWeek(), c.push(a); return c } };


//getting the today's date
let today = new Date();
let todayMonth = today.getMonth();
let todayYear = today.getFullYear();


//Starts with the real time current month
var currentMonth = new Month(todayYear, todayMonth);
generateMonth();
//addeds events if user is logged in
function updateCalendar() {
    var room_id = $('#name_room option:selected').val();
    getEventsAjax(room_id);
}


//gets events that have that user_id
function getEventsAjax(room_id = '') {
    const data = {
        'room_id': room_id
    };
    fetch("includes/getEventHandler.php", {
        method: "POST",
        body: JSON.stringify(data),
        headers: { 'content-type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => data.success ? getEventDetails(data.events) : console.log('no events available'))
        .catch(err => console.error(err));
}


//gets the event details 
function getEventDetails(events) {
    events.forEach(event => {
        addEvent(event.topic, event.begin, event.end, event.id)
    });
}

//same as generate month except we add events to the month
function changeTime(time) {
    let eventHour = Number(time.slice(0, 2));
    eventHour;
    let suffix = 'am ';
    if (eventHour >= 12) {
        eventHour = eventHour - 12;
        suffix = 'pm '
    }
    if (eventHour == 0) {
        eventHour = 12;
    }
    time = eventHour + time.slice(2, 5) + suffix;

    return time;
}



function addEvent(title, begin, end, id) {

    date = begin.split(' ')[0];
    time = begin.split(' ')[1];
    timeEnd = end.split(' ')[1];

    //split the event date by components and convert to int so we can make the nessecary comparisons further down
    let eventYear = Number(date.slice(0, 4));
    let eventMonth = Number(date.slice(5, 7));
    let eventDay = Number(date.slice(8, 10));
    let eventHour = Number(time.slice(0, 2));

    end = changeTime(timeEnd);
    time = changeTime(time);
    timeEnd = changeTime(timeEnd);

    // console.log(time + ' ' + timeEnd);


    let monthsArr = ['January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var weeks = currentMonth.getWeeks();
    document.getElementById('monthAndYear').innerHTML = monthsArr[currentMonth.month] + ' ' + currentMonth.year;
    for (var w in weeks) {
        var days = weeks[w].getDates()
        //only shows events for the current month

        for (var d in days) {
            if (currentMonth.month == days[d].getMonth()) {
                dayId = days[d].getDate() + '';
                //check if event year, month and day matches
                if (eventYear == days[d].getFullYear() && eventMonth == days[d].getMonth() + 1 && eventDay == days[d].getDate()) {
                    //html event_id is based on mysql id
                    eventId = 'event' + id;
                    day = document.getElementById(dayId);
                    //create div for event
                    let eventDiv = document.createElement("div");
                    eventDiv.setAttribute('id', eventId);
                    eventDiv.setAttribute('class', 'events');
                    // eventDiv.setAttribute('style', 'border:1px;');

                    //display title for event
                    let eventTitle = document.createElement('p');
                    eventTitle.appendChild(document.createTextNode(title));
                    eventTitle.setAttribute('class', 'eventTitle');
                    eventTitle.appendChild(document.createElement('BR'));

                    //display the time for event
                    let eventTime = document.createElement('small');
                    eventTime.appendChild(document.createTextNode(time + '-' + timeEnd));
                    eventTime.setAttribute('class', 'eventTime');//display the time for event
                    // eventTime.appendChild(document.createElement('hr'));



                    //save all of the event attributes in the div so we can access them when its clicked
                    eventDiv.time = time + '-' + timeEnd;
                    eventDiv.title = title;
                    eventDiv.eventId = id;
                    eventDiv.date = date;
                    eventDiv.appendChild(eventTitle);
                    eventDiv.appendChild(eventTime);
                    day.appendChild(eventDiv);
                    // $('#' + eventId).setAttribute('style', 'backgound-color:pink');
                    //when div is click the event will pop up
                    document.getElementById(eventId).addEventListener("click", eventPopUp);
                }
            }
        }
    }
}
//close event popup
document.getElementById('closeEventBtn').addEventListener('click', closeEvent);

//Pops up when event div that is displayed in calendar view is clicked
function eventPopUp(event) {
    let popUp = document.getElementById('eventPopUp');
    //empty the previous selected event details
    if (!popUp.hidden) {
        document.getElementById('eventTextArea').innerHTML = "";
        popUp.hidden = true;
    }
    //heading is the title of the event
    let heading = document.createElement('h5');
    heading.appendChild(document.createElement('BR'));
    heading.appendChild(document.createTextNode(event.currentTarget.title));
    heading.setAttribute('id', 'popHeading');
    //details contains the date and time of event
    let details = document.createElement('p');
    details.setAttribute('id', 'popDetails');
    details.appendChild(document.createTextNode(event.currentTarget.date));
    details.appendChild(document.createElement('BR'));
    details.appendChild(document.createTextNode(' ' + event.currentTarget.time));
    document.getElementById('eventTextArea').appendChild(heading);
    document.getElementById('eventTextArea').appendChild(details);
    //show the popup
    popUp.hidden = false;
}
//close the event popup and go back to page was before event was clicked
function closeEvent() {
    document.getElementById('eventTextArea').style.display = 'block';
    document.getElementById('eventPopUp').hidden = true;
    document.getElementById('eventTextArea').innerHTML = '';
}

//when next month button is pressed
document.getElementById("nextBtn").addEventListener("click", function (event) {
    currentMonth = currentMonth.nextMonth();
    //document.getElementById('calendarTable').innerHTML="<thead><tr><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednseday</th><th>Thursday</th><th>Friday</th><th>Saturday</th></tr></thead>";
    generateMonth();
    updateCalendar();
    // window.location.reload();
}, false);
//when previous month button is pressed
document.getElementById("prevBtn").addEventListener("click", function (event) {
    currentMonth = currentMonth.prevMonth(); // Previous month would be currentMonth.prevMonth()
    //document.getElementById('calendarTable').innerHTML="<thead><tr><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednseday</th><th>Thursday</th><th>Friday</th><th>Saturday</th></tr></thead>";
    generateMonth();
    updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
}, false);

//generates calendar table for the currentMonth
function generateMonth() {
    let monthsArr = ['January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var weeks = currentMonth.getWeeks();
    document.getElementById('monthAndYear').innerHTML = monthsArr[currentMonth.month] + ' ' + currentMonth.year;
    document.getElementById('calendarTable').innerHTML = "<thead><tr><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednseday</th><th>Thursday</th><th>Friday</th><th>Saturday</th></tr></thead>";
    let i = 1;
    for (var w in weeks) {
        var days = weeks[w].getDates();
        let tableRow = document.createElement("tr");
        tableRow.setAttribute('id', 'row' + i);
        i += 1;
        let week = document.getElementById('calendarTable').appendChild(tableRow);
        let nextMonthDays = document.createElement("th");
        for (var d in days) {
            if (currentMonth.month == days[d].getMonth()) {
                dayId = days[d].getDate() + '';
                day = week.innerHTML += '<th class="day" id="' + dayId + '">' + days[d].getDate() + '</th>';
            }
            else {
                day = week.innerHTML += '<th class="otherDay">' + monthsArr[days[d].getMonth()] + ' ' + days[d].getDate() + '</th>';
            }
        }
    }
}




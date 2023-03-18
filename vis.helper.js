var view =
{
  'start':0,
  'end':0,

  'zoomout':function ()
  {
    var time_window = this.end - this.start;
    var middle = this.start + time_window / 2;
    time_window = time_window * 2;
    this.start = middle - (time_window/2);
    this.end = middle + (time_window/2);
  },

  'zoomin':function ()
  {
    var time_window = this.end - this.start;
    var middle = this.start + time_window / 2;
    time_window = time_window * 0.5;
    this.start = middle - (time_window/2);
    this.end = middle + (time_window/2);
  },

  'panright':function ()
  {
    var time_window = this.end - this.start;
    var shiftsize = time_window * 0.2;
    this.start += shiftsize;
    this.end += shiftsize;
  },

  'panleft':function ()
  {
    var time_window = this.end - this.start;
    var shiftsize = time_window * 0.2;
    this.start -= shiftsize;
    this.end -= shiftsize;
  },

  'timewindow':function(time)
  {
    this.start = ((new Date()).getTime())-(3600000*24*time);	//Get start time
    this.end = (new Date()).getTime();	//Get end time
  }
}

function tooltip(x, y, contents, bgColour, borderColour="rgb(255, 221, 221)")
{
    var offset = 10; // use higher values for a little spacing between `x,y` and tooltip
    var elem = $('<div id="tooltip">' + contents + '</div>').css({
        position: 'absolute',
        color: "#000",
        display: 'none',
        'font-weight':'bold',
        border: '1px solid '+borderColour,
        padding: '2px',
        'background-color': bgColour,
        opacity: '0.8',
        'text-align': 'left'
    }).appendTo("body").fadeIn(200);

    var elemY = y - elem.height() - offset;
    var elemX = x - elem.width()  - offset;
    if (elemY < 0) { elemY = 0; } 
    if (elemX < 0) { elemX = 0; } 
    elem.css({
        top: elemY,
        left: elemX
    });
}

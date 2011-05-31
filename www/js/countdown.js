function displayTime()
{
  document.getElementById('cd_timer_seconds').innerHTML = seconds;
  // days
  if (days < 10)
  {
    var disp_days = '0'+days;
    document.getElementById('cd_timer_days').innerHTML = disp_days;
  }
  else
  {
    var disp_days = days;
    document.getElementById('cd_timer_days').innerHTML = disp_days;
  }
  
  // hours
  if (hours < 10)
  {
    var disp_hours = '0'+hours;
    document.getElementById('cd_timer_hours').innerHTML = disp_hours;
  }
  else
  {
    var disp_hours = hours;
    document.getElementById('cd_timer_hours').innerHTML = disp_hours;
  }
  
  // minutes
  if (minutes < 10)
  {
    var disp_minutes = '0'+minutes;
    document.getElementById('cd_timer_minutes').innerHTML = disp_minutes;
  }
  else
  {
    var disp_minutes = minutes;
    document.getElementById('cd_timer_minutes').innerHTML = disp_minutes;
  }

  // seconds
  if (seconds < 10)
  {
    var disp_seconds = '0'+seconds;
    document.getElementById('cd_timer_seconds').innerHTML = disp_seconds;
  }
  else
  {
    var disp_seconds = seconds;
    document.getElementById('cd_timer_seconds').innerHTML = disp_seconds;
  }
}

function updateTime()
{

  if (count_down == true)
  {
    if (seconds == 0)
    {
      if (minutes == 0)
      {
        if (hours == 0)
        {
          if (days == 0)
          {
            setTimeout(window.location="/", 3000);
          }
          else
          {
            days--;
            hours = 23;
            minutes = 59;
            seconds = 59;
          }
        }
        else
        {
          hours--;
          minutes = 59;
          seconds = 59;
        }
      }
      else
      {
      minutes--;
      seconds = 59;
      }
    }
    else
    {
      seconds--;
    }
  }
  else
  {
    if (seconds == 59)
    {
      if (minutes == 59)
      {
        if (hours == 23)
        {
          days++;
          hours = 0;
          minutes = 0;
          seconds = 0;
        }
        else
        {
          hours++;
          minutes = 0;
          seconds = 0;
        }
      }
      else
      {
      minutes++;
      seconds = 0;
      }
    }
    else
    {
      seconds++;
    }
  }
  displayTime();
}


// Run on load
displayTime();
if (paused == false)
  setInterval("updateTime()", 1000);
else
  updateTime();
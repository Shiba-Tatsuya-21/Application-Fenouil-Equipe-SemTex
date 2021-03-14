   function validate_decimal(evt) {
      var theEvent = evt || window.event;
      
      // Handle paste
      if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
      } else {
      // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
      }
      var regex = /[0-9]|\./;
      
      
      if( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
      }
      }
      
      function validate_integer(evt) {
      var theEvent = evt || window.event;
      
      // Handle paste
      if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
      } else {
      // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
      }
      var regex = /[0-9]/;
      if( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
      }
}

function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
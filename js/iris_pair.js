// Function for reading cookies

(function () {
  var cookies;

  function readCookie(name, c, C, i) {
    if (cookies) {
      return cookies[name];
    }

    c = document.cookie.split('; ');
    cookies = {};

    for (i = c.length - 1; i >= 0; i--) {
      C = c[i].split('=');
      cookies[C[0]] = C[1];
    }

    return cookies[name];
  }

  window.readCookie = readCookie;
  
})();

var iris = {};

iris.url = decodeURIComponent(readCookie("Drupal.visitor.iris_server"));

iris.credentials = {
  "userid": readCookie("Drupal.visitor.iris_userid"),
  "token": readCookie("Drupal.visitor.iris_token"),
};

var socket = io(iris.url);

socket.on("connect", function () {

  if (iris.credentials.userid) {

    socket.emit('pair', {
      credentials: iris.credentials
    });

  } else {
    
    console.info("Anonymous connected with Iris")
    
  }

});

// Get authPass back from server if paired with a Iris session

socket.on("pair", function (result) {

  if (result) {

    jQuery.ajax({
      url: iris.url + "/auth/checkauth",
      data: {
        credentials: iris.credentials
      }
    }).done(function (data) {

      // Example call saving the authPass from Iris

      iris.authPass = data;

    });

    console.info("Paired with Iris");

  }

})

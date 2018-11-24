
importScripts('https://www.gstatic.com/firebasejs/5.5.7/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-messaging.js');

firebase.initializeApp({
  'messagingSenderId': '388763301424'
});

var messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
  //console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  /*var notificationTitle = 'Doctor is calling';
  var notificationOptions = {
    body: 'Call from doctor for everybody',
    icon: './demo/dofody/dist/img/logo.png'
  };*/
  console.log(payload);
  
  /*return self.registration.showNotification(notificationTitle,
    notificationOptions);*/
   // window.alert('doctor is calling');
});

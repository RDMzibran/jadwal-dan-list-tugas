// Import SDK Firebase di dalam Service Worker
importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js");
importScripts(
  "https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js",
);

// Konfigurasi Firebase v8 yang sinkron dengan index.html kamu
const firebaseConfig = {
  apiKey: "AIzaSyAghFvNck1H1H_Yq4Wsr2iwG9kT2utBmFAQ",
  authDomain: "jadwalkuliah-aefbb.firebaseapp.com",
  projectId: "jadwalkuliah-aefbb",
  storageBucket: "jadwalkuliah-aefbb.firebasestorage.app",
  messagingSenderId: "411828073455",
  appId: "1:411828073455:web:15b90e84695871eeca3c1a",
  measurementId: "G-RF7LY35TDG",
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

// Menangani data notifikasi yang masuk saat browser ditutup
messaging.onBackgroundMessage(function (payload) {
  console.log("Notifikasi masuk di background:", payload);

  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: "icon.png", // Sediakan file icon.png di foldermu jika ingin menambahkan ikon khusus
    badge: "icon.png",
  };

  return self.registration.showNotification(
    notificationTitle,
    notificationOptions,
  );
});

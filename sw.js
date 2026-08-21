self.addEventListener("install", (event) => {
    console.log("Service Worker instalado");
    self.skipWaiting(); // activa inmediatamente
});

self.addEventListener("activate", (event) => {
    console.log("Service Worker activo");
    return self.clients.claim(); // toma control de la página
});


// 📩 Aquí recibes notificaciones push del backend
self.addEventListener("push", (event) => {

    let data = {
        title: "Nuevo mensaje",
        body: "Tienes un nuevo mensaje",
        url: "/"
    };

    if (event.data) {
        data = event.data.json();
    }

    const options = {
        body: data.body,
        icon: "/public/img/SuTra_icon.png", // cambia esto por tu icono
        badge: "/public/img/SuTra_icon.png",
        data: {
            url: data.url || "/"
        }
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});


// 🖱️ Click en la notificación
self.addEventListener("notificationclick", (event) => {
    event.notification.close();

    const url = event.notification.data?.url || "/";

    event.waitUntil(
        clients.matchAll({ type: "window", includeUncontrolled: true }).then((clientList) => {

            // Si ya hay una ventana abierta, la enfoca
            for (const client of clientList) {
                if (client.url.includes(url) && "focus" in client) {
                    return client.focus();
                }
            }

            // Si no hay, abre una nueva
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});
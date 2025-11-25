// const express = require('express');
// const http = require('http');
// const socketio = require('socket.io');

// const app = express();
// const server = http.createServer(app);
// const io = socketio(server, { 
//     cors: { 
//         origin: "*",
//         methods : ['GET', 'POST'],
//     } 
// });

// io.on("connection", (socket) => {
//     console.log("Cliente conectado");

//     socket.on("join_ticket", (ticketId) => {
//         socket.join(ticketId);
//         console.log(`Cliente se unió a la sala del ticket: ${ticketId}`);
//     });

//     socket.on("recibir_mensaje", (data) => {
//         console.log("Mensaje recibido del cliente:", data);
//         console.log("Reenviando a sala:", data.ticketId);
//         socket.to(data.ticketId).emit("recibir_mensaje", data);
//     });
    

//     socket.on("disconnect", () => {
//         console.log("Cliente desconectado");
//     });
// });

// server.listen(8082, () => {
//     console.log("WebSocket corriendo en puerto 8082");
// });

const express = require('express');
const https = require('https');
const socketio = require('socket.io');
const fs =  require('fs');
const app = express();
//const server = http.createServer(app);

const server = https.createServer({
    cert: fs.readFileSync('/etc/letsencrypt/live/support-tracking.tecnologisticaaduanal.com/fullchain.pem'),
    key: fs.readFileSync('/etc/letsencrypt/live/support-tracking.tecnologisticaaduanal.com/privkey.pem'),
    passphrase: 'sistemasadmin'
});

const io = socketio(server, { 
    cors: { 
        origin: "*",
        methods : ['GET', 'POST'],
    } 
});

io.on("connection", (socket) => {
    console.log("Cliente conectado");

    socket.on("join_ticket", (ticketId) => {
        socket.join(ticketId);
        console.log(`Cliente se unió a la sala del ticket: ${ticketId}`);
    });

    socket.on("recibir_mensaje", (data) => {
        console.log("Mensaje recibido del cliente:", data);
        console.log("Reenviando a sala:", data.ticketId);
        socket.to(data.ticketId).emit("recibir_mensaje", data);
    });
    

    socket.on("disconnect", () => {
        console.log("Cliente desconectado");
    });
});

server.listen(8082, "0.0.0.0", () => {
    console.log("WebSocket corriendo en puerto 8082");
});


// const express = require('express');
// const https = require('https');
// const socketio = require('socket.io');

// const server = https.createServer({
//     cert: fs.readFileSync('/etc/letsencrypt/live/support-tracking.tecnologisticaaduanal.com/fullchain.pem'),
//     key: fs.readFileSync('/etc/letsencrypt/live/support-tracking.tecnologisticaaduanal.com/privkey.pem'),
//     passphrase: 'sistemasadmin'
// });

// const app = express();
// //const server = http.createServer(app);
// const io = socketio(server, { 
//     cors: { 
//         origin: "*",
//         methods : ['GET', 'POST'],
//     } 
// });

// app.get("/notificar-ticket", (req, res) => {

//     const { tick_id, usu_id, mensaje } = req.query;
//     console.log("PUSH");
//     io.to(usu_id).emit("nuevo_mensaje", {
//         tick_id,
//         mensaje
//     });

//     res.send("ok");
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
    
//     socket.on("join_user", (userId) => {
//     socket.join(userId);
// });

//     socket.on("join_user", (userId) => {
//         const room = String(userId);
//         socket.join(userId);
//         console.log("Usuario unido a room:", userId);
//     });
    

//     socket.on("disconnect", () => {
//         console.log("Cliente desconectado");
//     });
// });

//     app.get("/notificar-ticket", (req, res) => {

//         const { tick_id, usu_id, mensaje } = req.query;

//         const room = String(usu_id);

//         io.to(usu_id).emit("nuevo_mensaje", {
//             tick_id,
//             mensaje
//         });

//         res.send("ok");
//     });

// server.listen(8082, () => {
//     console.log("WebSocket corriendo en puerto 8082");
// });

const express = require('express');
const https = require('https');
const socketio = require('socket.io');
const fs =  require('fs');
const app = express();
// const server = http.createServer(app);



const server = https.createServer({
    cert: fs.readFileSync('/etc/letsencrypt/live/support-tracking.tecnologisticaaduanal.com/fullchain.pem'),
    key: fs.readFileSync('/etc/letsencrypt/live/support-tracking.tecnologisticaaduanal.com/privkey.pem'),
    passphrase: 'sistemasadmin'
});

// const server = http.createServer(app);
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
    
    socket.on("join_user", (userId) => {
        const room = String(userId);
        socket.join(userId);
        console.log("Usuario unido a room:", userId);
    });

    socket.on("disconnect", () => {
        console.log("Cliente desconectado");
    });
});

app.get("/notificar-ticket", (req, res) => {

    const { tick_id, usu_id, mensaje } = req.query;

    const room = String(usu_id);

    io.to(usu_id).emit("nuevo_mensaje", {
        tick_id,
        mensaje
    });

    res.send("ok");
});

server.listen(8082, "0.0.0.0", () => {
    console.log("WebSocket corriendo en puerto 8082");
});


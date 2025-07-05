const express = require('express');
const http = require('http');
const socketio = require('socket.io');

const app = express();
const server = http.createServer(app);
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

    socket.on("nuevo_mensaje", (data) => {
        console.log("Mensaje recibido del cliente:", data);
        console.log("Reenviando a sala:", data.ticketId);
        io.to(data.ticketId).emit("recibir_mensaje", data);
    });
    

    socket.on("disconnect", () => {
        console.log("Cliente desconectado");
    });
});


server.listen(8082, () => {
    console.log("WebSocket corriendo en puerto 8082");
});

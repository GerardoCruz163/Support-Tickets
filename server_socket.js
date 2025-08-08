// socketServer.js
const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const cors = require('cors');

const app = express();
app.use(cors());

const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: "*", // permite conexiones desde cualquier origen (puedes restringirlo si quieres)
        methods: ["GET", "POST"]
    }
});

// Manejo de conexiones
io.on('connection', (socket) => {
    console.log('Usuario conectado:', socket.id);

    // Recibe mensaje y lo reenvía a todos los demás
    socket.on('nuevo_mensaje', (data) => {
        console.log('Mensaje recibido:', data);

        // Enviar el mensaje a todos excepto al emisor
        socket.broadcast.emit('nuevo_mensaje', data);
    });

    socket.on('disconnect', () => {
        console.log('Usuario desconectado:', socket.id);
    });
});

// Levanta el servidor en un puerto (ej. 3021)
const PORT = 3082;
server.listen(PORT, () => {
    console.log(`✅ WebSocket Server corriendo en http://localhost:${PORT}`);
});

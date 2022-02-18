const express = require ('express');
const cors = require ('cors');
const mysql = require('mysql');
const bodyParser = require ('body-parser');
const fs = require('fs').promises;
const {v4: uuidv4} = require ('uuid');
const path = require('path');
const multer = require('multer');

const PORT = process.env.PORT || 3000;

const app = express();
app.use(cors());
app.use(bodyParser.urlencoded({
    extended: false
  }));
app.use(bodyParser.json());
 
var conexion = mysql.createConnection({
    host: "bqxxg5gdpjpsoxtwpx3b-mysql.services.clever-cloud.com",
    user: "ux9jmxckmj5buvro",
    password: "IjNijqvWvaYQ7CLkFjJr",
    database: "bqxxg5gdpjpsoxtwpx3b",
    multipleStatements: true
});

conexion.connect(error =>{
    if(error) throw error;
    console.log('Conexion exitosa') 
});


app.listen(PORT,()=> console.log(`Server runing on port ${PORT}`))

app.get('/', (req, res) =>{
    res.send('Bienvenido')
});

 // Ruta para guardar imagenes
 app.use('/uploads', express.static(path.join(__dirname, 'uploads')));
 const storage = multer.diskStorage({
     destination: (req, file, callBack) => {
         callBack(null, 'uploads')
     },
     filename: (req, file, callBack) => {

         callBack(null, file.originalname)
     }
 });
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

         const upload = multer({ storage: storage })

 
 app.get("/upload", (req, res) => {
    conexion.query('SELECT products.product_name,files.file_id,files.name, files.path as imagen FROM products INNER JOIN files ON products.product_id = files.id_producto where products.product_id = 1 and files.produc_id = 1;', (err, rows, fields) => {
        if (!err) {
            res.json(rows);
        } else {
            console.log(err);
        }
    });
});

app.post('/file', upload.array('files'), (req, res, next) => {
    const files = req.files;
    

    if (!files) {
        const error = new Error('No File')
        error.httpStatusCode = 400;
        return next(error)
    }
    
        const sql = 'select product_id from products order by product_id desc limit 1;';
     
        conexion.query(sql,(error, results) => {
            if (error) throw error;
            console.log(error);
            if (results.length > 0){
                res.json(results)
                const data = results[0].product_id;
                for (let clave in files) {
                    const file = files[clave];
                    const nombreArchivo = /*uuidv4().concat*/(file.filename);
                    const direccion = file.path;
                    conexion.query('INSERT INTO files (name,path,product_id) values (? , ?, ?)', [nombreArchivo,direccion,data]);
                  }
            }else{
                res.send('No hay resultados')
            } 

    })

});
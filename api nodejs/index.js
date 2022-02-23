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
 
var pool = mysql.createPool({
    host: "162.241.62.187",
    user: "storerpp_admin",
    password: "91HXzMLZE7rF",
    database: "storerpp_db",
    multipleStatements: true
});

//mysql.connect(error =>{
  //  if(error) throw error;
   // console.log('Conexion exitosa') 
//});


app.listen(PORT,()=> console.log(`Server runing on port ${PORT}`))

app.get('/', (req, res) =>{
    res.send('Bienvenido')
});

 // Ruta para guardar imagenes
 app.use('/uploads', express.static(path.join(__dirname,'uploads')));
 const storage = multer.diskStorage({
     destination: (req, file, callBack) => {
         callBack(null, 'uploads')
     },
     filename: (req, file, callBack) => {

         callBack(null, uuidv4().concat(file.originalname))
     }
 });

         const upload = multer({ storage: storage })

 
 app.get("/upload", (req, res) => {
    pool.query('SELECT * FROM files;', (err, rows, fields) => {
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
     
        pool.query(sql,(error, results) => {
            if (error) throw error;
            console.log(error);
            if (results.length > 0){
                res.json(results)
                const data = results[0].product_id;
                for (let clave in files) {
                    const file = files[clave];
                    const nombreArchivo = /*uuidv4().concat*/(file.filename);
                    const direccion = file.path;
                    pool.query('INSERT INTO filesproducts (name,path,product_id) values (? , ?, ?)', [nombreArchivo,direccion,data]);
                  }
            }else{
                res.send('No hay resultados')
            } 

    })

});

//Imagenes de servicios
app.post('/fileservices', upload.array('files'), (req, res, next) => {
    const files = req.files;
    
    if (!files) {
        const error = new Error('No File')
        error.httpStatusCode = 400;
        return next(error)
    }
    
        const sql = 'select service_id from services order by service_id desc limit 1;';
     
        pool.query(sql,(error, results) => {
            if (error) throw error;
            console.log(error);
            if (results.length > 0){
                res.json(results)
                const data = results[0].service_id;
                for (let clave in files) {
                    const file = files[clave];
                    const nombreArchivo = /*uuidv4().concat*/(file.filename);
                    const direccion = file.path;
                    pool.query('INSERT INTO filesservices (name,path,service_id) values (? , ?, ?)', [nombreArchivo,direccion,data]);
                  }
            }else{
                res.send('No hay resultados')
            } 

    })

});

/*app.get('/productoimagen/:product_id',(req , res) =>{
    const {product_id} = req.params;
    const sql = `select * from files where product_id = ${product_id} order by product_id desc  limit 1;`
 
    pool.query(sql,(error, results) => {
        if (error) throw error;
        console.log(error);
        if (results.length > 0){
            res.json(results)
        }else{
            res.send('No hay resultados')
        } 
    })
});*/

app.get('/listaimagen/:product_id',(req , res) =>{
    const {product_id} = req.params;
    const sql = `select * from filesproducts where product_id = ${product_id} ;`
 
    pool.query(sql,(error, rows) => {
        if (error) throw error;
        console.log(error);
        if (rows.length > 0){
            res.json(rows)
            
        }else{
            res.send('No hay resultados')
        } 
    })
});

//Obtiene ultimo registro de producto
app.get('/productoimagen/:vendor_id',(req , res) =>{
    const {vendor_id} = req.params;
    const sql = `select * from products where vendor_id = ${vendor_id} order by product_id desc  limit 1;`
 
    pool.query(sql,(error, results) => {
        if (error) throw error;
        console.log(error);
        if (results.length > 0){
            res.json(results)
        }else{
            res.send('No hay resultados')
        } 
    })
});


//Obtiene ultimo registro de servicio
app.get('/servicioimagen/:vendor_id',(req , res) =>{
    const {vendor_id} = req.params;
    const sql = `select * from services where vendor_id = ${vendor_id} order by service_id desc  limit 1;`
 
    pool.query(sql,(error, results) => {
        if (error) throw error;
        console.log(error);
        if (results.length > 0){
            res.json(results)
        }else{
            res.send('No hay resultados')
        } 
    })
});



//gabo@mail.com
//123456789
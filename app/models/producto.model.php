<?php
//incluyo el config.php el cual se encarga de la conexion a la db
require_once("config.php");
class ProductoModel{
    //atributo
    private $db;

    //constructor
    function __construct(){
        $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";" . DB_Charset , DB_USER , DB_PASS);
    }

    //metodos

    //esta funcion obtiene y devuelve de la base de datos todos los productos
    public function getProductos(){
        //envía la consulta SQL para obtener todos los productos 
        $query = $this->db->prepare("SELECT * FROM productos");
        $query->execute();
        $productos = $query->fetchAll(PDO::FETCH_OBJ);

        return $productos;
    }

    //esta funcion obtiene y devuelve de la base de datos todos los productos de una determinada categoria.
    public function getProductosXCategoria($id_fk){
        //envío la consulta para obtener los productos de una categoría específica
        $query = $this->db->prepare("SELECT * FROM productos WHERE id_categoria = ?");
        $query->execute([$id_fk]);
    
        //$productosXCategoria es un arreglo de productos por una determinada categoria
        $productosXCategoria = $query->fetchAll(PDO::FETCH_OBJ);
    
        return $productosXCategoria;
    }

    //esta funcion obtiene un producto determinado para mostrar sus detalles (los atributos material,color,precio)
    public function getProducto($id){
        $query = $this->db->prepare("SELECT id_categoria,material,color,precio FROM productos WHERE id_producto = ?");
        $query->execute([$id]);

        $producto = $query->fetch(PDO::FETCH_OBJ);
        return $producto;
    }

    public function agregarProducto($id_categoria,$nombre,$material,$color,$precio){
        //blindeo(Protego) los parametreos con VALUES(?,?,?,?,?) (seguridad)
        $query = $this->db->prepare("INSERT INTO productos (id_categoria,nombre,material,color,precio)VALUES(?,?,?,?,?)");
        $query->execute([$id_categoria,$nombre,$material,$color,$precio]);

        return $this->db->lastInsertId();
    }

    public function eliminarProducto($id){
        $query = $this->db->prepare("DELETE FROM productos WHERE id_producto = ?");
        $query->execute([$id]);
    }
}
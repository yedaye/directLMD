<?php
class Etudiant{
  
    // database connection and table name
    private $conn;
    private $table_name1 = "products";
    private $table_name2 = "inscription";
  
    // object properties
    public $matricule;
    public $nom;
    public $prenoms;
    public $date_naissance;
    public $lieu_naissance;
    public $entite;
    public $libspecialite;
    public $codspecialite;
    public $codeanetude;
    public $telephone;
    public $emailperso;
    public $emailuak;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
        // select all query
        $query = "SELECT student.matricule,nom, prenoms,date_naissance,lieu_naissance,filiere,telephone, email, email_uak FROM `student`,inscription WHERE inscription.matricule=student.matricule";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create product
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->created);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // used when filling up the update product form
    function readOne(){
    
        // query to read single record
/*         $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                WHERE
                    p.id = ?
                LIMIT
                    0,1"; */
            
        $query = "SELECT student.matricule,nom, prenoms,date_naissance,lieu_naissance, ecole, libelle, filiere,telephone, email, email_uak FROM `student`,inscription,filiere WHERE annee_academique=? AND inscription.matricule=student.matricule AND filiere.code=inscription.filiere";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of product to be updated
       $stmt->bindParam(1, $this->annee);
    
        // execute query
        $stmt->execute();
        
        return $stmt;
       
    }
}
?>
<?php

    include 'db.php';

    //récuperer le type de la methode http : GET? POST? PUT? DELETE?    
    $method = $_SERVER['REQUEST_METHOD'];

    if($method=='GET'){
        
        $id=$_GET["id"];
        
        if($id==null){
            $sql = "SELECT date,text,compte_id FROM publications ORDER BY date DESC";
        }else{
            $sql = "SELECT date,text,compte_id FROM publications WHERE compte_id=$id ORDER BY date DESC";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $html = "";

        $i=0;

        while($i<count($publications)){
            $date = new DateTime($publications[$i]["date"]);
            $dateformat = $date->format('d M y');

            $text = $publications[$i]["text"];
            $compte_id = $publications[$i]["compte_id"];

            $html = $html."<h3>Le $dateformat</h3><h5>User nº$compte_id à écrit:</h5><p>$text</p>";
            
            $i++;
        }
        echo $html;
    }
?>
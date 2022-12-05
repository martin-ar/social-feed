<?php

  include  'db.php';

  $method = $_SERVER['REQUEST_METHOD'];

  if($method=='GET'){
    
    $sql = "SELECT id,prenom,nom FROM comptes";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $html = "";

    $i = 0;

    while($i<count($users)){

      $prenom =$users[$i]["prenom"];
      $nom = $users[$i]["nom"];
      $id = $users[$i]["id"];
      $html = $html."<p class='user' onclick='getPublications($id)'>$prenom $nom<span class='delete' onclick='deleteUser($id)'> X</span> </p>";
      $i++;
    }
    echo $html;
  }

  if($method=='POST'){  
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    $sql = "INSERT INTO comptes(prenom,nom,mail,password)
            VALUES('$prenom','$nom','$mail','$password')";
    
    $stmt = $conn->prepare($sql);
    if($stmt->execute()){
      echo 'Le compte a été ajouté';
    }else{
      echo 'Erreur';
    }
  }

  if($method=='DELETE'){
    $id = $_GET['id'];

    $sql="DELETE FROM comptes WHERE id=$id; DELETE FROM publications WHERE compte_id=$id";

    $stmt = $conn->prepare($sql);

    if ($stmt->execute()){
      echo 'Le compte à été supprimé';
    }else{
      echo 'Erreur';
    }
    
  }

?>
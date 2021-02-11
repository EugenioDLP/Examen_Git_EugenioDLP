<?php
require './ClassEnvioMail.php';
require 'vendor/autoload.php';

class Cliente {
    //Estado
    private $dni;
    private $nombre;
    private $apellidos;
    private $fnac;
    private $email;

    //Comportamiento

    function __construct($dni,$nombre,$apellidos,$fnac,$email) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fnac = $fnac;
        $this->email = $email;


        
    }

    //darse de alta
    function darAlta($conn) {
        // Consulta para realizar inserción a la base de datos

        $sql = "INSERT INTO Clientes (dni,nombre,apellidos,fnac,email) VALUES ('".$this->dni."','".$this->nombre."','".$this->apellidos."','".$this->fnac."','".$this->email."');";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            //hago la construccion del email y lo mando
            $miEmail = new envioEmail($this->email);
            $miEmail->sendMail();
        
    
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }


    }

    function asignarEmail($nuevoEmail) {
      $this->email = $nuevoEmail;
    }
    
    //Buscar un/unos cliente/s dentro de la BBDD y mostrarlo por pantalla
    function buscar($busqueda,$tipoBusqueda,$conn) {

        // Consulta para realizar la búsqueda en la base de datos
        $sql = "SELECT * FROM Clientes WHERE ";
        switch ($tipoBusqueda){
        case "onom":
          $sql = $sql."nombre like '%$busqueda%';";
        break;
        case "oape":
          $sql = $sql."apellidos like '%$busqueda%';";
        break;
        case "omail":
          $sql = $sql."email like '%$busqueda%';";
        break;
        case "odni":
          $sql = $sql."dni like '%$busqueda%';";
        break;
        default:
          echo "Se ha producido un error durante la búsqueda.";
      }

      $resultado = $conn->query($sql);

      // Consulta para realizar la busqueda en la base de datos
      if ($resultado->num_rows > 0) {
        // Salida de datos por cada fila
        while($row = $resultado->fetch_assoc()) {
          echo "- Nombre: ".$row["nombre"].", Apellidos: ".$row["apellidos"].", Email: ".$row["email"].", DNI: ".$row["dni"]."<br>";
        }
      }else{
        echo "No se han encontrado resultados.";
      }
    }


   }

?>

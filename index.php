<!DOCTYPE html>
<html>
<head>
    <title>Formulaire d'insertion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: red;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            color: #333;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<h2>Formulaire d'insertion</h2>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom"><br><br>
    
    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom"><br><br>
    
    <input type="submit" name="submit" value="Insérer">
</form>

<?php
// Informations de connexion à la base de données MySQL
$servername = "mysql"; // Service name of MySQL
$username = "root"; // MySQL username
$password = "rootroot"; // MySQL password
$database = "test"; // Nom de la base de données

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Créer une connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $database);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données : " . $conn->connect_error);
    }

    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];

    // Requête SQL d'insertion
    $sql = "INSERT INTO personne (nom, prenom) VALUES (?, ?)";

    // Préparation de la requête
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    // Liaison des paramètres
    $stmt->bind_param("ss", $nom, $prenom);

    // Exécution de la requête
    if ($stmt->execute() === false) {
        die("Échec de l'exécution de la requête : " . $stmt->error);
    }

    echo "<p>Données insérées avec succès : $nom $prenom</p>";

    // Fermer la connexion
    $stmt->close();
    $conn->close();
}

// Afficher le contenu de la table personne
echo "<h2>Contenu de la table personne :</h2>";

// Créer une nouvelle connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Requête SQL de sélection
$sql_select = "SELECT nom, prenom FROM personne";

// Exécution de la requête
$result = $conn->query($sql_select);

// Vérifier si des résultats ont été trouvés
if ($result->num_rows > 0) {
    // Afficher les données dans un tableau HTML
    echo "<table>";
    echo "<tr><th>Nom</th><th>Prénom</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["nom"]."</td><td>".$row["prenom"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "Aucun résultat trouvé dans la table personne.";
}

// Fermer la connexion
$conn->close();
?>

</body>
</html>

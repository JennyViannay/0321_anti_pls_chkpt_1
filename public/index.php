<?php
require '../connec.php';

$pdo = new PDO(DSN, USER, PASS);

// SECTION LIST STUDENTS
$students = $pdo->query("SELECT * FROM student")->fetchAll(PDO::FETCH_ASSOC);

// SECTION FORMULAIRE ADD STUDENT
$error = "";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!empty($_POST['name']) && !empty($_POST['age'])) {
        $query = "INSERT INTO student (name, age) VALUES (:name, :age)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $statement->bindValue(':age', $_POST['age'], PDO::PARAM_INT);
        $statement->execute();
        header('Location: index.php');
    } else {
        $error = "Tous les champs sont requis";
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Revisions Anti PLS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>

<body>
    <div class="container p-5 text-center">
       
        <section class="list">
            <!-- ICI TOUS LES ETUDIANTS -->
            <ul>    
                <?php 
                $count = 0;
                foreach ($students as $student) { 
                    $count += $student['age'];
                ?>
                <li><?= $student['name'] ." a " .$student['age'] ." ans"; ?></li>
                <?php } 
                echo "Age moyen " .$count / count($students);
                ?>
            </ul>
        </section>

        <section class="add">
            <h2>Ajouter un.e élève</h2>
            <!-- ca c'est la même chose que -->
            <?= $error ? $error : ''; ?>
            <!-- ça 
            if (!empty($error)) {
                echo $error;
            } -->
            <form method="POST">
                <label for="name">Prénom</label>
                <input type="text" name="name" id="name">

                <label for="age">Age</label>
                <input type="number" name="age" id="age">

                <button type="submit" name="pay">Ajouter !</button>
            </form>
        </section>
    </div>

</body>
</html>
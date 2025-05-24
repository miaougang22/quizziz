<?php
session_start();

$questions = [
    [
        'question' => "1 + 1 ?",
        'choices' => ["0", "1", "2", "3"],
        'answer' => "2"
    ],
    [
        'question' => "Comment s'appelle le frère de Mario, le héros de jeux vidéo ?",
        'choices' => ["Mahmoud", "Luigi", "Mamadou", "Wario"],
        'answer' => "Luigi"
    ],
    [
        'question' => "Quel est le plus grand pays du monde en superficie ?",
        'choices' => ["USA", "Russie", "Canada", "Chine"],
        'answer' => "Russie"
    ],
    [
        'question' => "En quelle année a eu lieu la fin de l'URSS ?",
        'choices' => ["1989", "1993", "1991", "1995"],
        'answer' => "1991"
    ],
    [
        'question' => "Qui est le chouchou de Anddy ?",
        'choices' => ["julien", "Vincent", "Ahmed", "Ines"],
        'answer' => "Ines"
    ],
    [
        'question' => "Qui a chanté All Eyez on Me ?",
        'choices' => ["Taylor Swift", "Cheb Khaled", "2pac", "21 Savage"],
        'answer' => "2pac"
    ],
    [
        'question' => "Quel peuple n'est pas un sujet de sa majesté le roi Charles III ?",
        'choices' => ["Canada", "Australie", "USA", "New Zealand"],
        'answer' => "USA"
    ]
    [
        'question' => "Quel équipe a gagné la ligue des champions 1967",
        'choices' => ["Jeunesse Sportive de kabylie", "AS Saint etienne", "Celtic Glasgow", "FC Bamako"],
        'answer' => "USA"
    ]
];

if (!isset($_SESSION['pos'])) {
    $_SESSION['pos'] = 0;
    $_SESSION['pts'] = 0;
    $_SESSION['ordre'] = array_keys($questions);
    shuffle($_SESSION['ordre']);
}

$pos = $_SESSION['pos'];
$total = count($questions);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $choixUtilisateur = $_POST['choix'] ?? '';
    $bonneReponse = $_POST['reponse_attendue'] ?? '';

    if ($choixUtilisateur === $bonneReponse) {
        $_SESSION['pts']++;
    }

    $_SESSION['pos']++;
    $pos = $_SESSION['pos'];
}

if (isset($_GET['reset'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz bêta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">

<?php if ($pos < $total): ?>
    <?php
    $idQ = $_SESSION['ordre'][$pos];
    $q = $questions[$idQ];
    $choix = $q['choices'];
    shuffle($choix);
    ?>
    <h4>Question <?= $pos + 1 ?>/<?= $total ?></h4>
    <p><?= htmlspecialchars($q['question']) ?></p>

    <form method="post">
        <?php foreach ($choix as $rep): ?>
            <div>
                <input type="radio" name="choix" value="<?= htmlspecialchars($rep) ?>" required>
                <?= htmlspecialchars($rep) ?>
            </div>
        <?php endforeach; ?>
        <input type="hidden" name="reponse_attendue" value="<?= htmlspecialchars($q['answer']) ?>">
        <button type="submit" class="btn btn-dark mt-3">Envoyer</button>
    </form>

<?php else: ?>
    <div class="alert alert-info">
        <h4>Fin du quiz</h4>
        <p>Score obtenu : <?= $_SESSION['pts'] ?> / <?= $total ?></p>
        <a href="?reset=1" class="btn btn-primary">Recommencer</a>
    </div>
<?php endif; ?>

</div>
</body>
</html>
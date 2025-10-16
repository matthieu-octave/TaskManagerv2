<!DOCTYPE html>
<html>

<head>
    <title>Nouvelle Tâche Assignée</title>
</head>

<body>
    <h1>Bonjour !</h1>
    <p>Une nouvelle tâche vous a été assignée :</p>
    <p><strong>Projet :</strong> {{ $task->project->title }}</p>
    <p><strong>Tâche :</strong> {{ $task->title }}</p>
    <p>Merci !</p>
</body>

</html>

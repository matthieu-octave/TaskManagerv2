# TaskManager - Gestionnaire de Tâches Collaboratif

TaskManager est une application web complète développée avec Laravel 12. Conçu comme un projet d'apprentissage approfondi, il couvre l'ensemble des fonctionnalités clés de l'écosystème Laravel, de l'authentification manuelle à la gestion des tâches en arrière-plan, en passant par un système d'autorisation basé sur les rôles.


---

## ✨ Fonctionnalités Clés

Ce projet intègre une large gamme de fonctionnalités qui démontrent une maîtrise complète du framework Laravel.

### Gestion des Projets & Tâches
- **CRUD complet pour les Projets :** Les utilisateurs peuvent créer, lire, modifier et supprimer leurs propres projets.
- **CRUD complet pour les Tâches :** Chaque projet possède ses propres tâches, avec la possibilité de les créer, les marquer comme terminées, et les supprimer.
- **Assignation de Tâches :** Une tâche peut être assignée à n'importe quel utilisateur enregistré dans l'application.
- **Relations Eloquent :** Utilisation propre des relations `One-to-Many` (Utilisateur -> Projets, Projet -> Tâches) et `BelongsTo`.

### Sécurité & Autorisations
- **Authentification Manuelle :** Le système d'inscription, de connexion et de déconnexion a été construit de A à Z, sans starter kit, pour une compréhension approfondie des mécanismes de session.
- **Protection des Routes :** Utilisation des middlewares (`auth`) pour protéger les zones de l'application.
- **Autorisations via Policies :** Un utilisateur ne peut voir, modifier ou supprimer que les ressources (projets, tâches) qui lui appartiennent. Toute tentative d'accès non autorisé renvoie une erreur 403.
- **Rôle Administrateur & Gates :** Un système de rôle simple (`is_admin`) a été mis en place, protégé par une `Gate`, pour donner accès à une section "Admin".

### Fonctionnalités Avancées & Professionnelles
- **Notifications par E-mail :** Un e-mail est automatiquement envoyé à un utilisateur lorsqu'une tâche lui est assignée.
- **Files d'Attente (Queues) :** L'envoi des e-mails est délégué à une file d'attente (avec le driver `database`) pour ne pas ralentir l'interface utilisateur et garantir une expérience fluide.
- **Tests Automatisés :** Le projet inclut des tests de fonctionnalité (Feature) et des tests unitaires (Unit) avec PHPUnit pour garantir la fiabilité du code.
- **Formulaire de Contact Public :** Une page de contact permet aux visiteurs d'envoyer des messages, qui sont consultables dans la section "Admin".
- **Profil Utilisateur :** Les utilisateurs peuvent modifier leurs informations personnelles (nom, email) et téléverser un avatar.
- **Gestion des Clients (CRUD Admin) :** Une section complète, réservée aux administrateurs, pour gérer un portefeuille de clients.
- **Relations Complexes (Many-to-Many) :** Les projets peuvent être catégorisés avec des étiquettes (Tags), démontrant la maîtrise des relations "plusieurs à plusieurs" avec table pivot.
- **Recherche & Filtres :** Le tableau de bord principal permet de filtrer les projets par statut (Actif/Archivé) et par étiquette, et inclut une barre de recherche.
- **Suppression Douce (Soft Deletes) :** Les projets ne sont pas supprimés définitivement mais "archivés" dans une corbeille, d'où ils peuvent être restaurés.

---

## 🛠️ Stack Technique

- **Framework :** Laravel 12
- **Langage :** PHP 8.3
- **Base de données :** MySQL
- **Frontend :** Bootstrap 5
- **Tests :** PHPUnit
- **Serveur d'e-mails local :** Mailtrap
- **Dépendances de développement :** Laravel Debugbar

---

## 🚀 Installation & Démarrage

Pour lancer ce projet sur votre machine locale, suivez ces étapes :

1.  **Cloner le dépôt**
    ```bash
    git clone [https://github.com/votre-nom/taskmanager.git](https://github.com/votre-nom/taskmanager.git)
    cd taskmanager
    ```

2.  **Installer les dépendances**
    ```bash
    composer install
    npm install
    npm run dev
    ```

3.  **Configurer l'environnement**
    - Copiez le fichier d'exemple `.env.example` en `.env`.
        ```bash
        cp .env.example .env
        ```
    - Générez la clé d'application.
        ```bash
        php artisan key:generate
        ```
    - Configurez vos identifiants de base de données dans le fichier `.env`.

4.  **Préparer la base de données**
    - Lancez les migrations pour créer toutes les tables et peuplez la base avec des données de test (un utilisateur admin, des clients, des tags...).
        ```bash
        php artisan migrate:fresh --seed
        ```

5.  **Lier le stockage**
    - Cette commande est essentielle pour que les avatars téléversés soient visibles.
        ```bash
        php artisan storage:link
        ```

6.  **Lancer l'application**
    - Lancez le serveur de développement.
        ```bash
        php artisan serve
        ```
    - Dans un **second terminal**, lancez le "worker" pour qu'il traite les jobs en file d'attente (comme l'envoi d'e-mails).
        ```bash
        php artisan queue:work
        ```

L'application est maintenant accessible à l'adresse `http://127.0.0.1:8000`.

---

## 🧑‍💻 Utilisation

- **Compte Administrateur :** Un compte administrateur a été créé par le seeder.
    - **Email :** `admin@taskmanager.test`
    - **Mot de passe :** `password`
- Connectez-vous avec ce compte pour avoir accès à toutes les fonctionnalités, y compris la section "Messages" et la gestion des "Clients".

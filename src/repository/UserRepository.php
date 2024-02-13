<?php

require_once 'Repository.php';
require_once __DIR__ . '/../model/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT u.*, ud.name, ud.surname, ud.age, ud.profile_picture, ud.description
            FROM users u
            LEFT JOIN users_details ud ON u.id_user_details = ud.id
            WHERE u.email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        $userObject = new User($user['email'], $user['password'], $user['username']);
        $userObject->setId((int)$user['id']);
        $userObject->setIdUserDetails((int)$user['id_user_details']);

        if ($user['name'] !== null) {
            $userObject->setName($user['name']);
        }

        if ($user['surname'] !== null) {
            $userObject->setSurname($user['surname']);
        }

        if ($user['age'] !== null) {
            $userObject->setAge($user['age']);
        }

        if ($user['profile_picture'] !== null) {
            $userObject->setProfilePicture($user['profile_picture']);
        }
        else
            $userObject->setProfilePicture("public/uploads/profile_pictures/default.jpg");

        if ($user['description'] !== null) {
            $userObject->setDescription($user['description']);
        }
        if ($user['role'] !== null) {
            $userObject->setRole($user['role']);
        }

        return $userObject;


    }

    public function addUser(User $user)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (username, email, password, role)
            VALUES (?, ?, ?, ?)
        ');

        $stmt->execute([
            $user->getUsername(),
            $user->getEmail(),
            $user->getPassword(),
            "user"
        ]);
    }

    public function addUserDetails(User $user)
    {
        $pdo = $this->database->connect();

        try {
            $pdo->beginTransaction();

            $stmt1 = $pdo->prepare('
            UPDATE users_details 
            SET name = ?, surname = ?, age = ?, profile_picture = ?, description = ?
            WHERE id = (SELECT id_user_details FROM users WHERE email = ?)
        ');

            $stmt1->execute([
                $user->getName(),
                $user->getSurname(),
                $user->getAge(),
                $user->getProfilePicture(),
                $user->getDescription(),
                $user->getEmail()
            ]);

            $stmt2 = $pdo->prepare('
            UPDATE users
            SET id_user_details = ?
            WHERE email = ?
        ');

            $stmt2->execute([
                $user->getIdUserDetails(),
                $user->getEmail()
            ]);

            $pdo->commit();
        } catch (Exception $e) {
            // An error occurred, rollback the transaction
            $pdo->rollBack();
            throw $e; // Rethrow the exception after rolling back
        }
    }

}
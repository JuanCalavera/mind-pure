<?php

namespace Mind\Pdo\Infrastructure\Repository;

use Mind\Pdo\Domain\Model\User;
use Mind\Pdo\Domain\Repository\UserRepository;
use Mind\Pdo\Infrastructure\Persistence\ConnectionCreator;
use PDO;

class PdoUserRepository implements UserRepository
{
    private \PDO $connection;

    public function __construct()
    {
        $this->connection = ConnectionCreator::createConnection();
    }

    private function hydrateUserList(\PDOStatement $stmt): array
    {
        $userDataList = $stmt->fetchAll(fetch_style: PDO::FETCH_ASSOC);
        $userList = [];

        foreach ($userDataList as $userData) {
            $userList[] = new User(
                $userData['id'],
                $userData['user'],
                $userData['address'],
                $userData['city'],
                $userData['state'],
            );
        }

        return $userList;
    }
    
    public function allUsers(): array
    {
        $sqlQuery = 'SELECT * FROM users;';
        $stmt = $this->connection->query($sqlQuery);

        return $this->hydrateUserList($stmt);
    }

    public function insertUser(User $user) : array
    {
        $insertQuery = 'INSERT INTO students (name birth_date) VALUES (:name, :Address, :city, :state);';
        $stmt = $this->connection->prepare($insertQuery);

        $success = $stmt->execute([
            ':name' => $user->user(),
            ':Address' => $user->address(),
            ':city' => $user->city(),
            ':state' => $user->state(),
        ]);

        $user->defineId($this->connection->lastInsertId());

        if($success){
            return ["message" => "User inserted successfully !"];
        } else {
            return ["message" => "User not inserted :("];
        }
    }

    public function updateUser(User $user): array
    {
        $updateQuery = 'UPDATE students SET name = :name, Address = :Address, city = :city, state = :state WHERE id = :id;';
        $stmt = $this->connection->prepare($updateQuery);
        $stmt->bindValue(':name', $user->user());
        $stmt->bindValue(':Address', $user->address());
        $stmt->bindValue(':city', $user->city());
        $stmt->bindValue(':state', $user->state());
        $stmt->bindValue(':id', $user->id(), PDO::PARAM_INT);

        if($stmt->execute()){
            return ["message" => "User updated successfully !"];
        } else {
            return ["message" => "User not updated :("];
        }
    }

    public function usersAddress(): array
    {
        $sqlQuery = 'SELECT Address FROM users;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->execute();

        return $this->hydrateUserList($stmt);
    }

    public function userAddress(int $id): array
    {
        $sqlQuery = 'SELECT Address FROM users WHERE id = ?;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        return $this->hydrateUserList($stmt);
    }

    public function usersState(): array
    {
        $sqlQuery = 'SELECT state FROM users;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->execute();

        return $this->hydrateUserList($stmt);
    }

    public function userState(int $id): array
    {
        $sqlQuery = 'SELECT state FROM users;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->execute();

        return $this->hydrateUserList($stmt);
    }

    public function usersCity(): array
    {
        $sqlQuery = 'SELECT city FROM users;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->execute();

        return $this->hydrateUserList($stmt);
    }

    public function userCity(int $id): array
    {
        $sqlQuery = 'SELECT city FROM users;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->execute();

        return $this->hydrateUserList($stmt);
    }

    public function countCity(): array
    {
        $sqlQuery = 'SELECT city FROM users;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->execute();

        $userDataList = $stmt->fetchAll(fetch_style: PDO::FETCH_ASSOC); // Aqui é onde retorna uma array!

        $userDataList = array_unique($userDataList);
        

        foreach($userDataList as $userData){
            $sqlQuery = 'SELECT city FROM users WHERE city = :city ;';
            $stmt = $this->connection->prepare($sqlQuery);
            $stmt->bindValue(":city", $userData, PDO::PARAM_STR);
            $stmt->execute();

            $userDataCities = $stmt->fetchAll(fetch_style: PDO::FETCH_ASSOC);

            $countList[$userData] = count((array) $userDataCities);
        }

        if($countList){
            return $countList;
        } else {
            return ["message" => "Don't have any city :("];
        }
        
    }

    public function countState(): array
    {
        $sqlQuery = 'SELECT state FROM users;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->execute();

        $userDataList = $stmt->fetchAll(fetch_style: PDO::FETCH_ASSOC); // Aqui é onde retorna uma array!

        $userDataList = array_unique($userDataList);
        

        foreach($userDataList as $userData){
            $sqlQuery = 'SELECT state FROM users WHERE state = :state ;';
            $stmt = $this->connection->prepare($sqlQuery);
            $stmt->bindValue(":state", $userData, PDO::PARAM_STR);
            $stmt->execute();

            $userDataStates = $stmt->fetchAll(fetch_style: PDO::FETCH_ASSOC);

            $countList[$userData] = count((array) $userDataStates);
        }

        if($countList){
            return $countList;
        } else {
            return ["message" => "Don't have any city :("];
        }
    }

    public function remove(int $id): array
    {
        $stmt = $this->connection->prepare('DELETE FROM users WHERE id = ?;');
        $stmt->bindValue(1, $id, PDO::PARAM_INT);

        if($stmt->execute()){
            return ["message" => "User removed successfully !"];
        } else {
            return ["message" => "User not removed :("];
        }
    }
}

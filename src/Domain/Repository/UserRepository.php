<?php

namespace Mind\Pdo\Domain\Repository;

use Mind\Pdo\Domain\Model\User;



interface UserRepository
{
    public function allUsers(): array;
    public function updateUser(User $user): array;
    public function insertUser(User $user): array;
    public function usersAddress(): array;
    public function userAddress(int $id): array;
    public function usersState(): array;
    public function userState(int $id): array;
    public function usersCity(): array;
    public function userCity(int $id): array;
    public function countCity(): array;
    public function countState(): array;
    public function remove(int $id): array;
}

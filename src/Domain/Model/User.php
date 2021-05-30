<?php

namespace Mind\Pdo\Domain\Model;

class User
{
    private ?int $id;
    private string $user;
    private string $address;
    private string $city;
    private string $state;

    public function __construct(?int $id, string $user, string $address, string $city, string $state)
    {
        $this->id = $id;
        $this->$user = $user;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
    }

    public function defineId(int $id): void
    {
        if(!is_null($this->id)){
            throw new \DomainException("You just can define one id at a time");
        }

        $this->id = $id;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function user(): string
    {
        return $this->user;
    }

    public function address(): string
    {
        return $this->address;
    }
    public function city(): string
    {
        return $this->city;
    }
    public function state(): string
    {
        return $this->state;
    }

    public function updateUser(string $newUser, string $newAddress, string $newCity, string $newState): void
    {
        $this->user = $newUser ? $newUser : $this->user;
        $this->address = $newAddress ? $newAddress : $this->address;
        $this->city = $newCity ? $newCity : $this->city;
        $this->state = $newState ? $newState : $this->state;
    }
}

<?php
namespace App\Helpers\Models;

use JsonSerializable;

class Recipient implements \Serializable, JsonSerializable
{
    private String $address;
    private String $name;

    public function __construct(String $address, String $name)
    {
        $this->address = $address;
        $this->name = $name;
    }

    public function getEmail(): String
    {
        return $this->address;
    }

    public function getName(): String
    {
        return $this->name;
    }

    public function serialize(): String
    {
        return serialize([
            $this->address,
            $this->name
        ]);
    }

    public function unserialize($serialized): void
    {
        [$this->address, $this->name] = unserialize($serialized);
    }

    public function jsonSerialize(): array
    {
        return [
            'address' => $this->address,
            'name' => $this->name
        ];
    }
}
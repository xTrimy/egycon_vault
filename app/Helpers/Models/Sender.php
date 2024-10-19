<?php
namespace App\Helpers\Models;

use JsonSerializable;
use Serializable;

class Sender implements Serializable, JsonSerializable
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

    public function serialize(): string
    {
        return serialize([
            'address' => $this->address,
            'name' => $this->name
        ]);
    }

    public function unserialize($serialized): void
    {
        $data = unserialize($serialized);
        $this->address = $data['address'];
        $this->name = $data['name'];
    }

    public function jsonSerialize(): array
    {
        return [
            'address' => $this->address,
            'name' => $this->name
        ];
    }

    


}
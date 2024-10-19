<?php

namespace App\Helpers\Models;

class EmailTemplate
{
    private String $subject;
    private String $body;

    public function __construct(String $subject, String $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }

    public function getSubject(): String
    {
        return $this->subject;
    }

    public function getBody(): String
    {
        return $this->body;
    }

    public function setSubject(String $subject): void
    {
        $this->subject = $subject;
    }

    public function setBody(String $body): void
    {
        $this->body = $body;
    }
}
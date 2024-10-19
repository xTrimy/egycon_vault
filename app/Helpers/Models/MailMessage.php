<?php

namespace App\Helpers\Models;

class MailMessage implements \JsonSerializable
{
    private array $to;
    private String $subject;
    private String $htmlBody;

    private Sender $from;

    private bool $trackOpens = true;

    private bool $trackClicks = true;

    private String $reference;

    private String $tag;


    public static function builder()
    {
        return new MailMessage();
    }

    public function getSubject()
    {
        return $this->subject;
        
    }

    public function subject(String $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function getHtmlBody()
    {
        return $this->htmlBody;
    }

    public function htmlBody(String $htmlBody)
    {
        $this->htmlBody = $htmlBody;
        return $this;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getToZepto(){
        $to = [];
        foreach ($this->to as $recipient) {
            $email_address = [];
            $email_address["email_address"] = [
                "address" => $recipient->getEmail(),
                "name" => $recipient->getName()
            ];
            array_push($to, $email_address);
        }
        return $to;
    }

    public function to(Recipient ...$to)
    {
        $this->to = $to;
        return $this;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function from(Sender $from)
    {
        $this->from = $from;
        return $this;
    }

    public function getTrackOpens()
    {
        return $this->trackOpens;
    }

    public function trackOpens(bool $trackOpens)
    {
        $this->trackOpens = $trackOpens;
        return $this;
    }

    public function getTrackClicks()
    {
        return $this->trackClicks;
    }

    public function trackClicks(bool $trackClicks)
    {
        $this->trackClicks = $trackClicks;
        return $this;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function reference(String $reference)
    {
        $this->reference = $reference;
        return $this;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function tag(String $tag)
    {
        $this->tag = $tag;
        return $this;
    }

    public function build()
    {
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'to' => $this->to,
            'from' => $this->from,
            'subject' => $this->subject,
            'htmlBody' => $this->htmlBody,
            'trackOpens' => $this->trackOpens,
            'trackClicks' => $this->trackClicks,
            'reference' => $this->reference,
            'tag' => $this->tag
        ];
    }

    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }
}
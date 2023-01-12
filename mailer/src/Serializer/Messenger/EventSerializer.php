<?php

namespace Mailer\Serializer\Messenger;

use Mailer\Messenger\Message\UserRegisteredMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\Serializer;

class EventSerializer extends Serializer
{
    public function decode(array $encodedEnvelope): Envelope
    {
        $translateType = $this->translateType($encodedEnvelope['headers']['type']);

        $encodedEnvelope['headers']['type'] = $translateType;

        return parent::decode($encodedEnvelope);
    }

    private function translateType(string $type): string {
        $map = ['App\Messenger\Message\UserRegisteredMessage' => UserRegisteredMessage::class];

        if (array_key_exists($type, $map)) {
            return $map[$type];
        }

        return $type;
    }
}
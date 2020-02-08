<?php
declare(strict_types=1);

namespace League\Pipeline;

class InterruptiblePayloadProcessor implements ProcessorInterface
{
    public function process($payload, callable ...$stages)
    {
        foreach ($stages as $stage) {

            /** @var \League\Pipeline\PayloadInterface $payload */
            $payload = $stage($payload);

            if ($payload->isError()) {
                return $payload;
            }
        }

        return $payload;
    }
}

<?php
declare(strict_types=1);

namespace League\Pipeline;

interface StagePayloadInterface
{
    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function __invoke(Payload $payload);

    public function action();
}

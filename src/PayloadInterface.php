<?php
declare(strict_types=1);

namespace League\Pipeline;

interface PayloadInterface
{
    public function setSuccess($message = ''): void;

    public function setError($message = ''): void;

    public function setMessage($message): Payload;

    public function isSuccess(): bool;

    public function isError(): bool;

    public function getMessage();

    public function getStageData($key = null);

    public function getInitialData($key = null);

    public function getData($key = null);
}

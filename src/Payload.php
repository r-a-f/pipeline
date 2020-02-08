<?php

namespace League\Pipeline;

class Payload implements PayloadInterface
{
    private const NOCHANGED = 0;
    private const ERROR     = - 1;
    private const SUCCESS   = 2;

    private $state;
    private $message;
    private $log          = [];
    private $stage_data   = [];
    private $initial_data = [];

    public function __construct(...$initial_data)
    {
        $this->state = self::NOCHANGED;
        $this->setInitialData($initial_data);
    }

    public function setSuccess($message = ''): void
    {
        $this->setState(self::SUCCESS, $message);
    }

    public function setError($message = ''): void
    {
        $this->setState(self::ERROR, $message);
    }

    public function setState($a, $message = ''): Payload
    {
        $this->state   = $a;
        $this->message = (string)$message;

        return $this;
    }

    private function setInitialData($data): Payload
    {
        $options = [];
        foreach ($data as $p) {
            $options[] = (array)$p;
        }

        $this->initial_data = array_merge([], ...$options);

        return $this;
    }

    public function setStageData(...$params): Payload
    {
        $options = [];
        foreach ($params as $p) {
            $options[] = (array)$p;
        }

        $this->stage_data = array_merge([], ...$options);

        return $this;
    }

    public function setLog($message): Payload
    {
        $this->log[] = (string)$message;

        return $this;
    }


    public function setMessage($message): Payload
    {
        $this->message = (string)$message;

        return $this;
    }

    public function isSuccess(): bool
    {
        return ($this->state === self::SUCCESS);
    }

    public function isError(): bool
    {
        return ($this->state === self::ERROR);
    }

    public function getStageData($key = null)
    {
        if ($key) {
            return $this->stage_data[$key] ?? null;
        }

        return $this->stage_data;
    }

    public function getInitialData($key = null)
    {
        if ($key) {
            return $this->initial_data[$key] ?? null;
        }

        return $this->initial_data;
    }

    public function getData($key = null)
    {
        $data = $this->getInitialData($key);
        if ($data === null) {
            $data = $this->getStageData($key);
        }

        return $data;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getlog(): array
    {
        return $this->log;
    }

}
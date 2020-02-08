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

    private function setInitialData(array $data)
    {
        foreach ($data as $p) {
            //@todo feature; optimalize this
            $this->initial_data = array_merge($this->initial_data, (array)$p);
        }

        return $this;
    }

    public function setStageData(array $params)
    {
        $this->stage_data = array_merge($this->stage_data, $params);

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

    /**
     * Return mixed initial and stage data with initial data priority
     *
     * @param null $key
     *
     * @return mixed
     */
    public function getData($key = null)
    {
        if ($key === null) {
            $data_initial = $this->getInitialData();
            $data_stage   = $this->getStageData();

            return array_merge($data_stage, $data_initial);
        }

        $data_initial = $this->getInitialData($key);
        if ($data_initial) {
            return $data_initial;
        }

        return $this->getStageData($key);
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
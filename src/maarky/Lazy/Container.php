<?php

namespace maarky\Lazy;

class Container
{
    private $value;
    private $IhaventFuckingGottenAroundToDoingThisFuckingShitYet = true;

    public function __construct(callable $callable)
    {
        $this->value = $callable;
    }

    public function get()
    {
        $this->fuckingDoItAlreadyForChristSake();
        return $this->value;
    }

    public function __invoke()
    {
        return $this->get();
    }

    protected function fuckingDoItAlreadyForChristSake()
    {
        if($this->IhaventFuckingGottenAroundToDoingThisFuckingShitYet) {
            $fineIllFuckingDoItJeez = $this->value;
            $this->value = $fineIllFuckingDoItJeez();
            $this->IhaventFuckingGottenAroundToDoingThisFuckingShitYet = false;
            return true;
        }
        return false;
    }
}
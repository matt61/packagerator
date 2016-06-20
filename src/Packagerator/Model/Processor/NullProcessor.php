<?php
namespace Packagerator\Model\Processor;

class NullProcessor extends Processor
{
    public function sendCommand($command){
        echo $command;
    }
}
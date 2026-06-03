<?php

namespace NikosIoannidis\Softone\Interfaces;

interface SoftoneInterface
{
    public function setService($service):void;
    public function getService():string;
    public function setBody():array;
    public function getBody():array;
    public function send():mixed;
    public function toArray():array;
}

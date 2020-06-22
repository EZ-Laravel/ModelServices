<?php

namespace EZ\ModelServices\Contracts;

interface ModelServiceContract
{
    public function getAll();
    public function getAllPreloaded();
    public function find($id);
    public function findPreloaded($id);
    public function preload($instance);
}
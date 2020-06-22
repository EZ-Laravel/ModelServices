<?php

namespace EZ\ModelServices\Contracts;

interface ModelServiceContract
{
    public function getAll();

    public function getAllPreloaded();

    public function find($id);

    public function findBy($field, $value);

    public function findPreloaded($id);

    public function findPreloadedBy($field, $value);

    public function preload($instance);
}

<?php

namespace EZ\ModelServices\Traits;

trait ModelServiceGetters
{
    public function getAll()
    {
        if (is_null($this->records))
        {
            $this->records = call_user_func($this->model."::all");
        }

        return $this->records;
    }

    public function getAllPreloaded()
    {
        if (is_null($this->preloadedRecords))
        {
            $out = [];

            foreach ($this->getAll() as $record)
            {
                $clonedRecord = clone $record;

                $out[] = $this->preload($clonedRecord);
            }

            $this->preloadedRecords = collect($out);
        }

        return $this->preloadedRecords;
    }

    public function find($id)
    {
        foreach ($this->getAll() as $record)
        {
            if ($record->id == $id)
            {
                return $record;
            }
        }

        return false;
    }

    public function findBy($field, $value)
    {
        foreach ($this->getAll() as $record)
        {
            if ($record->$field == $value)
            {
                return $record;
            }
        }

        return false;
    }
    
    public function findPreloaded($id)
    {
        foreach ($this->getAllPreloaded() as $record)
        {
            if ($record->id == $id)
            {
                return $record;
            }
        }

        return false;
    }
    
    public function findPreloadedBy($field, $value)
    {
        foreach ($this->getAllPreloaded() as $record)
        {
            if ($record->$field == $value)
            {
                return $record;
            }
        }
        
        return false;
    }

    public function countAll()
    {
        return $this->getAll()->count();
    }
}
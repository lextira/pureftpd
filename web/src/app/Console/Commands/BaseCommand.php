<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    protected function handleValidationError($e)
    {
        $this->error($e->getMessage());
        foreach ($e->errors() as $field => $errors) {
            $this->error($field . ': ' . implode(' ', $errors));
        }
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

// Models folder
$modelsPath = app_path('Models');

// Get all PHP files in the folder
$files = glob($modelsPath . '/*.php');

foreach ($files as $file) {
    // Get the model class name
    $class = 'App\\Models\\' . pathinfo($file, PATHINFO_FILENAME);

    if (!class_exists($class)) {
        continue;
    }

    $model = new $class;

    // Get the table name (if not explicitly set, use snake_case plural)
    $table = $model->getTable();

    echo "Checking model: $class, table: $table\n";

    $fillable = $model->getFillable();

    if (empty($fillable)) {
        echo "  - Model has no fillable fields, skipping.\n\n";
        continue;
    }

    foreach ($fillable as $column) {
        if (!Schema::hasColumn($table, $column)) {
            echo "  ERR Column '$column' is missing in table '$table'\n";
        } else {
            echo "  OK Column '$column' exists in table '$table'\n";
        }
    }

    echo "\n";
}

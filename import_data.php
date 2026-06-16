<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$sql = file_get_contents(__DIR__.'/db_tambang.sql');

// We just want to extract INSERT INTO statements. We will do this by looking for 'INSERT INTO' at the beginning of lines.
// And we know each insert statement ends with ';' at the end of a line.

$lines = explode("\n", $sql);
$inserts = [];
$currentInsert = '';
$isInserting = false;

foreach ($lines as $line) {
    if (strpos(trim($line), 'INSERT INTO') === 0) {
        $isInserting = true;
        $currentInsert = $line;
    } elseif ($isInserting) {
        $currentInsert .= "\n" . $line;
    }
    
    // If we're inserting and the line ends with ';'
    if ($isInserting && preg_match('/;\s*$/', rtrim($line))) {
        $inserts[] = $currentInsert;
        $isInserting = false;
        $currentInsert = '';
    }
}

DB::statement('PRAGMA foreign_keys=OFF;');

$successCount = 0;
$failCount = 0;

foreach ($inserts as $stmt) {
    try {
        DB::unprepared($stmt);
        $successCount++;
    } catch (\Exception $e) {
        echo "Failed: \n$stmt\n";
        echo "Error: " . $e->getMessage() . "\n\n";
        $failCount++;
    }
}

DB::statement('PRAGMA foreign_keys=ON;');

echo "Successfully imported $successCount insert statements.\n";
if ($failCount > 0) {
    echo "Failed to import $failCount statements.\n";
}

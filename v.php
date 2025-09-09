<?php

$sessionDir = __DIR__ . '/writable/session';
$testFile   = $sessionDir . '/ci_testfile.txt';
$testFile2   = $sessionDir . '/ci_testfile2.txt';

// 1. Check if folder exists
if (!file_exists($sessionDir)) {
    echo "Session folder does NOT exist: $sessionDir<br>";
    echo "Attempting to create it...<br>";
    if (!mkdir($sessionDir, 0777, true)) {
        die("Failed to create session folder. Check permissions.<br>");
    } else {
        echo "Folder created successfully.<br>";
    }
} else {
    echo "Session folder exists: $sessionDir<br>";
}

// 2. Check permissions
$perms = substr(sprintf('%o', fileperms($sessionDir)), -4);
echo "Folder permissions: $perms<br>";

// 3. Check PHP user
$user = exec('whoami');
echo "PHP running as user: $user<br>";

// 4. Try touch()
echo "Testing touch()...<br>";
if (@touch($testFile)) {
    echo "touch() succeeded: $testFile<br>";
} else {
    echo "<b>touch() failed!</b><br>";
}

// 5. Check file existence
if (file_exists($testFile)) {
    echo "File exists after touch()<br>";
} else {
    echo "File does NOT exist after touch()<br>";
}

// 6. Try file_put_contents()
echo "Testing file_put_contents()...<br>";
if (@file_put_contents($testFile2, "Test content")) {
    echo "file_put_contents() succeeded: $testFile<br>";
} else {
    echo "<b>file_put_contents() failed!</b><br>";
}

// 7. Check final result
clearstatcache();
if (file_exists($testFile2)) {
    echo "<b>Success! File really exists now.</b><br>";
} else {
    echo "<b>File still does NOT exist!</b><br>";
}

?>

<?php
echo 'Downloading files...'. PHP_EOL;
$items = [
    'locales.json' => 'https://cdn.simplelocalize.io/public/v1/locales',
    'airports.json' => 'https://raw.githubusercontent.com/mwgg/Airports/refs/heads/master/airports.json',
];
foreach ($items as $file => $url) {
    @unlink($file);
    if(file_put_contents($file, file_get_contents($url)) === false) {
        exit(sprintf('download failed: %s', $url));
    };
}
echo 'Done'. PHP_EOL;
exit(0);
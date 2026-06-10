<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';

echo "Starting...\n";

try {
    $client = new \Google\Analytics\Admin\V1alpha\Client\AnalyticsAdminServiceClient([
        'credentials' => 'storage/app/google/kopiderr-2a11ef63f5ae.json'
    ]);
    echo "Client OK\n";

    $binding = new \Google\Analytics\Admin\V1alpha\AccessBinding([
        'user' => 'ga-analytics-reader@kopiderr.iam.gserviceaccount.com',
        'roles' => ['predefinedRoles/viewer'],
    ]);

    $request = new \Google\Analytics\Admin\V1alpha\CreateAccessBindingRequest([
        'parent' => 'properties/520078414',
        'access_binding' => $binding,
    ]);

    $response = $client->createAccessBinding($request);
    echo "BERHASIL: " . $response->getName() . "\n";

} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
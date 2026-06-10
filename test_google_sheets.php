<?php

/**
 * Test Script untuk Validasi Google Sheets Connection
 * 
 * Jalankan script ini untuk memastikan:
 * 1. Credentials file valid
 * 2. Connection ke Google Sheets API berhasil
 * 3. Service account punya akses ke spreadsheet
 * 
 * Cara run:
 * php artisan tinker
 * include('test_google_sheets.php');
 */

namespace App\Tests;

use App\Services\GoogleSheetService;

class TestGoogleSheets
{
    public static function run()
    {
        echo "🧪 Starting Google Sheets Connection Test...\n\n";

        // Test 1: Check credentials file
        echo "📁 Test 1: Checking credentials file...\n";
        $credentialsPath = storage_path('app/google/kopiderr-562d2f5ff13a.json');
        
        if (!file_exists($credentialsPath)) {
            echo "❌ FAILED: Credentials file not found at: {$credentialsPath}\n";
            echo "   Action: Copy kopiderr-562d2f5ff13a.json to storage/app/google/\n\n";
            return;
        }
        
        echo "✅ PASSED: Credentials file found\n";
        
        // Test 2: Check file permissions
        echo "\n📁 Test 2: Checking file permissions...\n";
        $perms = substr(sprintf('%o', fileperms($credentialsPath)), -4);
        
        if ($perms === '0600') {
            echo "✅ PASSED: File permissions are secure (0600)\n";
        } else {
            echo "⚠️  WARNING: File permissions are {$perms}, recommended: 0600\n";
            echo "   Action: Run 'chmod 600 {$credentialsPath}'\n";
        }

        // Test 3: Validate JSON structure
        echo "\n📄 Test 3: Validating JSON structure...\n";
        $json = file_get_contents($credentialsPath);
        $credentials = json_decode($json, true);
        
        if (!$credentials) {
            echo "❌ FAILED: Invalid JSON format\n\n";
            return;
        }
        
        $requiredKeys = ['type', 'project_id', 'private_key', 'client_email'];
        $missingKeys = [];
        
        foreach ($requiredKeys as $key) {
            if (!isset($credentials[$key])) {
                $missingKeys[] = $key;
            }
        }
        
        if (!empty($missingKeys)) {
            echo "❌ FAILED: Missing keys: " . implode(', ', $missingKeys) . "\n\n";
            return;
        }
        
        echo "✅ PASSED: JSON structure is valid\n";
        echo "   Service Account: {$credentials['client_email']}\n";

        // Test 4: Check environment variable
        echo "\n⚙️  Test 4: Checking environment variables...\n";
        $spreadsheetId = env('GOOGLE_SHEET_ID');
        
        if (empty($spreadsheetId)) {
            echo "❌ FAILED: GOOGLE_SHEET_ID not set in .env\n";
            echo "   Action: Add GOOGLE_SHEET_ID=your_spreadsheet_id to .env\n\n";
            return;
        }
        
        echo "✅ PASSED: GOOGLE_SHEET_ID is set\n";
        echo "   Spreadsheet ID: {$spreadsheetId}\n";

        // Test 5: Initialize Google Sheets Service
        echo "\n🔌 Test 5: Initializing Google Sheets Service...\n";
        
        try {
            $googleSheets = new GoogleSheetService();
            $googleSheets->setSpreadsheetId($spreadsheetId);
            echo "✅ PASSED: Service initialized successfully\n";
        } catch (\Exception $e) {
            echo "❌ FAILED: " . $e->getMessage() . "\n\n";
            return;
        }

        // Test 6: Test read access
        echo "\n📖 Test 6: Testing read access to spreadsheet...\n";
        
        try {
            $result = $googleSheets->readData('Sheet1!A1:A1');
            
            if ($result['success']) {
                echo "✅ PASSED: Read access successful\n";
                if (!empty($result['data'])) {
                    echo "   Data found: " . json_encode($result['data']) . "\n";
                } else {
                    echo "   Note: Cell A1 is empty\n";
                }
            } else {
                echo "❌ FAILED: " . $result['message'] . "\n";
                echo "\n🔧 Common Issues:\n";
                echo "   1. Sheet not shared with service account\n";
                echo "      Share to: {$credentials['client_email']}\n";
                echo "   2. Wrong spreadsheet ID\n";
                echo "   3. Sheet name doesn't exist (check 'Sheet1')\n\n";
                return;
            }
        } catch (\Exception $e) {
            echo "❌ FAILED: " . $e->getMessage() . "\n\n";
            return;
        }

        // Test 7: Test write access
        echo "\n✏️  Test 7: Testing write access to spreadsheet...\n";
        
        try {
            $testData = [
                ['Test Timestamp: ' . now()->toDateTimeString()]
            ];
            
            $result = $googleSheets->appendData('Sheet1!A:A', $testData);
            
            if ($result['success']) {
                echo "✅ PASSED: Write access successful\n";
                echo "   Rows updated: {$result['updates']}\n";
            } else {
                echo "❌ FAILED: " . $result['message'] . "\n";
                echo "   Note: Sheet might be view-only. Check permissions.\n\n";
                return;
            }
        } catch (\Exception $e) {
            echo "❌ FAILED: " . $e->getMessage() . "\n\n";
            return;
        }

        // All tests passed!
        echo "\n" . str_repeat("=", 60) . "\n";
        echo "🎉 ALL TESTS PASSED! Google Sheets integration is ready!\n";
        echo str_repeat("=", 60) . "\n\n";
        
        echo "Next steps:\n";
        echo "1. Setup your Bookings sheet with proper headers\n";
        echo "2. Run the migration: php artisan migrate\n";
        echo "3. Test the BookingController endpoints\n\n";
        
        echo "Sheet Structure Recommendation:\n";
        echo "Sheet 'Bookings' - Headers:\n";
        echo "A1: ID | B1: Customer Name | C1: Email | D1: Phone\n";
        echo "E1: Date | F1: Time | G1: Guests | H1: Status\n";
        echo "I1: Notes | J1: Created At\n\n";
    }
}

// Auto-run when included
if (php_sapi_name() === 'cli') {
    try {
        TestGoogleSheets::run();
    } catch (\Exception $e) {
        echo "\n💥 ERROR: " . $e->getMessage() . "\n";
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    }
}
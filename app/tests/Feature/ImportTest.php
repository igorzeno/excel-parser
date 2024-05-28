<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_view_import_get_form(): void
    {
        $response = $this->get('/import');

        $response->assertStatus(200);

        $response->assertSee(__('Import_button'));
    }

    public function test_import_excel_to_database_rows(): void
    {
        define('MULTIPART_BOUNDARY', '--------------------------' . microtime(true));

        $header = 'Content-Type: multipart/form-data; boundary=' . MULTIPART_BOUNDARY;

        define('FORM_FIELD', 'file');

        $filename = "/var/www/public/excel-test/test.xlsx";
        $file_contents = file_get_contents($filename);

        $content = "--" . MULTIPART_BOUNDARY . "\r\n" .
            "Content-Disposition: form-data; name=\"" . FORM_FIELD . "\"; filename=\"" . basename($filename) . "\"\r\n" .
            "Content-Type: application/zip\r\n\r\n" .
            $file_contents . "\r\n";


        $content .= "--" . MULTIPART_BOUNDARY . "\r\n" .
            "Content-Disposition: form-data; name=\"test.xlsx\"\r\n\r\n" .
            "test.xlsx\r\n";

        $content .= "--" . MULTIPART_BOUNDARY . "--\r\n";

        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => $header,
                'content' => $content,
            )
        ));

        file_get_contents('http://localhost:8086/import', false, $context);

        $this->assertDatabaseHas('rows', [
            'id' => 1
        ]);
    }
}

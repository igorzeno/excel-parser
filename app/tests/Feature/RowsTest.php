<?php

namespace Tests\Feature;

use App\Models\Row;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RowsTest extends TestCase
{
    use RefreshDatabase;

    public function test_rows_contains_empty_table(): void
    {
        $response = $this->get('/rows');

        $response->assertStatus(200);

        $response->assertSee(__('No_rows_found'));
    }

    public function test_rows_contains_non_empty_table(): void
    {
        Row::insert([
            [
                'id' => 1,
                'name' => 'Denim',
                'publish_date' => '14.10.20',
            ],
            [
                'id' => 2,
                'name' => 'Denim',
                'publish_date' => '14.10.20',
            ],
            [
                'id' => 3,
                'name' => 'Denim',
                'publish_date' => '12.11.26',
            ],
        ]);
        $response = $this->get('/rows');

        $response->assertStatus(200);

        $response->assertDontSee(__('No_rows_found'));
        $response->assertSee(__('Group_by_date'));
        $response->assertViewHas('rows');
    }
}

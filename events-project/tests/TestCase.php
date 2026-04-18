<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        if (\Illuminate\Support\Facades\Schema::hasTable('user_types')) {
            \Illuminate\Support\Facades\DB::table('user_types')->insertOrIgnore([
                ['id' => 1, 'type' => 'Administrador'],
                ['id' => 2, 'type' => 'Organizador'],
                ['id' => 3, 'type' => 'Participante Base']
            ]);
        }
    }
}

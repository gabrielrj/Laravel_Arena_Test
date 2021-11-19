<?php

namespace Tests\Feature\Number;

use App\Exceptions\NumberNotFoundException;
use App\Services\NumberService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class NumberServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_number_not_registered_expect_number_exception(){
        $this->expectException(NumberNotFoundException::class);

        $service = App::make(NumberService::class);

        $service->deleteNumberById(3);
    }
}

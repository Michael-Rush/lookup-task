<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LookupTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_makes_a_request()
    {
        $response = $this->get('/lookup?type=xbl&username=tebex');

        $response->assertStatus(200);
    }

    public function test_returns_json()
    {
        $response = $this->get('/lookup?type=xbl&username=tebex');

        $response->assertStatus(200)
            ->assertExactJson([
            'username' => 'Tebex',
            'id' => '2533274844413377',
            'avatar' => 'https://avatar-ssl.xboxlive.com/avatar/2533274844413377/avatarpic-l.png',
        ]);
    }

    public function test_error_handling()
    {
        $response = $this->get('/lookup?type=steam&username=test');

        $response->assertStatus(422)
            ->assertJsonPath('errors.id', ['Steam only supports IDs']);
    }

    public function test_by_json_attributes()
    {
        $response = $this->json('GET','/lookup?type=minecraft&id=d8d5a9237b2043d8883b1150148d6955');

        $response->assertJson(fn(AssertableJson $json) =>
            $json->where('id', 'd8d5a9237b2043d8883b1150148d6955')
                ->where('username', 'Test')
                ->where('avatar', 'https://crafatar.com/avatarsd8d5a9237b2043d8883b1150148d6955')
        );
    }
}

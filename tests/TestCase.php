<?php

namespace Tests;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,  DatabaseMigrations;


    public function setUp()
    {
        // parent::setUp();
        Artisan::call('db:seed');
    }

    public function userPay()
    {

        $user = User::whereRole(0)->latest()->first();
        dd($user);
        $course = Course::latest()->first();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'course' => $course->id,
            'user' => $user->id
        ];

        $this->json('POST', '/api/student/course/payment', $payload, $headers)
            ->assertStatus(200);
        // ->assertJson(['id' => 1, 'title' => 'Lorem', 'body' => 'Ipsum']);
    }
}

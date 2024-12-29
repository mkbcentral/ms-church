use App\Models\Church;
<?php

use function Pest\Laravel\get;
use function Pest\Laravel\put;

test('Use ca update profile', function () {
    $user = \App\Models\User::first();
    $this->actingAs($user);
    $inputs = [
        'name' => 'John Doe',
        'email' => 'john@doe.com',
        'phone' => '0123456789',
    ];
    $response = put(route('api.v1.auth.update.profile', $user->id),  $inputs);
    $response->assertStatus(\Illuminate\Http\Response::HTTP_CREATED);
});

test('User can not update profile with empty resque', function () {
    $user = \App\Models\User::first();
    $this->actingAs($user);
    $inputs = [];
    $response = put(route('api.v1.auth.update.profile', $user->id),  $inputs);
    $response->assertStatus(\Illuminate\Http\Response::HTTP_FOUND);
});

<?php

use function Pest\Laravel\post;

test('User can login with valid credentials ', function () {
    $response=post(route('api.v1.auth.login'),[
        'login'=>'test@test.app',
        'password'=>'test001'
    ]);
    $response->assertStatus(\Illuminate\Http\Response::HTTP_OK);
    $response->assertJsonStructure([
        'token'
    ]);
});

test('User can not login with invalid credentials', function () {
    $response=post(route('api.v1.auth.login'),[
        'login'=>'test001@test.app',
        'password'=>'test001'
    ]);
    $response->assertStatus(\Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR);
});

test('User can not login with empty request', function () {
    $response=post(route('api.v1.auth.login'),[]);
    $response->assertStatus(\Illuminate\Http\Response::HTTP_FOUND);
});

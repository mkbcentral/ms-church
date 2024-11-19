<?php

use function Pest\Laravel\post;

test('User can register with valid credentials', function () {
    $response = post(route('api.v1.auth.register',[
        'name'=>'user app',
        'email'=>'my-user@test.app',
        'phone'=>'081025255',
        'password'=>'password',
        'password_confirmation'=>'password'
    ]));
    $response->assertStatus(\Illuminate\Http\Response::HTTP_CREATED);
});

test('User can not register to empty request', function () {
    $response=post(route('api.v1.auth.register',[]));
    $response->assertStatus(\Illuminate\Http\Response::HTTP_FOUND);
});

test('User can not register with existing email', function () {
    $response = post(route('api.v1.auth.register',[
        'name'=>'user app2',
        'email'=>'my-user@test.app',
        'phone'=>'081025250',
        'password'=>'password00',
        'password_confirmation'=>'password00'
    ]));
    $response->assertStatus(\Illuminate\Http\Response::HTTP_FOUND);
});

test('User can not register with existing phone', function () {
    $response = post(route('api.v1.auth.register',[
        'name'=>'user app',
        'email'=>'my-user25@test.app',
        'phone'=>'081025255',
        'password'=>'password',
        'password_confirmation'=>'password'
    ]));
    $response->assertStatus(\Illuminate\Http\Response::HTTP_FOUND);
});

test('User can not register confirm password', function () {
    $response = post(route('api.v1.auth.register',[
        'name'=>'user app',
        'email'=>'my-user25@test.app',
        'phone'=>'081025255',
        'password'=>'password',
        'password_confirmation'=>'password0000'
    ]));
    $response->assertStatus(\Illuminate\Http\Response::HTTP_FOUND);
});

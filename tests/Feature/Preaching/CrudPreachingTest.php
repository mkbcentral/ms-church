<?php

use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

use App\Models\Preaching;
use \Illuminate\Http\Response;

test("L'utilisateur est autorisé à acceder aux prédications", function () {
    $user = App\Models\User::first();
    $this->actingAs($user);
    $response = get(route('api.v1.preaching.index'));
    $response->assertStatus(\Illuminate\Http\Response::HTTP_OK);
});
test("L'utilisateur n'est plus autorisé à acceder aux prédications", function () {
    $response = get(route('api.v1.preaching.index'));
    $response->assertStatus(\Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR);
});

test("L'utilisateur est autorisé à publier une nouvelle prédication", function () {
    $user = App\Models\User::first();
    $this->actingAs($user);
    $inputs = [
        "title" => "Testing preaching",
        "preacher" => "Past James",
        "audio_url" => "my-preaching.mp3",
        "cover_url" => "cover.mng",
        "color" => "FX0015CC"
    ];
    $response = post(route("api.v1.preaching.store", $inputs));
    $response->assertStatus(\Illuminate\Http\Response::HTTP_CREATED);
});

test("L'utilisateur n'est pas autorisé à publier une nouvelle prédication pour formulaire vide", function () {
    $user = App\Models\User::first();
    $this->actingAs($user);
    $inputs = [];
    $response = post(route("api.v1.preaching.store", $inputs));
    $response->assertStatus(\Illuminate\Http\Response::HTTP_FOUND);
});


test("L'utilisateur est autorisé à acceder à une prédication", function () {
    $user = App\Models\User::find(1);
    $this->actingAs($user);
    $preaching = Preaching::first();
    $response = get(route("api.v1.preaching.show", $preaching->id));
    $response->assertStatus(\Illuminate\Http\Response::HTTP_OK);
});

test("L'utilisateur n'est autorisé pas à acceder à une prédication s'il n'est pas connecté", function () {
    $preaching = Preaching::first();
    $response = get(route("api.v1.preaching.show", $preaching->id));
    $response->assertStatus(\Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR);
});
test("L'utilisateur n'est pas autorisé à acceder à une prédication avec un mauvais paramètre", function () {
    $user = App\Models\User::find(1);
    $this->actingAs($user);
    $response = get(route("api.v1.preaching.show", 0));
    $response->assertStatus(\Illuminate\Http\Response::HTTP_NOT_FOUND);
});
test("L'utilisateur est autorisé à mettre à jour une prédication ", function () {
    $user = App\Models\User::first();
    $this->actingAs($user);
    $preaching = Preaching::find(15);
    $inputs = [
        "title" => "Test preaching up",
        "preacher" => "Past James up",
        "audio_url" => "my-preaching-up.mp3",
        "cover_url" => "cover-up.mng",
        "color" => "FX0015CC"
    ];
    $response = put(
        route("api.v1.preaching.update", $preaching->id),
        $inputs
    );
    $response->assertStatus(\Illuminate\Http\Response::HTTP_CREATED);
});
test("L'utilisateur n'est pas autorisé à mettre à jour une prédication avec formulaire vide ", function () {
    $user = App\Models\User::first();
    $this->actingAs($user);
    $preaching = Preaching::find(15);
    $inputs = [];
    $response = put(
        route("api.v1.preaching.update", $preaching->id),
        $inputs
    );
    $response->assertStatus(\Illuminate\Http\Response::HTTP_FOUND);
});

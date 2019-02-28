<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APITest extends TestCase
{
    use RefreshDatabase;

    public $firstName = "TestUserFirstName";
    public $lastName = "TestUserLastName";
    public $email = "test.user@site.com";
    public $label = "testLabel";
    public $number = "1234005678";
    public $favorite = "0";

    public function testAPICreateIsAvailable()
    {
        $response = $this->createItem();
        $response->assertStatus(200);
    }

    public function testAPIIndexIsAvailable()
    {
        $response = $this->createItem();
        $response->assertStatus(200);

        $response2 = $this->json(
            'GET',
            '/api/v1/contact',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );
        $response2->assertStatus(200);
    }

    public function testAPIIndexReturnsData()
    {
        $response = $this->createItem();
        $response->assertStatus(200);

        $response2 = $this->json(
            'GET',
            '/api/v1/contact',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response2->assertStatus(200);
        $response2->assertJsonFragment(["name" => $this->firstName]);
        $response2->assertJsonFragment(["surname" => $this->lastName]);
        $response2->assertJsonFragment(["email" => $this->email]);
        $response2->assertJsonFragment(["favorite" => $this->favorite]);
        $response2->assertJsonFragment([
            "label" => $this->label,
            "number" => $this->number,
        ]);
    }

    public function testAPIReturnsContactData()
    {
        $response = $this->createItem();
        $response->assertStatus(200);

        $response1 = $this->json(
            'GET',
            '/api/v1/contact',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $id = $this->getTestUserID($response1);
        $this->assertNotEquals(0, $id);

        $response2 = $this->json(
            'GET',
            '/api/v1/contact/' . $id,
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response2->assertStatus(200);
        $response2->assertJsonFragment(["name" => $this->firstName]);
        $response2->assertJsonFragment(["surname" => $this->lastName]);
        $response2->assertJsonFragment(["email" => $this->email]);
        $response2->assertJsonFragment(["favorite" => $this->favorite]);
        $response2->assertJsonFragment([
            "label" => $this->label,
            "number" => $this->number,
        ]);
    }

    public function testAPIReturnsContactPhonesData()
    {
        $response = $this->createItem();
        $response->assertStatus(200);

        $response1 = $this->json(
            'GET',
            '/api/v1/contact',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $id = $this->getTestUserID($response1);
        $this->assertNotEquals(0, $id);

        $response2 = $this->json(
            'GET',
            '/api/v1/contact/' . $id . '/phones',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response2->assertStatus(200);
        $response2->assertJsonFragment([
            "label" => $this->label,
            "number" => $this->number,
        ]);
    }

    public function testAPIAddsPhoneData()
    {
        $response = $this->createItem();
        $response->assertStatus(200);

        $response1 = $this->json(
            'GET',
            '/api/v1/contact',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $id = $this->getTestUserID($response1);
        $this->assertNotEquals(0, $id);

        $response2 = $this->json(
            'POST',
            '/api/v1/contact/' . $id . '/phone/create',
            [
                "label" => "newLabel",
                "number" => "2340056781",
            ],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );
        $response2->assertStatus(200);

        $response3 = $this->json(
            'GET',
            '/api/v1/contact/' . $id . '/phones',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response3->assertStatus(200);
        $response3->assertJsonFragment([
            "label" => $this->label,
            "number" => $this->number,
        ]);

        $response3->assertJsonFragment([
            "label" => "newLabel",
            "number" => "2340056781",
        ]);
    }

    public function testAPIChangesPhoneData()
    {
        $response = $this->createItem();
        $response->assertStatus(200);

        $response1 = $this->json(
            'GET',
            '/api/v1/contact',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $id = $this->getTestUserID($response1);
        $this->assertNotEquals(0, $id);

        $response2 = $this->json(
            'GET',
            '/api/v1/contact/' . $id . '/phones',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response2->assertStatus(200);
        $phoneId = $this->getPhoneID($response2, $this->label);
        $this->assertNotEquals(0, $phoneId);

        $response3 = $this->json(
            'POST',
            '/api/v1/contact/' . $id . '/phone/' . $phoneId . '/update',
            [
                "label" => "newestLabel",
                "number" => "2340056781",
            ],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );
        $response3->assertStatus(200);


        $response4 = $this->json(
            'GET',
            '/api/v1/contact/' . $id . '/phones',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response4->assertStatus(200);

        $response4->assertJsonFragment([
            "label" => "newestLabel",
            "number" => "2340056781",
        ]);

        $response4->assertJsonMissing([
            "label" => $this->label
        ]);
    }

    public function testAPIRemovesPhoneData()
    {
        $response = $this->createItem();
        $response->assertStatus(200);

        $response1 = $this->json(
            'GET',
            '/api/v1/contact',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $id = $this->getTestUserID($response1);
        $this->assertNotEquals(0, $id);

        $response2 = $this->json(
            'GET',
            '/api/v1/contact/' . $id . '/phones',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response2->assertStatus(200);
        $phoneId = $this->getPhoneID($response2, $this->label);
        $this->assertNotEquals(0, $phoneId);

        $response3 = $this->json(
            'GET',
            '/api/v1/contact/' . $id . '/phone/' . $phoneId . '/destroy',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );
        $response3->assertStatus(200);


        $response4 = $this->json(
            'GET',
            '/api/v1/contact/' . $id . '/phones',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response4->assertStatus(200);

        $response4->assertJsonMissing([
            "label" => $this->label
        ]);
    }


    public function testAPIChangesFavoriteFlag()
    {
        $response = $this->createItem();
        $response->assertStatus(200);

        $response1 = $this->json(
            'GET',
            '/api/v1/contact',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $id = $this->getTestUserID($response1);
        $this->assertNotEquals(0, $id);

        $response2 = $this->json(
            'GET',
            '/api/v1/contact/' . $id,
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response2->assertStatus(200);

        $response2->assertJsonFragment(["favorite" => $this->favorite]);

        $response3 = $this->json(
            'POST',
            '/api/v1/contact/' . $id . '/update',
            [ "favorite" => "1" ],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );
        $response3->assertStatus(200);


        $response4 = $this->json(
            'GET',
            '/api/v1/contact/' . $id,
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response4->assertStatus(200);
        $response4->assertJsonFragment(["favorite" => "1"]);
    }

    public function testAPIUpdatesNameAndSurname()
    {
        $response = $this->createItem();
        $response->assertStatus(200);

        $response1 = $this->json(
            'GET',
            '/api/v1/contact',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $id = $this->getTestUserID($response1);
        $this->assertNotEquals(0, $id);

        $response2 = $this->json(
            'GET',
            '/api/v1/contact/' . $id,
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response2->assertStatus(200);
        $response->assertJsonFragment(["name" => $this->firstName]);
        $response->assertJsonFragment(["surname" => $this->lastName]);

        $response3 = $this->json(
            'POST',
            '/api/v1/contact/' . $id . '/update',
            [
                "name" => "NewFirstName",
                "surname" => "NewLastName",
            ],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );
        $response3->assertStatus(200);

        $response4 = $this->json(
            'GET',
            '/api/v1/contact/' . $id,
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response4->assertStatus(200);
        $response4->assertJsonFragment(["name" => "NewFirstName"]);
        $response4->assertJsonFragment(["surname" => "NewLastName"]);

        $response5 = $this->json(
            'POST',
            '/api/v1/contact/' . $id . '/update',
            [
                "name" => $this->firstName,
                "surname" => $this->lastName,
            ],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );
        $response5->assertStatus(200);
    }

    public function testAPIDeletesContact()
    {
        $response = $this->createItem();
        $response->assertStatus(200);

        $response1 = $this->json(
            'GET',
            '/api/v1/contact',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $id = $this->getTestUserID($response1);
        $this->assertNotEquals(0, $id);

        $response2 = $this->json(
            'GET',
            '/api/v1/contact/' . $id . '/destroy',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );

        $response2->assertStatus(200);


        $response3 = $this->json(
            'GET',
            '/api/v1/contact',
            [],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );
        $response3->assertStatus(200);

        $response3->assertJsonMissing([
            "label" => $this->label,
            "number" => $this->number,
        ]);

    }

    protected function createItem()
    {
        return $this->json(
            'POST',
            '/api/v1/contact/create',
            [
                "name" => $this->firstName,
                "surname" => $this->lastName,
                "email" => $this->email,
                "phones" => [
                    "label" => $this->label,
                    "number" => $this->number,
                ],
                "favorite" => $this->favorite,
            ],
            ['HTTP_X-Authorization' =>  config('app.key')]
        );
    }

    protected function getTestUserID($response)
    {
        $data = json_decode($response->content(), true);

        $id = 0;
        foreach ($data as $contact) {
            if(!empty($contact)) {
                if (
                    ($contact['name'] === $this->firstName) &&
                    ($contact['surname'] === $this->lastName) &&
                    ($contact['email'] === $this->email)
                ) {
                    $id = $contact['id'];
                }
            }
        }

        return $id;
    }

    protected function getPhoneID($response, $label)
    {
        $data = json_decode($response->content(), true);

        $id = 0;
        foreach ($data as $phone) {
            if ($phone['label'] === $label) {
                $id = $phone['id'];
            }
        }

        return $id;
    }
}
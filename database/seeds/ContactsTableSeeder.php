<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Contact;
use App\Phone;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,30) as $index) {
            $name = $faker->firstName;
            $surname = $faker->lastName;
            $contact = Contact::create([
                'name' => $name,
                'surname' => $surname,
                'email' => strtolower($name . '.' . $surname) . '@' . $faker->freeEmailDomain,
                'photo' => $faker->image('public/photos',128,128, 'people', false),
                'favorite' => $faker->boolean,
            ]);

            $phones = $faker->numberBetween(1,3);
            foreach (range(1, $phones) as $index) {
                $phone = Phone::create([
                    'label' => $faker->word,
                    'number' => $faker->phoneNumber,
                    'contact_id' => $contact->id,
                ]);
            }
        }
    }
}

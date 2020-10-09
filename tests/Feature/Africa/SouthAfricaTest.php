<?php

namespace Reducktion\Socrates\Tests\Feature\Africa;

use Carbon\Carbon;
use Reducktion\Socrates\Constants\Gender;
use Reducktion\Socrates\Exceptions\InvalidLengthException;
use Reducktion\Socrates\Laravel\Facades\Socrates;
use Reducktion\Socrates\Tests\Feature\FeatureTest;

class SouthAfricaTest extends FeatureTest
{
    private $people;
    private $invalidIds;

    protected function setUp(): void
    {
        parent::setUp();

        $this->people = [
            'liam' => [
                'id' => '9001015800088',
                'gender' => Gender::MALE,
                'dob' => Carbon::createFromFormat('Y-m-d', '1980-01-01'),
                'age' => Carbon::createFromFormat('Y-m-d', '1980-01-01')->age,
            ],            'jogn' => [
                'id' => '9701014800084',
                'gender' => Gender::MALE,
                'dob' => Carbon::createFromFormat('Y-m-d', '1980-01-01'),
                'age' => Carbon::createFromFormat('Y-m-d', '1980-01-01')->age,
            ],
            'lethabo' => [
                'id' => '9202204720082', // ?
                'gender' => Gender::FEMALE,
                'dob' => Carbon::createFromFormat('Y-m-d', '1992-02-20'),
                'age' => Carbon::createFromFormat('Y-m-d', '1992-02-20')->age,
            ],
//            'amogelang' => [
//                'id' => '150437-3068',
//                'gender' => Gender::FEMALE,
//                'dob' => Carbon::createFromFormat('Y-m-d', '1937-04-15'),
//                'age' => Carbon::createFromFormat('Y-m-d', '1937-04-15')->age,
//            ],
//            'bob' => [
//                'id' => '160888-1995',
//                'gender' => Gender::MALE,
//                'dob' => Carbon::createFromFormat('Y-m-d', '1988-08-16'),
//                'age' => Carbon::createFromFormat('Y-m-d', '1988-08-16')->age,
//            ],
//            'lesedi' => [
//                'id' => '040404-7094',
//                'gender' => Gender::FEMALE,
//                'dob' => Carbon::createFromFormat('Y-m-d', '2004-04-04'),
//                'age' => Carbon::createFromFormat('Y-m-d', '2004-04-04')->age,
//            ],
        ];

        $this->invalidIds = [
            '234321-2454',
            '333694-0034',
            '088383-2313',
            '133232-1323',
            '040404-7054'
        ];
    }

    public function test_extract_behaviour(): void
    {
        foreach ($this->people as $person) {
            $citizen = Socrates::getCitizenDataFromId($person['id'], 'ZA');

            $this->assertEquals($person['gender'], $citizen->getGender());
            $this->assertEquals($person['dob'], $citizen->getDateOfBirth());
            $this->assertEquals($person['age'], $citizen->getAge());
        }

        $this->expectException(InvalidLengthException::class);

        Socrates::getCitizenDataFromId('324432-343', 'ZA');
    }

    public function test_validation_behaviour(): void
    {
        foreach ($this->people as $person) {
            $this->assertTrue(
                Socrates::validateId($person['id'], 'ZA')
            );
        }

//        foreach ($this->invalidIds as $id) {
//            $this->assertFalse(
//                Socrates::validateId($id, 'ZA')
//            );
//        }
//
//        $this->expectException(InvalidLengthException::class);
//
//        Socrates::validateId('21442-2411', 'ZA');
    }
}

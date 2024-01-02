<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;
use App\Models\Client;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'phoneNumber' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'cuil' => ['required', 'digits_between:10,11', 'unique:clients,client_cuil'],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $newClient = new Client([
            'client_cuil' => $input['cuil'],
        ]);

        $newUser = new User([
            'name' => $input['name'],
            'email' => $input['email'],
            'lastName' => $input['lastName'],
            'phoneNumber' => $input['phoneNumber'],
            'address' => $input['address'],
            'dni' => $this->dniSubstractor($input['cuil']),
            'birthdate' => $input['birthdate'],
            'password' => Hash::make($input['password']),
        ]);

        $newClient->save();
        $newClient->user()->save($newUser);

        $newUser->assignRole(['Client']);
        return $newUser;
    }

    private function dniSubstractor($cuil)
    {
        return intdiv((int)fmod($cuil, 1000000000.0), 10);
    }
}

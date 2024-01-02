<?php

namespace Database\Factories;

use App\Models\Administrator;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Client;
use App\Models\Driver;
use App\Models\Supervisor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userable = $this->randomClass(); 

        $dominios = ['.com','.com.ar','.net','.org','.gob','.edu','.mil','.int'];        

        return [
            'name' => $this->faker->name(),
            'lastName' => $this->faker->lastName(),
            'phoneNumber' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'dni' => $this->faker->numberBetween(10000000, 60000000),
            'birthdate' => $this->faker->dateTime(),            
            'email' => $this->faker->word().'@'.$this->faker->word().$this->faker->randomElement($dominios),
            'email_verified_at' => now(),
            //'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'password' => bcrypt('1234'), // password = 1234
            'userable_id' => $userable::factory(),
            'userable_type' => $userable,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_url' => null,
            'current_team_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(callable $callback = null): static
    {
        if (!Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name . '\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }
    /* 
    * randomClass retorna aleatoriamente un tipo de clase
    * Supervisor, Driver o Client
    */
    private function randomClass()
    {
        $prob = fake()->randomDigit();

        if ($prob==0||$prob==1) return Supervisor::class;

        else if ($prob==2) return Administrator::class;
        
        else if ($prob==3||$prob==4||$prob==5) return Driver::class;
        
        else return Client::class;
    }
}

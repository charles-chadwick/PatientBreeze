<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {

        DB::table('users')
            ->truncate();

        User::factory()
            ->create([
                'role'              => UserRole::SuperAdmin,
                'status'            => UserStatus::Active,
                'first_name'        => 'John',
                'last_name'         => 'Doe',
                'email'             => 'john.doe@example.com',
                'created_at'        => "2020-01-01 08:00:00",
                'updated_at'        => "2020-01-01 08:00:00",
                'email_verified_at' => "2020-01-01 08:00:00",
            ]);

        $users_to_create = [
            UserRole::Doctor->value    => 3,
            UserRole::Nurse->value     => 5,
            UserRole::Staff->value => 8,
            UserRole::Patient->value   => 31,
        ];
        $characters = $this->characters();

        foreach ($users_to_create as $role => $create_count) {

            User::factory($create_count)
                ->state(new Sequence(
                    function (Sequence $sequence) use (&$characters) {
                        $character = array_map('trim', array_shift($characters));
                        $user = User::inRandomOrder()
                            ->whereNotIn('role', [UserRole::Patient, UserRole::Patient])
                            ->first();

                        $created_at = fake()
                            ->dateTimeBetween($user->created_at, '-6 months')
                            ->format('Y-m-d H:i:s');

                        $updated_at = fake()->dateTimeBetween($created_at, '-3 months');

                        $first_name = $character['first_name'];
                        $last_name = $character['last_name'];
                        $email = strtolower("$first_name.$last_name@example.com");

                        return [
                            'status'            => UserStatus::Active,
                            'first_name'        => $first_name,
                            'middle_name'       => $character['middle_name'],
                            'last_name'         => $last_name,
                            'email'             => $email,
                            'created_at'        => $created_at,
                            'email_verified_at' => $created_at,
                            'updated_at'        => $updated_at,
                            'created_by'        => $user->id,
                        ];
                    },
                ))
                ->create([
                    'role' => $role
                ]);
        }
    }

    private function characters(): array {

        $character_list = [];
        foreach (explode("\n", env('CHARACTERS')) as $character) {
            $character_data = explode(",", $character);
            $character_list[] = [
                'first_name'  => $character_data[0],
                'middle_name' => $character_data[1],
                'last_name'   => $character_data[2],
                'gender'      => $character_data[3],
            ];
        }
        return $character_list;

    }
}

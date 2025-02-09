<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {

        DB::table('patients')
            ->delete();

        foreach (User::where('role', UserRole::Patient)
                     ->get() as $user) {

            Patient::factory()
                ->create([
                    'gender'     => $this->genders($user->first_name, $user->middle_name, $user->last_name),
                    'user_id'    => $user->id,
                    'created_by' => User::whereNot('role', UserRole::Patient)
                        ->inRandomOrder()
                        ->first()->id,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->created_at
                ]);
        }
    }

    private function genders($first_name, $middle_name, $last_name): string {

        $find = "$first_name-$middle_name-$last_name";
        foreach (explode("\n", env("CHARACTERS")) as $character) {
            $character_data = array_map('trim', explode(",", $character));
            $key = "{$character_data[0]}-{$character_data[1]}-{$character_data[2]}";
            if ($key === $find) {
                return $character_data[3];
            }
        }

        return "Male";
    }
}

<?php

namespace Database\Seeders;

use App\Enums\DocumentStatus;
use App\Enums\DocumentType;
use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {

        Storage::disk('public')->deleteDirectory('avatars');
        DB::table('documents')
            ->delete();

        // get all users. we will be adding their user profile pic
        foreach (User::get() as $user) {

            $original_file_name = $user->first_name;
            if ($user->middle_name != '') {
                $original_file_name .= " {$user->middle_name}";
            }
            $original_file_name .= " {$user->last_name}";
            $original_file_name = strtolower(str_replace(' ', '_', $original_file_name)) . ".jpg";
            $file_path = "database/src/pics/$original_file_name";

            if (!file_exists($file_path)) {
                echo "$file_path does not exist!\n";
                continue;
            }

            $extension = pathinfo($file_path, PATHINFO_EXTENSION);
            $tmp_file_name = uniqid('a_') . ".$extension";

            Storage::disk('public')->put("avatars/".$tmp_file_name, file_get_contents($file_path));

            $user->avatar()
                ->create([
                    'status'             => DocumentStatus::Accepted,
                    'mime'               => $extension,
                    'size'               => filesize($file_path),
                    'file_name'          => $tmp_file_name,
                    'original_file_name' => $original_file_name,
                    'title'              => "$user->first_name's Avatar",
                    'type'               => DocumentType::Avatar,
                    'created_at'         => fake()->dateTimeBetween($user->created_at, "+ ".rand(1, 5)." minute")
                ]);
        }
    }
}

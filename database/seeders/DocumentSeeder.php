<?php

namespace Database\Seeders;

use App\Enums\DocumentStatus;
use App\Enums\DocumentType;
use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {

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
            $tmp_file_name = $original_file_name;

            Storage::disk('public')->put("pics/".$tmp_file_name, file_get_contents($file_path));

            $user->profilePhoto()
                ->create([
                    'status'             => DocumentStatus::Accepted,
                    'file_name'          => $tmp_file_name,
                    'original_file_name' => $original_file_name,
                    'title'              => "$user->first_name's Profile Pic",
                    'type'               => DocumentType::ProfilePhoto,
                ]);
        }
    }
}

<?php /** @noinspection ALL */

namespace Database\Seeders;

use App\Enums\DiscussionPostStatus;
use App\Enums\DiscussionStatus;
use App\Enums\DiscussionType;
use App\Enums\UserRole;
use App\Models\Discussion;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscussionSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {

        DB::table('discussions')
            ->delete();
        DB::table('discussions_posts')
            ->delete();
        DB::table('discussions_users')
            ->delete();

        // grab a handful of users
        $doctor = User::where('role', UserRole::Doctor)
            ->inRandomOrder()
            ->first();
        $staff = User::where('role', UserRole::Staff)
            ->inRandomOrder()
            ->first();
        $patient = User::where('role', UserRole::Patient)
            ->inRandomOrder()
            ->first();

        // now, create a discussion topic, starting with the patient
        $discussion = Discussion::create([
            'type'       => DiscussionType::PrivateMessage,
            'status'     => DiscussionStatus::Open,
            'title'      => fake()->bs(),
            'created_at' => fake()->dateTimeBetween($patient->created_at, "+1 month"),
            'created_by' => $patient->id,
        ]);

        $discussion->users()->attach([$patient], [
            'created_by' => $patient->id,
            'created_at' => $discussion->created_at
        ]);

        $discussion->users()->attach([$staff, $doctor], [
            'created_by' => $patient->id,
            'created_at' => $discussion->created_at
        ]);

        // now create some random posts
        $discussion->posts()->create([
            'order' => 1,
            'status' => DiscussionPostStatus::Read,
            'content' => fake()->paragraph(rand(1, 3)),
            'created_by' => $patient->id,
            'created_at' => $discussion->created_at
        ]);

        // now create some random posts
        $discussion->posts()->create([
            'order' => 2,
            'status' => DiscussionPostStatus::Read,
            'content' => fake()->paragraph(rand(1, 3)),
            'created_by' => $staff->id,
            'created_at' => $discussion->created_at
        ]);
        // now create some random posts
        $discussion->posts()->create([
            'order' => 3,
            'status' => DiscussionPostStatus::Read,
            'content' => fake()->paragraph(rand(1, 3)),
            'created_by' => $doctor->id,
            'created_at' => $discussion->created_at
        ]);
    }
}

<?php

namespace Tests\Support;

use App\Models\User;
use App\Models\Users\Student;
use Illuminate\Contracts\Auth\Authenticatable;

trait Authentication
{
    /**
     * @var $user
     */
    protected $user;

    /**
     * @before
     */
    public function setupUser()
    {
        $this->afterApplicationCreated(function () {
            $student = Student::factory()->create();

            $this->user = User::factory()->create([
                'user_id' => $student->id
            ]);
        });
    }

    public function authenticated(Authenticatable $user = null)
    {
        return $this->actingAs($user ?? $this->user);
    }

    /**
     * Helper function
     *
     * @param $password
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function createUser($password) {
        $student = Student::factory()->create();

        $user = User::factory()->create([
            'password' => bcrypt($password),
            'user_id' => $student->id
        ]);

        return $user;
    }
}

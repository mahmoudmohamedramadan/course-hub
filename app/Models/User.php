<?php

namespace App\Models;

use App\Models\Helpers\UserHelpers;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Jobs\SendRegisterationConfirmationMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends BaseAuthModel implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, UserHelpers;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        SendRegisterationConfirmationMail::dispatch($this)
            ->afterResponse();
    }

    /**
     * Get the courses the user is enrolled in.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }

    /**
     * Get the lesson progress for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class);
    }
}

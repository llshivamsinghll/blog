<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Fillable attributes
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
    ];

    // Attributes to hide in JSON responses
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Attributes to cast to specific data types
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Mutator to hash the password before saving to the database
    public function setPasswordAttribute($value)
    {
        // If the password is being updated, hash it before saving
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // Method to check if the provided password matches the stored hashed password
    public function correctPassword($candidatePassword)
    {
        return Hash::check($candidatePassword, $this->password);
    }

    // Validation for email
    public static function validateEmail($email)
    {
        return Validator::make(
            ['email' => $email],
            ['email' => 'required|email|unique:users,email']
        );
    }

    // Validation for the user model (name, email, password)
    public static function validateUser($data)
    {
        return Validator::make($data, [
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'is_author',
        'description',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['password'];


    public static function create($user_data) {
        $user = new User;

        $user['name'] = $user_data['name'];
        $user['surname'] = $user_data['surname'];
        $user['email'] = $user_data['email'];
        $user['password'] = Hash::make($user_data['password']);

        if (!isset($user_data['description'])) {
            $user_data['description'] = '';
        }
    
        if (!isset($user_data['avatar'])) {
            $user_data['avatar'] = '';
        }
    
        $user['avatar'] = $user_data['avatar'];
        $user['description'] = $user_data['description'];

        $user->save();
        return;
    }

    public static function updateById($user_data) {
        $user = User::find($user_data['id']);

        $user['name'] = $user_data['name'];
        $user['surname'] = $user_data['surname'];
        $user['email'] = $user_data['email'];
        $user['description'] = $user_data['description'];

        if (isset($user_data['password'])) {
            $user['password'] = Hash::make($user_data['password']);
        }
    
        if (isset($user_data['avatar'])) {
            $user['avatar'] = $user_data['avatar'];
        }

        $user->save();
        return;
    }

    public static function updateAvatar(int $id, string $avatar) {
        $user = User::find($id);
        $user['avatar'] = $avatar;
        $user->save();
        return;
    }

    public static function getByEmail($email) {
        return User::where('email', $email)->first();
    }
}

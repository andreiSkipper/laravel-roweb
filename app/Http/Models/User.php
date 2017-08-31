<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Creativeorange\Gravatar\Gravatar;

class User extends Authenticatable
{
    use Notifiable;
    use SyncableGraphNodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'facebook_user_id', 'access_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getRoles()
    {
        $roles = array_flip(Config::get('constants.roles'));

        return $roles;
    }

    public function getRole()
    {
        return $this->getRoles()[$this->role];
    }

    public static function createFacebookUser($facebook_user)
    {
        $model = new User();
        $user = $model->where('email', $facebook_user['email'])->first();
        if (empty($user)) {
            return $model->create([
                'name' => $facebook_user['name'],
                'email' => $facebook_user['email'],
                'password' => bcrypt($facebook_user['email']),
                'facebook_user_id' => $facebook_user['id'],
                'access_token' => Session::get('fb_user_access_token'),
            ]);
        } else {
            $model->update([
                'name' => $facebook_user['name'],
                'facebook_user_id' => $facebook_user['id'],
                'access_token' => Session::get('fb_user_access_token'),
            ]);

            return $user;
        }
    }

    public static function getAvatar()
    {
        $fb = app(LaravelFacebookSdk::class);
        /** @var User $user */
        $user = Auth::user();
//        $token = Session::get('fb_user_access_token');
        $token = $user->access_token;
        if (empty($token)) {
            $gravatar = new Gravatar();
            return $gravatar->get($user->email);
        } else {
            $fb->setDefaultAccessToken($token);
            $albums = $fb->get('/me/albums')->getGraphEdge()->asArray();
            if (isset($albums[0])) {
                $photos = $fb->get('/' . $albums[0]['id'] . '/photos?fields=picture')->getGraphEdge()->asArray();
                return $photos[0]['picture'];
            } else {
                $gravatar = new Gravatar();
                /** @var User $user */
                $user = Auth::user();
                return $gravatar->get($user->email);
            }
        }
    }

    public static function getUserFeed($page = 0, $rows = 5)
    {
        $fb = app(LaravelFacebookSdk::class);
        /** @var User $user */
        $user = Auth::user();
//        $token = Session::get('fb_user_access_token');
        $token = $user->access_token;
        if (empty($token)) {
            return array();
        }
        $fb->setDefaultAccessToken($token);
        $feed = $fb->get('/me/feed?fields=id,message,story,attachments,created_time&offset=' . $page . '&limit=' . $rows)->getGraphEdge()->asArray();

        return $feed;
    }
}

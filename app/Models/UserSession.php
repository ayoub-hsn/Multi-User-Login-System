<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getActiveUserId()
    {
        $session_id = session()->getId();
        $user_session = self::where('session_id', $session_id)->first();
        if ($user_session) {
            return $user_session->user_id;
        }
        return null;
    }
}

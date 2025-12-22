<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    // use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'mobile','agentcode',  'scheme_id', 'password', 'remember_token', 'role_id', 'parent_id', 'company_id','highest_qualification','area_of_interest', 'status','state','city','pincode', 'address', 'department_id', 'gender'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected static $logAttributes = ['id', 'name', 'email', 'mobile', 'password', 'status', 'address', 'apptoken'];

    protected static $logOnlyDirty = true;

    public $with = ['role', 'company', 'department'];
    protected $appends = ['parents'];

    public function role()
    {

        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function getParentsAttribute()
    {
        $user = User::where('id', $this->parent_id)->first(['id', 'name', 'mobile', 'role_id']);
        if ($user) {
            return $user->name . " (" . $user->id . ")<br>" . $user->mobile . "<br>" . $user->role->name;
        } else {
            return "Not Found";
        }
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }


    public static function createUserFromAndroid($post, $role)
    {
        dd($post);
        // try {
        $isUserCreated = false;

        // DB::beginTransaction();

        $admin = self::whereHas('role', function ($q) {
            $q->where('slug', 'admin');
        })->first(['id', 'company_id']);

        $insertuser = $post->all();
        unset($insertuser['aadhaarcard']);
        unset($insertuser['slug']);
        $insertuser['role_id'] = $role->id;
        $insertuser['aadharcard'] = $post->aadhaarcard;
        // $insertuser['id'] = "new";
        $insertuser['parent_id'] = $admin->id;
        $insertuser['password'] = bcrypt($post->mobile);
        $insertuser['company_id'] = $admin->company_id;
        $insertuser['agentcode'] = $post->agentcode;
        $insertuser['status'] = "pending";
        $insertuser['kyc'] = "pending";
        unset($insertuser['meta']);

        // dd($insertuser);

        $isUserCreated = self::insertGetId($insertuser);

        // } catch (Exception $e) {
        //     DB::rollBack();
        //     $isUserCreated = false;

        // }

        return $isUserCreated;



    }

    public static function userDetailUpdate(string $whereKey, string $whereValue, array $data)
    {
        $isTableUpdate = false;
        if (!empty($whereKey) && !empty($whereValue)) {
            $table_name = self::where($whereKey, '=', $whereValue);
            $isTableUpdate = $table_name->update($data);
        }
        return (bool) $isTableUpdate;



    }

}

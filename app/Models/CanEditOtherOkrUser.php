<?php

namespace App\Models;

use App\Enums\CanEdit;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CanEditOtherOkrUser extends Authenticatable
{
    use CastsEnums;

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'can_edit_other_okr_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'target_user_id',
        'can_edit',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'int',
        'target_user_id' => 'int',
        'can_edit' => 'int',
    ];

    protected $enumCasts = [
        'can_edit' => CanEdit::class,
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function target_users(): HasMany
    {
        return $this->hasMany(User::class, 'target_user_id');
    }
}

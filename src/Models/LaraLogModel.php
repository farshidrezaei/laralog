<?php


namespace FarshidRezaei\LaraLog\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * FarshidRezaei\LaraLog\Models\LaraLogModel
 *
 * @property int $id
 * @property string $created_at
 * @property string $level
 * @property string|null $subject
 * @property string|null $message
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\FarshidRezaei\LaraLog\Models\LaraLogModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\FarshidRezaei\LaraLog\Models\LaraLogModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\FarshidRezaei\LaraLog\Models\LaraLogModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\FarshidRezaei\LaraLog\Models\LaraLogModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FarshidRezaei\LaraLog\Models\LaraLogModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FarshidRezaei\LaraLog\Models\LaraLogModel whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FarshidRezaei\LaraLog\Models\LaraLogModel whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FarshidRezaei\LaraLog\Models\LaraLogModel whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\FarshidRezaei\LaraLog\Models\LaraLogModel whereUserId($value)
 * @mixin \Eloquent
 */
class LaraLogModel extends Model
{
    protected $table = 'laralogs';

    protected $guarded = [];

    public $timestamps = false;

    public const CREATED_AT = 'created_at';

}
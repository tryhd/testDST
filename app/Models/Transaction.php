<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Transaction
 * 
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int $product_id
 * @property int $amount
 * @property int $tax
 * @property int $admin_fee
 * @property int $total
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 * @property User $user
 *
 * @package App\Models
 */
class Transaction extends Model
{
	use SoftDeletes;
	protected $table = 'transactions';

	protected $casts = [
		'user_id' => 'int',
		'product_id' => 'int',
		'amount' => 'int',
		'tax' => 'int',
		'admin_fee' => 'int',
		'total' => 'int'
	];

	protected $fillable = [
		'uuid',
		'user_id',
		'product_id',
		'amount',
		'tax',
		'admin_fee',
		'total'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}

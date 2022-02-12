<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * 
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $type
 * @property float $price
 * @property int $quantity
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Transaction[] $transactions
 *
 * @package App\Models
 */
class Product extends Model
{
	use SoftDeletes;
	protected $table = 'products';

	protected $casts = [
		'price' => 'float',
		'quantity' => 'int'
	];

	protected $fillable = [
		'uuid',
		'name',
		'type',
		'price',
		'quantity'
	];

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}
}

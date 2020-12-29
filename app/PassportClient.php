<?php
namespace App;
use Laravel\Passport\Client as OAuthClient;
use Illuminate\Support\Str;

/** 
* Indicates if the IDs are auto-incrementing. 
* 
* @var bool 
*/ 
class PassportClient extends OAuthClient
{ 

	public $incrementing = false;
	protected $keyType = 'string';
	public static function boot()
	{ 
		parent::boot();
		static::creating(function ($model) {
			$model->{$model->getKeyName()} = (string) Str::uuid();
		});
	}
	// public function __construct(array $attributes = array())
	// {
	//     parent::__construct($attributes);

	//     $this->incrementing = $this->getIncrementing();
	//     $this->keyType = $this->getKeyType();
	// }
}
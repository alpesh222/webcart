<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'username', 'email', 'phone', 'password', 'is_active', 'role_id', 'photo_id', 'location_id', 'activation_token', 'verified','wallet_balance'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() {
        return $this->belongsTo('App\Role');
    }

    public function products() {
        return $this->hasMany('App\Product');
    }

    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    public function orders() {
        return $this->hasMany('App\Order');
    }

    public function customers() {
        return $this->hasMany('App\Customer');
    }

    public function addresses() {
        return $this->hasMany('App\Address');
    }

    public function location() {
        return $this->belongsTo('App\Location');
    }

    public function reviews() {
        return $this->hasMany('App\Review');
    }

    public function vouchers() {
        return $this->belongsToMany('App\Voucher')->withPivot(['uses']);
    }

    public function shipments() {
        return $this->belongsToMany('App\Shipment')->withTimestamps();
    }

    public function wallets() {
        return $this->hasMany('App\wallet');
    }

    public function walletBalance()
    {
        return $this->wallet_balance;
    }
    public function favouriteProducts() {
        return $this->morphedByMany('App\Product', 'favouriteable')
                    ->withPivot(['created_at'])
                    ->orderBy('pivot_created_at', 'desc');
    }

    public function mobile() {
        return $this->hasOne('App\Mobile');
    }

    public function vendor() {
        return $this->hasOne('App\Vendor');
    }

    public function isApprovedVendor() {
        if($this->vendor && $this->vendor->approved) {
            return $this->vendor;
        }
        return false;
    }

    public function isSuperAdmin() {
        if($this->role) {
            if($this->role->id == 1 && $this->is_active == 1) {
                return true;
            }
        }
    }

    public function isAdmin() {
        if($this->role) {
            if($this->role->id == 2 && $this->is_active == 1) {
                return true;
            }
        }
    }

    public function hasRole() {
        if($this->role) {
            return true;
        }
        return false;
    }

    public static function generateUniqueReferralCode( $length = 20 ) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $referral_code = '';
        for ($i = 0; $i < $length; $i++) {
            $referral_code .= $characters[rand(0, $charactersLength - 1)];
        }
        $referral_exist = self::checkReferralCodeExist($referral_code);
        if ( !$referral_exist['status'] ){
            return $referral_code;
        }else{
            self::generateUniqueReferralCode(6);
        }
    }

    public static function checkReferralCodeExist( $referral_code ){
        $referral_exist = self::where([
            'self_referral_code'    => $referral_code,
            'verified'              => 1,
            'is_active'             => 1,
        ])->get();
        if ( $referral_exist->count() > 0 ){
            $response = [
                'status'    => true,
                'message'   => __('Referral Code Successfully Found!')
            ];
        }else{
            $response = [
                'status'    => false,
                'message'   => __('No Such Referral Code Found!')
            ];
        }
        return $response;
    }
}

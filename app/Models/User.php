<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use DB ;
class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','countryId','phoneNumber','country_code','rank_','rank_type','registration_from'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function advertisement(){
        $advPath = config('constants.advertisement_image') ;
        return DB::table('advertisements')->select('advertisements.id','sponser.name',DB::raw('concat("'.$advPath.'",advertisements.image) as image'),'advertisements.ad_type')->join('sponser', 'sponser.id', '=', 'advertisements.sponser_id')->where('advertisements.status',1)->get();
    }

    public static function getFollowers($userId){

      $socialInfo = DB::table('social_info')->select('type','social_type','followers_count')->where('user_id',$userId)->get();
      $response=array(
        'facebook_followers'=>0,
        'insta_followers'=>0,
        'tiktok_followers'=>0,
        'walkofweb_followers'=>0
      );
      if(!empty($socialInfo)){
        foreach ($socialInfo as $key => $value) {
          if($value->social_type==2){
            $response['facebook_followers']=$value->followers_count ;
          }else if($value->social_type==3){
             $response['insta_followers'] = $value->followers_count ;
           }else if($value->social_type==4){
             $response['tiktok_followers'] = $value->followers_count ;
           }else if($value->social_type==5){
             $response['walkofweb_followers'] = $value->followers_count ;
           }
        }
      }
      return $response ;
    }

     public static function getFollowersCount($userId){

      $socialInfo = DB::table('social_info')->select(DB::raw('case when sum(followers_count) is null then 0 else sum(followers_count) end as totalCount'))->where('user_id',$userId)->first();
      $response=array();
      if(!empty($socialInfo)){
        return $socialInfo->totalCount ;
      }
      return 0 ;
    }

     public static function getUserRank($userId){

      $socialInfo = DB::table('users')->select('rank_')->where('id',$userId)->first();
     
      if(!empty($socialInfo)){
        return $socialInfo->rank_ ;
      }
      return 0 ;
    }


}

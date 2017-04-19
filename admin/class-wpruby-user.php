<?php

/**
 * The User helper class of the plugin.
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    WPRuby_User
 * @subpackage WPRuby_User/admin
 */

/**
 * The User helper class of the plugin.
 *
 *
 * @package    WPRuby_User
 * @subpackage WPRuby_User/admin
 * @author     WPRuby <info@wpruby.com>
 */
class WPRuby_User {

  protected $default_avatar = 'https://www.somewhere.com/homestar.jpg';
  protected $avater_size = 80;
  protected $email = '';
  protected $username = '';
  protected $first_name = '';
  protected $last_name = '';
  protected $nicename = '';
  protected $registerd_at = '';


  public function __construct($user_id){
    $user_info = get_userdata($user_id);

    $this->email = $user_info->user_email;
    $this->username = $user_info->user_login;
    $this->first_name = $user_info->first_name;
    $this->last_name = $user_info->last_name;
    $this->nicename = $user_info->user_nicename;
    $this->registerd_at = $user_info->user_registered;

  }

  public function get_avatar(){
    $avatar_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->email ) ) ) . "?d=identicon&s=" . $this->avater_size;
    return $avatar_url;
  }

  public function get_email(){
    return $this->email;
  }

  public function get_username(){
    return $this->username;
  }

  public function get_first_name(){
    return $this->first_name;
  }


  public function get_last_name(){
    return $this->last_name;
  }

  public function get_full_name(){
    $full_name =  $this->first_name . ' ' . $this->last_name;
    if(trim($full_name) == ''){
      $full_name = $this->nicename;
    }
    return $full_name;
  }
  public function get_registerd_at(){
    return $this->registerd_at;
  }





}

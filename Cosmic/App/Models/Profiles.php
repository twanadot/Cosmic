<?php
namespace App\Models;

use PDO;
use QueryBuilder;

class Profiles{
 public static function hasWidget($user_id, $name){
  return QueryBuilder::table('cms_homes')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->where('user_id', $user_id)->where('name', $name)->get();
 }
 
 public static function insertFirstWidgets($user_id){
  $data = array(
   array('user_id' => $user_id,'type' => 'b','name' => 'bg_pattern_abstract2.gif','z' => 0,'x' => 0,'y' => 0,'skin' => '','visible'=> 1,'data' => null),
   array('user_id' => $user_id,'type' => 'w','name' => 'myhabbo','z' => 0,'x' => 455,'y' => 27,'skin' => 'default_skin','visible'=> 1,'data' => null),
   array('user_id' => $user_id,'type' => 'w','name' => 'rooms','z' => 0,'x' => 490,'y' => 245,'skin' => 'default_skin','visible' => 1,'data' => null),
   array('user_id' => $user_id,'type' => 'w','name' => 'mybadges','z' => 0,'x' => 0,'y' => 0,'skin' => 'golden_skin','visible' => 0,'data' => null),
   array('user_id' => $user_id,'type' => 'w','name' => 'friends','z' => 0,'x' => 0,'y' => 0,'skin' => 'notepad_skin','visible' => 0,'data' => null),
   array('user_id' => $user_id,'type' => 'w','name' => 'groups','z' => 0,'x' => 0,'y' => 0,'skin' => 'golden_skin','visible' => 0,'data' => null),
   array('user_id' => $user_id,'type' => 'w','name' => 'photo','z' => 0,'x' => 0,'y' => 0,'skin' => 'photo','visible' => 0,'data' => '/legacy/images/empty_photo.gif'),
   array('user_id' => $user_id,'type' => 'n','name' => 'note','z' => 0,'x' => 125,'y' => 38,'skin' => 'note_skin','visible' => 1,'data' => 'Remember! Posting personal information about yourself or your friends, including addresses, phone numbers or email, and getting round the filter will result in your note being deleted. Deleted notes will not be refunded.'),
   array('user_id' => $user_id,'type' => 'n','name' => 'note','z' => 0,'x' => 56,'y' => 229,'skin' => 'bubble_skin','visible' => 1,'data' => 'Welcome to a brand new Habbo Home page! This is the place where you can express yourself with a wild and unique variety of stickers, hoot yo trap off with colourful notes and showcase your Habbo rooms! To start editing just click the edit button.'),
   array('user_id' => $user_id,'type' => 'n','name' => 'note','z' => 0,'x' => 110,'y' => 429,'skin' => 'notepad_skin','visible' => 1,'data' => 'Where are my friends? To add your buddy list to your page click edit and look in your widgets inventory. After placing it on the page you can move it all over the place and even change how it looks. Go on!'),
   array('user_id' => $user_id,'type' => 's','name' => 'sticker_spaceduck','z' => 150,'x' => 260,'y' => 376,'skin' => null,'visible' => 1,'data' => null),
   array('user_id' => $user_id,'type' => 's','name' => 'needle_3','z' => 150,'x' => 119,'y' => 29,'skin' => null,'visible' => 1,'data' => null),
   array('user_id' => $user_id,'type' => 's','name' => 'paper_clip_1','z' => 150,'x' => 143,'y' => 398,'skin' => null,'visible' => 1,'data' => null)
  );
  return QueryBuilder::table('cms_homes')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->insert($data);
 }
 
 public static function getWidgets($user_id){
  return QueryBuilder::table('cms_homes')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->where('user_id', $user_id)->whereIn('type',array('s', 'w'))->orderBy('z')->get();
 }
 
 public static function inventoryWidgets($user_id){
  return QueryBuilder::table('cms_homes')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->where('user_id', $user_id)->where('type','w')->where('visible','0')->get();
 }
 
 public static function background($user_id){
  return QueryBuilder::table('cms_homes')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->where('user_id', $user_id)->where('type','b')->get();
 }
 
 public static function inventoryBackgrounds($user_id){
  return QueryBuilder::table('cms_homes')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->where('user_id', $user_id)->where('type','b')->where('visible','0')->orderBy('z')->get();
 }
 
 public static function getItems($data){
  return QueryBuilder::table('cms_homes_catalogue')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->where('type',$data)->get();
 }
  
 public static function getBackground(){
  return QueryBuilder::table('cms_homes')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->where('visible', '1')->where('type','b')->first();
 }
 
 public static function getNotes($user_id){
  return QueryBuilder::table('cms_homes')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->where('user_id', $user_id)->where('type','n')->get();
 }
  
 public static function getCategorys(){
  return QueryBuilder::table('cms_homes_catalogue_cats')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->where('type','s')->get();
 }
 
  
 public static function saveBackground($user_id, $name){
  return QueryBuilder::table('cms_homes')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->where('user_id', $user_id)->where('type', 'b')->update(array('name' => $name));
 }
 
 public static function update($user_id, $name, $top, $left, $skin, $type){
  $data = array(
   'name'     => $name,
   'skin'     => $skin,
   'x'    		=> $left,
   'y'    		=> $top,
   'type'     => $type
  );
  return QueryBuilder::table('cms_homes')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->where('user_id', $user_id)->where('name', $name)->update($data);
 }
  
  public static function insert($user_id, $name, $top, $left, $skin, $type){
  $data = array(
   'user_id'  => $user_id,
   'name'     => $name,
   'skin'     => $skin,
   'x'    		=> $left,
   'y'    		=> $top,
   'type'     => $type
  );
  return QueryBuilder::table('cms_homes')->setFetchMode(PDO::FETCH_CLASS, get_called_class())->insert($data);
 }
 
 public static function remove($user_id, $item_id, $type){
   return QueryBuilder::table('cms_homes')->where('id', $item_id)->where('user_id', $user_id)->where('type', $type)->delete();
 }
}
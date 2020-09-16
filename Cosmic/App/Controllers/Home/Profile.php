<?php
namespace App\Controllers\Home;

use App\Config;
use App\Helper;
use App\Models\Community;
use App\Models\Player;
use App\Models\Profiles;

use Core\Locale;
use Core\View;

use Library\Json;

use stdClass;

class Profile
{
    public function __construct()
    {
        $this->data = new stdClass();
    }

    public function profile($username = null)
    {
      
        if($username == null) {
            redirect('/');
            exit;
        }

        $player = Player::getDataByUsername($username);
        if($player == null) {
            redirect('/');
            exit;
        }
      

        $this->data->player = $player;
        $this->data->player->last_online = $this->data->player->last_online;
        $this->data->player->settings = Player::getSettings($player->id);

        $this->data->player->badges = Player::getBadges($player->id);
        $this->data->player->friends = Player::getFriends($player->id);

        $this->data->player->groups = Player::getGroups($player->id);
        $this->data->player->rooms = Player::getRooms($player->id);
        $this->data->player->photos = Player::getPhotos($player->id);

        $this->data->player->badgeCount = count($this->data->player->badges);
        $this->data->player->friendCount = count($this->data->player->friends);
        $this->data->player->groupCount = count($this->data->player->groups);
        $this->data->player->roomCount = count($this->data->player->rooms);
        $this->data->player->photoCount = count($this->data->player->photos);

        $this->data->player->feeds = Community::getFeedsByUserid($player->id);
        $this->data->player->feedCount = count($this->data->player->feeds);
        $this->data->player->feedCountTotal = count($this->data->player->feeds);
      
        $this->data->player->widgets = Profiles::getWidgets($player->id);
        $this->data->player->background = Profiles::getBackground($player->id);
        $this->data->player->notes = Profiles::getNotes($player->id);

        foreach ($this->data->player->feeds as $row) {
            $row->likes = Community::getLikes($row->id);
        }

        $this->template();
    }

    public function feeds($offset = null, $user_id = null)
    {
        $feeds = Community::getFeedsByUserIdOffset($offset, $user_id, 6);

        foreach ($feeds as $row) {
            $from_user = Player::getDataById($row->from_user_id, array('username','look'));
            $row->from_username = $from_user->username;
            $row->figure = $from_user->look ?? null;
            $row->likes = Community::getLikes($row->id);
            $row->message = Helper::bbCode($row->message);
        }

        return $feeds;
    }

    public function search()
    {
        if(!Player::exists(input()->post('search')->value)) {
            response()->json(["status" => "error", "message" => Locale::get('core/notification/profile_notfound')]);
        }

        response()->json(["replacepage" => "profile/" . input()->post('search')->value]);
    }
  
    public function store()
    {
        if(!request()->player->id) {
            response()->json(["status" => "error", "message" => Locale::get('core/notification/something_wrong')]);
        }
      
        $categorys = Profiles::getCategorys();
        $items = Profiles::getItems(input()->post('data')->value);
      
        response()->json(["items" => $items, "categorys" => $categorys]);
    }
  
    public function remove() 
    {
        if(!request()->player->id) {
            response()->json(["status" => "error", "message" => Locale::get('core/notification/something_wrong')]);
        }
      
        Profiles::remove(request()->player->id, input()->post('id')->value, input()->post('type')->value);
        response()->json(["status" => "success", "message" => "Widget deleted!"]); 
    }

    public function save()
    {
        if(!request()->player->id) {
            response()->json(["status" => "error", "message" => Locale::get('core/notification/something_wrong')]);
        }
      
        $items = json_decode(input()->post('draggable')->value);
        foreach($items as $i => $v){
            if(Profiles::hasWidget(request()->player->id, $v[0])) {
                Profiles::update(request()->player->id, $v[0], $v[1], $v[2], $v[3], $v[4]);
            } else {
                Profiles::insert(request()->player->id, $v[0], $v[1], $v[2], $v[3], $v[4]);
            }
        }
      
        Profiles::saveBackground(request()->player->id, input()->post('background')->value);
      
        response()->json(["status" => "success", "message" => "Homepage successfully saved."]);
    }
  
    public function template()
    {
        View::renderTemplate('Home/profile.html', [
         'title' => $this->data->player->username,
         'page'  => 'profile',
         'data'  => $this->data,
        ]);
    }
}

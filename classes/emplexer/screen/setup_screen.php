<?php

/**
*
*/
class SetupScreen implements ScreenInterface
{
    protected $screenName;
    function __construct($name='rootSetup') {
        if (strstr(strtolower($name), ':' )){ //necessário chamar o metodo primeiro
            $s = explode(':', $name);
            $this->$s[0]();
            $this->screenName = $s[1];
        } else {
            $this->screenName =  $name;
        }
    }

    public function generateScreen(){
        if (strstr($this->screenName, "nfs")){
            $a = explode("_", $this->screenName);
            $b= new NfsScreen('192.168.2.9');
            return $b->generateScreen();
        }
        $fun = "get".ucwords($this->screenName);
        return $this->$fun();
    }

    public function getRootSetup(){
      $itens = array();
        $folderItems = array();
        $folderItems[] = array(
            PluginRegularFolderItem::media_url          => "plexSetup",
            PluginRegularFolderItem::caption            => "Plex Setup" ,
            PluginRegularFolderItem::view_item_params   => array()
        );

        // var_dump($folderItems);

        $availableTemplates = array(
            PluginRegularFolderView::async_icon_loading             => true,
            PluginRegularFolderView::initial_range                  =>
            array(
                PluginRegularFolderRange::items                         =>  $folderItems,
                PluginRegularFolderRange::total                         =>  count($folderItems),
                PluginRegularFolderRange::count                         =>  count($folderItems),
                PluginRegularFolderRange::more_items_available          =>  false,
                PluginRegularFolderRange::from_ndx                      =>  0
                ),
            PluginRegularFolderView::view_params                    => array (
                ViewParams::num_cols  => 1,
                ViewParams::num_rows  => 10
            ),

            PluginRegularFolderView::base_view_item_params          => array(
            ),
            PluginRegularFolderView::not_loaded_view_item_params    => array(),
            PluginRegularFolderView::actions => array(
                GUI_EVENT_KEY_ENTER => array(
                    GuiAction::handler_string_id => PLUGIN_OPEN_FOLDER_ACTION_ID)
            )
        );

        $a = array(
            PluginFolderView::view_kind                             =>  PLUGIN_FOLDER_VIEW_REGULAR,
            PluginFolderView::data                                  => $availableTemplates
        );
        return $a;
    }


    public function getPlexSetup(){
        // $servers = json_decode(Client::getInstance()->get("http://127.0.0.1:3000/findServers"));
        // $serverPairs  = array();

        // foreach ($servers as $value) {
        //     $name = trim($value->Name);
        //     $ip = trim($value->Host) . ':' . trim($value->Port);
        //     $serverPairs[$name] = $ip ;

        // }

        $controls = array();
        $controls[] =array(
            "name" =>  "plexIp",
            "title" => "Plex IP",
            "kind" => "text_field",
            "specific_def" => array(
                "initial_value" => "192.168.2.8",
                "numeric" => 0,
                "password" => 0,
                "has_osk" => 0,
                "always_active" => 0,
                "width" => 500,
                "apply_action" => null,
                "confirm_action" => null
            )
          );

        $controls[] =array(
            "name" =>  "plexPort",
            "title" => "Plex Port",
            "kind" => "text_field",
            "specific_def" => array(
                "initial_value" => "3128",
                "numeric" => true,
                "password" => 0,
                "has_osk" => 0,
                "always_active" => 0,
                "width" => 500,
                "apply_action" => null,
                "confirm_action" => null
            )
          );



        // var_dump($servers);
        // $controls[] = array(
        //     "name" =>  "findServer",
        //     "title" => "Plex Server",
        //     "kind" => "button",
        //     "specific_def" => array(
        //         "initial_value" => "Mac mini",
        //         "value_caption_pairs" => $serverPairs,
        //         "width" => 300
        //     )
        // );

        // $controls[] = array(
        //     "name" =>  "findServer",
        //     "title" => null,
        //     "kind" => "button",
        //     "specific_def" => array (
        //         "caption" => "Find Plex Servers",
        //         "width" =>  300,
        //         "push_action" => array (
        //             GuiAction::handler_string_id =>PLUGIN_HANDLE_USER_INPUT_ACTION_ID,
        //             GuiAction::params => array(
        //                 "media_url"=>"findServer:plexSetup"
        //             )
        //         )
        //     )
        // );


        $availableTemplates = array(
            PluginControlsFolderView::initial_sel_ndx => -1,
            PluginControlsFolderView::params => array(),
            PluginControlsFolderView::defs => $controls
        );
        $a = array(
            PluginFolderView::view_kind                             =>  PLUGIN_FOLDER_VIEW_CONTROLS,
            PluginFolderView::data                                  => $availableTemplates
        );

        // var_dump($a);
        return $a;
    }


    public function findServer(){
        $data = Client::getInstance()->get("http://127.0.0.1:3000/findServers");
        var_dump($data);
    }



}

?>
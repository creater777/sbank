<?php
namespace sbank\requests;


class ThreeDSRequest extends InitRequest
{
    public $challenge_window_size;
    public $device_browser_accept_header;
    public $device_browser_color_depth;
    public $device_browser_ip;
    public $device_browser_java_enabled;
    public $device_browser_language;
    public $device_browser_screen_height;
    public $device_browser_screen_width;
    public $device_browser_tz;
    public $device_browser_user_agent;
    public $device_channel;
}

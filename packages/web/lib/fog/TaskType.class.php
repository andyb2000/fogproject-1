<?php
class TaskType extends FOGController {
    // Table
    public $databaseTable = 'taskTypes';
    // Name -> Database field name
    public $databaseFields = array(
        'id' => 'ttID',
        'name' => 'ttName',
        'description' => 'ttDescription',
        'icon' => 'ttIcon',
        'kernel' => 'ttKernel',
        'kernelArgs' => 'ttKernelArgs',
        'type' => 'ttType',		// fog or user
        'isAdvanced' => 'ttIsAdvanced',
        'access' => 'ttIsAccess'		// both, host or group
    );
    // Fontawesome Icon list
    public function iconlist($selected = '') {
        $selected = trim($selected);
        $icons = array(
            '500px'=>'&#xf26e;',
            'adn'=>'&#xf170;',
            'align-justify'=>'&#xf039;',
            'align-right'=>'&#xf038;',
            'ambulance'=>'&#xf0f9;',
            'android'=>'&#xf17b;',
            'angle-double-down'=>'&#xf103;',
            'angle-double-right'=>'&#xf101;',
            'angle-down'=>'&#xf107;',
            'angle-right'=>'&#xf105;',
            'apple'=>'&#xf179;',
            'area-chart'=>'&#xf1fe;',
            'arrow-circle-left'=>'&#xf0a8;',
            'arrow-circle-o-left'=>'&#xf190;',
            'arrow-circle-o-up'=>'&#xf01b;',
            'arrow-left'=>'&#xf0aa;',
            'arrow-up'=>'&#xf062;',
            'arrows-alt'=>'&#xf0b2;',
            'arrows-v'=>'&#xf07d;',
            'at'=>'&#xf1fa;',
            'backward'=>'&#xf04a;',
            'ban'=>'&#xf05e;',
            'bar-chart'=>'&#xf080;',
            'barcode'=>'&#xf02a;',
            'battery-0'=>'&#xf244;',
            'battery-2'=>'&#xf242;',
            'battery-4'=>'&#xf240;',
            'battery-full'=>'&#xf240;',
            'battery-quarter'=>'&#xf243;',
            'bed'=>'&#xf236;',
            'behance'=>'&#xf1b4;',
            'bell'=>'&#xf0f3;',
            'bell-slash'=>'&#xf1f6;',
            'bicycle'=>'&#xf206;',
            'birthday-cake'=>'&#xf1fd;',
            'bitbucket-square'=>'&#xf172;',
            'black-tie'=>'&#xf27e;',
            'bolt'=>'&#xf0e7;',
            'book'=>'&#xf02d;',
            'bookmark-o'=>'&#xf097;',
            'btc'=>'&#xf15a;',
            'building'=>'&#xf1ad;',
            'bullhorn'=>'&#xf0a1;',
            'bus'=>'&#xf207;',
            'cab'=>'&#xf1ba;',
            'calendar'=>'&#xf073;',
            'calendar-minus-o'=>'&#xf272;',
            'calendar-plus-o'=>'&#xf271;',
            'camera'=>'&#xf030;',
            'car'=>'&#xf1b9;',
            'caret-left'=>'&#xf0d9;',
            'caret-square-o-down'=>'&#xf150;',
            'caret-square-o-right'=>'&#xf152;',
            'caret-up'=>'&#xf0d8;',
            'cart-plus'=>'&#xf217;',
            'cc-amex'=>'&#xf1f3;',
            'cc-discover'=>'&#xf1f2;',
            'cc-mastercard'=>'&#xf1f1;',
            'cc-stripe'=>'&#xf1f5;',
            'certificate'=>'&#xf0a3;',
            'chain-broken'=>'&#xf127;',
            'check-circle'=>'&#xf058;',
            'check-square'=>'&#xf14a;',
            'chevron-circle-down'=>'&#xf13a;',
            'chevron-circle-right'=>'&#xf138;',
            'child'=>'&#xf1ae;',
            'circle'=>'&#xf111;',
            'circle-o-notch'=>'&#xf1ce;',
            'clipboard'=>'&#xf0ea;',
            'clone'=>'&#xf24d;',
            'cloud'=>'&#xf0c2;',
            'cloud-upload'=>'&#xf0ee;',
            'code'=>'&#xf121;',
            'codepen'=>'&#xf1cb;',
            'cog'=>'&#xf013;',
            'columns'=>'&#xf0db;',
            'comment-o'=>'&#xf0e5;',
            'commenting-o'=>'&#xf27b;',
            'comments-o'=>'&#xf0e6;',
            'compress'=>'&#xf066;',
            'contao'=>'&#xf26d;',
            'copywrite'=>'&#xf1f9;',
            'credit-card'=>'&#xf09d;',
            'crosshairs'=>'&#xf05b;',
            'cube'=>'&#xf1b2;',
            'cut'=>'&#xf0c4;',
            'dashboard'=>'&#xf0e4;',
            'database'=>'&#xf1c0;',
            'delicious'=>'&#xf1a5;',
            'deviantart'=>'&#xf1bd;',
            'digg'=>'&#xf1a6;',
            'dot-circle-o'=>'&#xf192;',
            'dribbble'=>'&#xf17d;',
            'drupal'=>'&#xf1a9;',
            'eject'=>'&#xf052;',
            'ellipsis-v'=>'&#xf142;',
            'envelope'=>'&#xf0e0;',
            'envelope-square'=>'&#xf199;',
            'eur'=>'&#xf153;',
            'exchange'=>'&#xf0ec;',
            'exclamation-circle'=>'&#xf06a;',
            'expand'=>'&#xf065;',
            'external-link'=>'&#xf08e;',
            'eye'=>'&#xf06e;',
            'eyedropper'=>'&#xf1fb;',
            'facebook-f'=>'&#xf09a;',
            'facebook-square'=>'&#xf082;',
            'fast-forward'=>'&#xf050;',
            'feed'=>'&#xf09e;',
            'fighter-jet'=>'&#xf0fb;',
            'file-archive-o'=>'&#xf1c6;',
            'file-code-o'=>'&#xf1c9;',
            'file-image-o'=>'&#xf1c5;',
            'file-o'=>'&#xf016;',
            'file-photo-o'=>'&#xf1c5;',
            'file-powerpoint-o'=>'&#xf1c4;',
            'file-text'=>'&#xf15c;',
            'file-video-o'=>'&#xf1c8;',
            'file-zip-o'=>'&#xf1c6;',
            'film'=>'&#xf008;',
            'fire'=>'&#xf06d;',
            'firefox'=>'&#xf269;',
            'flag-checkered'=>'&#xf11e;',
            'flash'=>'&#xf0e7;',
            'flickr'=>'&#xf16e;',
            'folder'=>'&#xf07b;',
            'folder-open'=>'&#xf07c;',
            'font'=>'&#xf031;',
            'forumbee'=>'&#xf211;',
            'foursquare'=>'&#xf180;',
            'futbol-o'=>'&#xf1e3;',
            'gavel'=>'&#xf0e3;',
            'ge'=>'&#xf1d1;',
            'gears'=>'&#xf085;',
            'get-pocket'=>'&#xf265;',
            'gg-circle'=>'&#xf261;',
            'git'=>'&#xf1d3;',
            'github'=>'&#xf09b;',
            'github-square'=>'&#xf092;',
            'glass'=>'&#xf000;',
            'google'=>'&#xf1a0;',
            'google-plus-square'=>'&#xf0d4;',
            'graduation-cap'=>'&#xf19d;',
            'group'=>'&#xf0c0;',
            'hacker-news'=>'&#xf1d4;',
            'hand-lizard-o'=>'&#xf258;',
            'hand-o-left'=>'&#xf0a5;',
            'hand-o-up'=>'&#xf0a6;',
            'hand-peace-o'=>'&#xf25b;',
            'hand-rock-o'=>'&#xf255;',
            'hand-spock-o'=>'&#xf259;',
            'hdd-o'=>'&#xf0a0;',
            'headphones'=>'&#xf025;',
            'heart-o'=>'&#xf08a;',
            'history'=>'&#xf1da;',
            'hospital-o'=>'&#xf0f8;',
            'hourglass'=>'&#xf254;',
            'hourglass-2'=>'&#xf252;',
            'hourglass-end'=>'&#xf253;',
            'hourglass-o'=>'&#xf250;',
            'houzz'=>'&#xf27c;',
            'i-cursor'=>'&#xf246;',
            'image'=>'&#xf03e;',
            'indent'=>'&#xf03c;',
            'info'=>'&#xf129;',
            'inr'=>'&#xf156;',
            'institution'=>'&#xf19c;',
            'intersex'=>'&#xf224;',
            'italic'=>'&#xf033;',
            'jpy'=>'&#xf157;',
            'key'=>'&#xf084;',
            'krw'=>'&#xf159;',
            'laptop'=>'&#xf109;',
            'lastfm-square'=>'&#xf203;',
            'leanpub'=>'&#xf212;',
            'lemon-o'=>'&#xf094;',
            'level-up'=>'&#xf148;',
            'life-buoy'=>'&#xf1cd;',
            'life-saver'=>'&#xf1cd;',
            'line-chart'=>'&#xf201;',
            'linkedin'=>'&#xf0e1;',
            'linux'=>'&#xf17c;',
            'list-alt'=>'&#xf022;',
            'list-ul'=>'&#xf0ca;',
            'lock'=>'&#xf023;',
            'long-arrow-left'=>'&#xf177;',
            'long-arrow-up'=>'&#xf176;',
            'magnet'=>'&#xf076;',
            'mail-reply'=>'&#xf112;',
            'male'=>'&#xf183;',
            'map-marker'=>'&#xf041;',
            'map-pin'=>'&#xf276;',
            'mars'=>'&#xf222;',
            'mars-stroke'=>'&#xf229;',
            'mars-stroke-v'=>'&#xf22a;',
            'meanpath'=>'&#xf20c;',
            'medkit'=>'&#xf0fa;',
            'mercury'=>'&#xf223;',
            'microphone-slash'=>'&#xf131;',
            'minus-circle'=>'&#xf056;',
            'minus-circle-o'=>'&#xf147;',
            'mobile-phone'=>'&#xf10b;',
            'moon-o'=>'&#xf186;',
            'motorcycle'=>'&#xf21c;',
            'music'=>'&#xf001;',
            'neuter'=>'&#xf22c;',
            'object-group'=>'&#xf247;',
            'odnoklassniki'=>'&#xf263;',
            'opencart'=>'&#xf23d;',
            'opera'=>'&#xf26a;',
            'outdent'=>'&#xf03b;',
            'paint-brush'=>'&#xf1fc;',
            'paper-plain-o'=>'&#xf1d9;',
            'paragraph'=>'&#xf1dd;',
            'pause'=>'&#xf04c;',
            'paypal'=>'&#xf1ed;',
            'pencil-square'=>'&#xf14b;',
            'phone'=>'&#xf095;',
            'photo'=>'&#xf03e;',
            'pie-chart'=>'&#xf200;',
            'pied-piper-alt'=>'&#xf1a8;',
            'pinterest-p'=>'&#xf231;',
            'plane'=>'&#xf072;',
            'play-circle'=>'&#xf144;',
            'plug'=>'&#xf1e6;',
            'plus-circle'=>'&#xf055;',
            'plus-square-o'=>'&#xf196;',
            'print'=>'&#xf02f;',
            'qq'=>'&#xf1d6;',
            'question'=>'&#xf128;',
            'quote-left'=>'&#xf10d;',
            'ra'=>'&#xf1d0;',
            'rebel'=>'&#xf1d0;',
            'reddit'=>'&#xf1a1;',
            'refresh'=>'&#xf021;',
            'remove'=>'&#xf00d;',
            'reorder'=>'&#xf0c9;',
            'reply'=>'&#xf112;',
            'retweet'=>'&#xf079;',
            'road'=>'&#xf018;',
            'rotate-left'=>'&#xf0e2;',
            'rouble'=>'&#xf158;',
            'rss-square'=>'&#xf143;',
            'ruble'=>'&#xf158;',
            'safari'=>'&#xf267;',
            'scissors'=>'&#xf0c4;',
            'search-minus'=>'&#xf010;',
            'sellsy'=>'&#xf213;',
            'send-o'=>'&#xf1d9;',
            'share'=>'&#xf064;',
            'share-alt-square'=>'&#xf1e1;',
            'share-square-o'=>'&#xf045;',
            'sheqel'=>'&#xf20b;',
            'ship'=>'&#xf21a;',
            'shopping-cart'=>'&#xf07a;',
            'sign-out'=>'&#xf08b;',
            'simplybuilt'=>'&#xf215;',
            'skyatlas'=>'&#xf216;',
            'slack'=>'&#xf198;',
            'slideshare'=>'&#xf1e7;',
            'soccer-ball-o'=>'&#xf1e3;',
            'sort-alpha-asc'=>'&#xf15d;',
            'sort-amount-asc'=>'&#xf160;',
            'sort-asc'=>'&#xf0de;',
            'sort-down'=>'&#xf0dd;',
            'sort-numeric-desc'=>'&#xf163;',
            'soundcloud'=>'&#xf1be;',
            'spinner'=>'&#xf110;',
            'spotify'=>'&#xf1bc;',
            'square-o'=>'&#xf096;',
            'stack-overflow'=>'&#xf16c;',
            'star-half'=>'&#xf089;',
            'star-half-full'=>'&#xf123;',
            'star-o'=>'&#xf006;',
            'steam-square'=>'&#xf1b7;',
            'step-forward'=>'&#xf051;',
            'sticky-note'=>'&#xf249;',
            'stop'=>'&#xf04d;',
            'strikethrough'=>'&#xf0cc;',
            'stumbleupon-circle'=>'&#xf1a3;',
            'subway'=>'&#xf239;',
            'sun-o'=>'&#xf185;',
            'support'=>'&#xf1cd;',
            'tablet'=>'&#xf10a;',
            'tag'=>'&#xf02d;',
            'tasks'=>'&#xf0ae;',
            'television'=>'&#xf26c;',
            'terminal'=>'&#xf120;',
            'text-width'=>'&#xf035;',
            'th-large'=>'&#xf009;',
            'thumb-tack'=>'&#xf08d;',
            'thumbs-o-down'=>'&#xf088;',
            'thumbs-up'=>'&#xf164;',
            'times'=>'&#xf00d;',
            'times-circle-o'=>'&#xf05c;',
            'toggle-down'=>'&#xf150;',
            'toggle-off'=>'&#xf204;',
            'toggle-right'=>'&#xf152;',
            'trademark'=>'&#xf25c;',
            'transgender'=>'&#xf224;',
            'trash'=>'&#xf1f8;',
            'tree'=>'&#xf1bb;',
            'tripadvisor'=>'&#xf262;',
            'truck'=>'&#xf0d1;',
            'tty'=>'&#xf1e4;',
            'tumblr-square'=>'&#xf174;',
            'tv'=>'&#xf26c;',
            'twitter'=>'&#xf099;',
            'umbrella'=>'&#xf0e9;',
            'undo'=>'&#xf0e2;',
            'unlink'=>'&#xf127;',
            'unlock-alt'=>'&#xf13e;',
            'upload'=>'&#xf093;',
            'user'=>'&#xf007;',
            'user-plus'=>'&#xf234;',
            'user-times'=>'&#xf235;',
            'venus'=>'&#xf221;',
            'venus-mars'=>'&#xf228;',
            'video-camera'=>'&#xf03d;',
            'vimeo-square'=>'&#xf194;',
            'vk'=>'&#xf189;',
            'volume-off'=>'&#xf026;',
            'warning'=>'&#xf071;',
            'welbo'=>'&#xf18a;',
            'whatsapp'=>'&#xf232;',
            'wifi'=>'&#xf1eb;',
            'windows'=>'&#xf17a;',
            'wordpress'=>'&#xf19a;',
            'xing'=>'&#xf168;',
            'y-combinator'=>'&#xf23b;',
            'yahoo'=>'&#xf19e;',
            'yc-square'=>'&#xf1d4;',
            'yen'=>'&#xf157;',
            'youtube-play'=>'&#xf16a;',
            'adjust'=>'&#xf042;',
            'align-center'=>'&#xf037;',
            'align-left'=>'&#xf038;',
            'amazon'=>'&#xf270;',
            'anchor'=>'&#xf13d;',
            'angellist'=>'&#xf209;',
            'angle-double-left'=>'&#xf100;',
            'angle-double-up'=>'&#xf102;',
            'angle-left'=>'&#xf104;',
            'angle-up'=>'&#xf106;',
            'archive'=>'&#xf187;',
            'arrow-circle-down'=>'&#xf0ab;',
            'arrow-circle-o-down'=>'&#xf01a;',
            'arrow-circle-o-right'=>'&#xf18e;',
            'arrow-circle-right'=>'&#xf0a9;',
            'arrow-down'=>'&#xf063;',
            'arrow-right'=>'&#xf0a9;',
            'arrows'=>'&#xf047;',
            'arrows-h'=>'&#xf07e;',
            'asterisk'=>'&#xf069;',
            'automobile'=>'&#xf1b9;',
            'balance-scale'=>'&#xf24e;',
            'bank'=>'&#xf19c;',
            'bar-chart-o'=>'&#xf080;',
            'bars'=>'&#xf0c9;',
            'battery-1'=>'&#xf243;',
            'battery-3'=>'&#xf241;',
            'battery-empty'=>'&#xf244;',
            'battery-half'=>'&#xf242;',
            'battery-three-quarters'=>'&#xf241;',
            'beer'=>'&#xf0fc;',
            'behance-square'=>'&#xf1b5;',
            'bell-o'=>'&#xf0a2;',
            'bell-slash-o'=>'&#xf1f7;',
            'binoculars'=>'&#xf1e5;',
            'bitbucket'=>'&#xf171;',
            'bitcoin'=>'&#xf15a;',
            'bold'=>'&#xf032;',
            'bomb'=>'&#xf1e2;',
            'bookmark'=>'&#xf02e;',
            'briefcase'=>'&#xf0b1;',
            'bug'=>'&#xf188;',
            'building-o'=>'&#xf0f7;',
            'bullseye'=>'&#xf140;',
            'buysellads'=>'&#xf20d;',
            'calculator'=>'&#xf1ec;',
            'calendar-check-o'=>'&#xf274;',
            'calendar-o'=>'&#xf133;',
            'calendar-times-o'=>'&#xf273;',
            'camera-retro'=>'&#xf083;',
            'caret-down'=>'&#xf0d7;',
            'caret-right'=>'&#xf0da;',
            'caret-square-o-left'=>'&#xf191;',
            'caret-square-o-up'=>'&#xf151;',
            'cart-arrow-down'=>'&#xf218;',
            'cc'=>'&#xf20a;',
            'cc-diners-club'=>'&#xf24c;',
            'cc-jcb'=>'&#xf24b;',
            'cc-paypal'=>'&#xf1f4;',
            'cc-visa'=>'&#xf1f0;',
            'chain'=>'&#xf0c1;',
            'check'=>'&#xf00c;',
            'check-circle-o'=>'&#xf05d;',
            'check-square-o'=>'&#xf046;',
            'chevron-circle-left'=>'&#xf137;',
            'chevron-circle-up'=>'&#xf139;',
            'chevron-left'=>'&#xf053;',
            'chevron-up'=>'&#xf077;',
            'chrome'=>'&#xf268;',
            'circle-o'=>'&#xf10c;',
            'circle-thin'=>'&#xf1db;',
            'clock-o'=>'&#xf017;',
            'close'=>'&#xf00d;',
            'cloud-download'=>'&#xf0ed;',
            'cny'=>'&#xf157;',
            'code-fork'=>'&#xf126;',
            'coffee'=>'&#xf0f4;',
            'cogs'=>'&#xf085;',
            'comment'=>'&#xf075;',
            'commenting'=>'&#xf27a;',
            'comments'=>'&#xf086;',
            'compass'=>'&#xf14e;',
            'connectdevelop'=>'&#xf20e;',
            'copy'=>'&#xf0c5;',
            'creative-commons'=>'&#xf25e;',
            'crop'=>'&#xf125;',
            'css3'=>'&#xf13c;',
            'cubes'=>'&#xf1b3;',
            'cutlery'=>'&#xf0f5;',
            'dashcube'=>'&#xf210;',
            'dedent'=>'&#xf03b;',
            'desktop'=>'&#xf108;',
            'diamond'=>'&#xf219;',
            'dollar'=>'&#xf155;',
            'download'=>'&#xf019;',
            'dropbox'=>'&#xf16b;',
            'edit'=>'&#xf044;',
            'ellipsis-h'=>'&#xf141;',
            'empire'=>'&#xfxf1d1;',
            'envelope-o'=>'&#xf003;',
            'eraser'=>'&#xf12d;',
            'euro'=>'&#xf153;',
            'exclamation'=>'&#xf12a;',
            'exclamation-triangle'=>'&#xf071;',
            'expeditedssl'=>'&#xf23e;',
            'external-link-square'=>'&#xf14c;',
            'eye-slash'=>'&#xf070;',
            'facebook'=>'&#xf09a;',
            'facebook-official'=>'&#xf230;',
            'fast-backward'=>'&#xf049;',
            'fax'=>'&#xf1ac;',
            'female'=>'&#xf182;',
            'file'=>'&#xf15b;',
            'file-audio-o'=>'&#xf1c7;',
            'file-excel-o'=>'&#xf1c3;',
            'file-movie-o'=>'&#xf1c8;',
            'file-pdf-o'=>'&#xf1c1;',
            'file-picture-o'=>'&#xf1c5;',
            'file-sound-o'=>'&#xf1c7;',
            'file-text-o'=>'&#xf0f6;',
            'file-word-o'=>'&#xf1c2;',
            'files-o'=>'&#xf0c5;',
            'filter'=>'&#xf0b0;',
            'fire-extinguisher'=>'&#xf134;',
            'flag'=>'&#xf024;',
            'flag-o'=>'&#xf11d;',
            'flask'=>'&#xf0c3;',
            'floppy-o'=>'&#xf0c7;',
            'folder-o'=>'&#xf114;',
            'folder-open-o'=>'&#xf115;',
            'fonticons'=>'&#xf280;',
            'forward'=>'&#xf04e;',
            'frown-o'=>'&#xf119;',
            'gamepad'=>'&#xf11b;',
            'gbp'=>'&#xf154;',
            'gear'=>'&#xf013;',
            'genderless'=>'&#xf22d;',
            'gg'=>'&#xf260;',
            'gift'=>'&#xf06b;',
            'git-square'=>'&#xf1d2;',
            'github-alt'=>'&#xf113;',
            'gittip'=>'&#xf184;',
            'globe'=>'&#xf0ac;',
            'google-plus'=>'&#xf0d5;',
            'google-wallet'=>'&#xf1ee;',
            'gratipay'=>'&#xf184;',
            'h-square'=>'&#xf0fd;',
            'hand-grab-o'=>'&#xf255;',
            'hand-o-down'=>'&#xf0a7;',
            'hand-o-right'=>'&#xf0a4;',
            'hand-paper-o'=>'&#xf256;',
            'hand-pointer-o'=>'&#xf25a;',
            'hand-scissors-o'=>'&#xf257;',
            'hand-stop-o'=>'&#xf256;',
            'header'=>'&#xf1dc;',
            'heart'=>'&#xf004;',
            'heartbeat'=>'&#xf21e;',
            'home'=>'&#xf015;',
            'hotel'=>'&#xf236;',
            'hourglass-1'=>'&#xf251;',
            'hourglass-3'=>'&#xf253;',
            'hourglass-half'=>'&#xf252;',
            'hourglass-start'=>'&#xf251;',
            'html5'=>'&#xf13b;',
            'ils'=>'&#xf20b;',
            'inbox'=>'&#xf01c;',
            'industry'=>'&#xf275;',
            'info-circle'=>'&#xf05a;',
            'instagram'=>'&#xf16d;',
            'internet-explorer'=>'&#xf26b;',
            'ioxhost'=>'&#xf208;',
            'joomla'=>'&#xf1aa;',
            'jsfiddle'=>'&#xf1cc;',
            'keyboard-o'=>'&#xf11c;',
            'language'=>'&#xf1ab;',
            'lastfm'=>'&#xf202;',
            'leaf'=>'&#xf06c;',
            'legal'=>'&#xf0e3;',
            'level-down'=>'&#xf149;',
            'life-bouy'=>'&#xf1cd;',
            'life-ring'=>'&#xfxf1cd;',
            'lightbulb-o'=>'&#xfxf0eb;',
            'link'=>'&#xf0c1;',
            'linkedin-square'=>'&#xf08c;',
            'list'=>'&#xf03a;',
            'list-ol'=>'&#xf0cb;',
            'location-arrow'=>'&#xf124;',
            'long-arrow-down'=>'&#xf175;',
            'long-arrow-right'=>'&#xf178;',
            'magic'=>'&#xf0d0;',
            'mail-forward'=>'&#xf064;',
            'mail-reply-all'=>'&#xf122;',
            'map'=>'&#xf279;',
            'map-o'=>'&#xf278;',
            'map-signs'=>'&#xf277;',
            'mars-double'=>'&#xf227;',
            'mars-stroke-h'=>'&#xf22b;',
            'maxcdn'=>'&#xf136;',
            'medium'=>'&#xf23a;',
            'meh-o'=>'&#xf111a;',
            'microphone'=>'&#xf130;',
            'minus'=>'&#xf068;',
            'minus-square'=>'&#xf146;',
            'mobile'=>'&#xf10b;',
            'money'=>'&#xf0d6;',
            'mortar-board'=>'&#xf19d;',
            'mouse-pointer'=>'&#xf245;',
            'navicon'=>'&#xf0c9;',
            'newspaper-o'=>'&#xf1ea;',
            'object-ungroup'=>'&#xf248;',
            'odnoklassniki-square'=>'&#xf264;',
            'openid'=>'&#xf19b;',
            'optin-monster'=>'&#xf23c;',
            'pagelines'=>'&#xf18c;',
            'paper-plane'=>'&#xf1d8;',
            'paperclip'=>'&#xf0c6;',
            'paste'=>'&#xf0ea;',
            'paw'=>'&#xf1b0;',
            'pencil'=>'&#xf040;',
            'pencil-square-o'=>'&#xf044;',
            'phone-square'=>'&#xf098;',
            'picture-o'=>'&#xf03e;',
            'pied-piper'=>'&#xf1a7;',
            'pinterest'=>'&#xf0d2;',
            'pinterest-square'=>'&#xf0d3;',
            'play'=>'&#xf04b;',
            'play-cirle-o'=>'&#xf01d;',
            'plus'=>'&#xf067;',
            'plus-square'=>'&#xf0fe;',
            'power-off'=>'&#xf011;',
            'puzzle-piece'=>'&#xf12e;',
            'qrcode'=>'&#xf029;',
            'question-circle'=>'&#xf059;',
            'quote-right'=>'&#xf10e;',
            'random'=>'&#xf074;',
            'recycle'=>'&#xf1b8;',
            'reddit-square'=>'&#xf1a2;',
            'registered'=>'&#xf25d;',
            'renren'=>'&#xf18b;',
            'repeat'=>'&#xf01e;',
            'reply-all'=>'&#xf122;',
            'rmb'=>'&#xf157;',
            'rocket'=>'&#xf135;',
            'rotate-right'=>'&#xf01e;',
            'rss'=>'&#xf09e;',
            'rub'=>'&#xf158;',
            'rupee'=>'&#xf156;',
            'save'=>'&#xf0c7;',
            'search'=>'&#xf002;',
            'search-plus'=>'&#xf00e;',
            'send'=>'&#xf1d8;',
            'server'=>'&#xf233;',
            'share-alt'=>'&#xf1e0;',
            'share-square'=>'&#xf14d;',
            'shekel'=>'&#xf20b;',
            'shield'=>'&#xf132;',
            'shirtsinbulk'=>'&#xf214;',
            'sign-in'=>'&#xf090;',
            'signal'=>'&#xf012;',
            'sitemap'=>'&#xf0e8;',
            'skype'=>'&#xf17e;',
            'sliders'=>'&#xf1de;',
            'smile-o'=>'&#xf118;',
            'sort'=>'&#xf0dc;',
            'sort-alpha-desc'=>'&#xf15e;',
            'sort-amount-desc'=>'&#xf161;',
            'sort-desc'=>'&#xf0dd;',
            'sort-numeric-asc'=>'&#xf162;',
            'sort-up'=>'&#xf0de;',
            'space-shuttle'=>'&#xf197;',
            'spoon'=>'&#xf1b1;',
            'square'=>'&#xf0c8;',
            'stack-exchange'=>'&#xf18d;',
            'star'=>'&#xf005;',
            'star-half-empty'=>'&#xf123;',
            'star-half-o'=>'&#xf123;',
            'steam'=>'&#xf1b6;',
            'step-backward'=>'&#xf048;',
            'stethoscope'=>'&#xf0f1;',
            'sticky-note-o'=>'&#xf24a;',
            'street-view'=>'&#xf21d;',
            'stumbleupon'=>'&#xf1a4;',
            'subscript'=>'&#xf12c;',
            'suitcase'=>'&#xf0f2;',
            'superscript'=>'&#xf12b;',
            'table'=>'&#xf0ce;',
            'tachometer'=>'&#xf0e4;',
            'tags'=>'&#xf02c;',
            'taxi'=>'&#xf1ba;',
            'tencent-weibo'=>'&#xf1d5;',
            'text-height'=>'&#xf034;',
            'th'=>'&#xf00a;',
            'th-list'=>'&#xf00b;',
            'thumbs-down'=>'&#xf165;',
            'thumbs-o-up'=>'&#xf087;',
            'ticket'=>'&#xf145;',
            'times-circle'=>'&#xf057;',
            'tint'=>'&#xf043;',
            'toggle-left'=>'&#xf191;',
            'toggle-on'=>'&#xf205;',
            'toggle-up'=>'&#xf151;',
            'train'=>'&#xf238;',
            'transgender-alt'=>'&#xf225;',
            'trash-o'=>'&#xf014;',
            'trello'=>'&#xf181;',
            'trophy'=>'&#xf091;',
            'try'=>'&#xf195;',
            'tumblr'=>'&#xf173;',
            'turkish-lira'=>'&#xf195;',
            'twitch'=>'&#xf1e8;',
            'twitter-square'=>'&#xf081;',
            'underline'=>'&#xf0cd;',
            'university'=>'&#xf19c;',
            'unlock'=>'&#xf09c;',
            'unsorted'=>'&#xf0dc;',
            'usd'=>'&#xf155;',
            'user-md'=>'&#xf0f0;',
            'user-secret'=>'&#xf21b;',
            'users'=>'&#xf0c0;',
            'venus-double'=>'&#xf226;',
            'viacoin'=>'&#xf237;',
            'vimeo'=>'&#xf27d;',
            'vine'=>'&#xf1ca;',
            'volume-down'=>'&#xf027;',
            'volume-up'=>'&#xf028;',
            'wechat'=>'&#xf1d7;',
            'weixin'=>'&#xf1d7;',
            'wheelchair'=>'&#xf193;',
            'wikipedia-w'=>'&#xf266;',
            'won'=>'&#xf159;',
            'wrench'=>'&#xf0ad;',
            'xing-square'=>'&#xf169;',
            'y-combinator-square'=>'&#xf1d4;',
            'yc'=>'&#xf23b;',
            'yelp'=>'&#xf1e9;',
            'youtube'=>'&#xf167;',
            'youtube-square'=>'&#xf166;',
        );
        ksort($icons);
        $selectlist = '<select name="icon" class="form-control" style="font-family:\'FontAwesome\', Arial; width: 200px;">';
        foreach ($icons AS $name => &$unicode) $selectlist .= sprintf('<option value="%s"%s> %s %s</option>',$name,$selected == $name ? ' selected' : '',$unicode,$name);
        return $selectlist.'</select>';
    }
    // Custom functions
    public function isUpload() {
        return preg_match('#type=(2|16|up)#i', $this->get(kernelArgs));
    }
    public function isDownload() {
        return preg_match('#type=(1|8|15|17|down)#i', $this->get(kernelArgs));
    }
    public function isMulticast() {
        return preg_match('#(type=8|mc=yes)#i', $this->get(kernelArgs));
    }
    public function isDebug() {
        return (preg_match('#mode=debug#i', $this->get(kernelArgs)) || preg_match('#mode=onlydebug#i', $this->get(kernelArgs)));
    }
}

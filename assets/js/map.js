var map;
var center = new google.maps.LatLng(33.589972, 130.376483);
var MY_MAPTYPE_ID = 'oiginal_map';
function initialize() {
    var featureOpts = [{
        "stylers": [
        {
          "hue": "#000"
        },
        {
            "gamma": 1.8
        },
        {
            "saturation": -100
        }
        ],
        "elementType": "all",
        "featureType": "all"
    }]   
    var mapOptions = {
        zoom: 13,
        center: center,
        mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
        },
        mapTypeId: MY_MAPTYPE_ID,
        scrollwheel: true 
    };
    map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

    //インフォウィンドウ　ブルックリン
    var contentString_broolkyn =  '<p style="width:150px;">BROOKLYN<br>〒814-0002<br>福岡市早良区西新5-4-20<br>tel.092-843-8186</p>'; 
    var infowindow_broolkyn = new google.maps.InfoWindow({
        content: contentString_broolkyn
    });

    //インフォウィンドウ　ロータス
    var contentString_lotus =  '<p style="width:150px;">LOTUS<br>〒810-0021<br>福岡県福岡市中央区今泉1-19-10天神ソ二ック101<br>tel.092-751-0606</p>'; 
    var infowindow_lotus = new google.maps.InfoWindow({
        content: contentString_lotus
    });

    //アイコン ブルックリ
    var marker_broolkyn = new google.maps.Marker({
        position: new google.maps.LatLng(33.581618, 130.356924),  //マーカ位置
        map: map,
        icon: new google.maps.MarkerImage(
            '/assets/img/shop-info/icon_map-brooklyn.png',
            new google.maps.Size(173,77),/*アイコンのサイズ*/
            new google.maps.Point(0,0),/*アイコンの位置*/
            new google.maps.Point(60,67)/*アイコンの位置*/
        ),
        title: 'ブルックリン',
        clickable: true,  //クリック有効無効
        draggable: false  //アイコンの移動の有効無効
        });

    //アイコン　ロータス
    var marker_lotus = new google.maps.Marker({
        position: new google.maps.LatLng(33.585882, 130.397257),  //マーカ位置
        map: map,
        icon: new google.maps.MarkerImage(
            '/assets/img/shop-info/icon_map-lotus.png',
            new google.maps.Size(173,77),/*アイコンのサイズ*/
            new google.maps.Point(0,0),/*アイコンの位置*/
            new google.maps.Point(100,67)/*アイコンの位置*/
        ),
        title: 'ロータス',
        clickable: true,  //クリック有効無効
        draggable: false  //アイコンの移動の有効無効
    });

    var styledMapOptions = { name: 'oiginal map' };
    var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);
    map.mapTypes.set(MY_MAPTYPE_ID, customMapType);

    //インフォウィンドウ呼び出し　ブッルクリン
    google.maps.event.addListener(marker_broolkyn, 'click', function() {
        infowindow_broolkyn.open(map,marker_broolkyn);
    });

    //インフォウィンドウ呼び出し　ロータス
    google.maps.event.addListener(marker_lotus, 'click', function() {
        infowindow_lotus.open(map,marker_lotus);
    });
}
google.maps.event.addDomListener(window, 'load', initialize);
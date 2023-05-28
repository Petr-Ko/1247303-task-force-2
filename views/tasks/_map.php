<?php

use yii\helpers\Html;

/** @var  $model */
?>

<script src="//api-maps.yandex.ru/2.1/?apikey=<?= Yii::$app->params['apiKeyGeocode'] ?>&lang=ru_RU"></script>

<div id="map" data-name="<?= Html::encode($model['name']) ?>" data-lng="<?= $model['longitude'] ?>" data-lat="<?= $model['latitude']?>" style="width:725px; height:346px" ></div>

<script>
    let el = document.getElementById('map');
    let lat = el.dataset.lat,
        lng = el.dataset.lng,
        name = el.dataset.name;

    ymaps.ready(init);
    function init(){

        let myMap = new ymaps.Map("map", {

            center: [lat, lng],
            zoom: 15

        });
        let myPlacemark = new ymaps.Placemark([lat, lng], {
            iconContent: name
        }, {

            preset: 'islands#redDotIconWithCaption'
        });

        myMap.geoObjects.add(myPlacemark);
    }
</script>

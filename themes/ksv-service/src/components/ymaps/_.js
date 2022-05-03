export default function initMap($map) {  
  const createMap = () => {
    const [latitude, longitude] = $map.dataset.coordinates.split(',');

    const myMap = new ymaps.Map($map.id, {
      center: [latitude, longitude],
      zoom: $map.dataset.zoom,
      type: "yandex#map",
      traffic: { shown: false}
    });

    const feature = {
      geometry: {
        type: "Point",
        coordinates: [latitude, longitude]
      },
      properties: {
        name: $map.dataset.name,
        description: "",
        iconContent:"",
        iconCaption: $map.dataset.iconCaption
      },
    };

    const options = {
      preset: "islands#orangeCircleDotIcon"
    };

    const myGeoObject = new ymaps.GeoObject(feature, options);

    myMap.geoObjects.add(myGeoObject);
  }

  const loadScript = (url, callback) => {
    if (document.getElementById("ymaps-api"))
      return

    const script = document.createElement("script");

    if (script.readyState){  
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" ||
                script.readyState == "complete"){
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {
        script.onload = function(){
            callback();
        };
    }

    script.src = url;
    script.id = "ymaps-api";
    document.getElementsByTagName("head")[0].appendChild(script);
  }

  const init = () => {
    loadScript("https://api-maps.yandex.ru/2.1/?apikey=c0ebd0d1-6836-48e6-831b-58bd7cb0548f&lang=ru_RU", () => {
      ymaps.load(createMap);
    })
  }

  init();
}

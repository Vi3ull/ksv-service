export default function initMap($map) {  
  const [latitude, longitude] = $map.dataset.coordinates.split(',');

  const init = () => {
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

  ymaps.ready(init);
}

import React, { Fragment, useEffect, useReducer } from 'react';
import GoogleMapReact from 'google-map-react';
import { API_PUBLIC_MAP_KEY } from '../constant';

const Marker = () => {
  const markerStyle = {
    height: 40,
    width: 25,
    background: 'no-repeat url("/static/images/icon-marker@2x.png")',
    zIndex: 10,
    position: 'absolute',
    transform: 'translate(-25%, -75%)',
  };

  return (
    <Fragment>
      <div style={markerStyle} />
    </Fragment>
  );
};

export default function Map(props) {
  return (
    <GoogleMapReact
      bootstrapURLKeys={{ key: API_PUBLIC_MAP_KEY }}
      zoom={12}
      center={{
        lat: props.lat,
        lng: props.lng,
      }}
      options={{
        gestureHandling: 'none',
        disableDefaultUI: true,
        zoomControl: false,
      }}
    >
      <Marker key="author" lat={props.lat} lng={props.lng} />
    </GoogleMapReact>
  );
}

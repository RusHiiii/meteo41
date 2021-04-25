import React, { Fragment, useEffect, useReducer } from 'react';
import Footer from '../Footer';
import News from '../News';
import Informations from '../Informations';

export default function PageLayout(props) {
  return (
    <div className="site-content">
      {props.children}

      <News />

      <Informations />

      <Footer />
    </div>
  );
}

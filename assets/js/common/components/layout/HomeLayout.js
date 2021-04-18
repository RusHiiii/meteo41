import React, { Fragment, useEffect, useReducer } from 'react';
import { Link } from 'react-router-dom';
import Menu from '../Menu';
import Footer from '../Footer';
import News from '../News';
import Informations from '../Informations';

export default function HomeLayout(props) {
  return (
    <div className="site-content">
      <Menu {...props} />

      {props.children}

      <News />

      <Informations />

      <Footer />
    </div>
  );
}

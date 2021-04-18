import React, { Fragment, useEffect, useReducer } from 'react';
import { Link } from 'react-router-dom';
import Menu from '../Menu';
import Footer from '../Footer';
import News from '../News';
import Informations from '../Informations';

export default function PageLayout(props) {
  return (
    <div className="site-content">
      <Menu {...props} />

      <main className="main-content">{props.children}</main>

      <News />

      <Informations />

      <Footer />
    </div>
  );
}

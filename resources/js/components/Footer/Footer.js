import React from "react";
import { Link } from '@inertiajs/inertia-react'
//import Logo from "../../assets/images/logo/1.svg";
import { Map } from "../Map";
//import FB from "../../assets/images/icons/sm/fb.svg";
//import IG from "../../assets/images/icons/sm/ig.svg";
import Navbar from "../Navbar/Navbar";
import "./Footer.css";

import { usePage } from '@inertiajs/inertia-react'



const Footer = () => {
    const { url, component } = usePage();
    const { pathname } = usePage().props;
  return (
    <div
      className="footer"
      style={{ background: pathname === "/" ? "#fff" : "#ECF0F7" }}
    >
      <div className="wrapper flex">
        <div className="part">
          <div className="flex" style={{ justifyContent: "flex-start" }}>
            <Link href="/" className="logo">
              <img src="/assets/images/logo/1.svg" alt="" />
            </Link>
            <Navbar />
          </div>
          <div className="category_grid">
            <div className="column">
              <div className="bold">Bedroom furniture</div>
              <Link href="/">Bed</Link>
              <Link href="/">Wardrobes</Link>
              <Link href="/">Pump</Link>
              <Link href="/">Commode</Link>
              <Link href="/">Mirrors</Link>
            </div>
            <div className="column">
              <div className="bold">Living room furniture</div>
              <Link href="/">Wall unit</Link>
              <Link href="/">Console</Link>
              <Link href="/">Coffee table</Link>
              <Link href="/">Accessories</Link>
            </div>
            <div className="column">
              <div className="bold">Upholstered furniture</div>
              <Link href="/">Corner sofa</Link>
              <Link href="/">Sofa</Link>
              <Link href="/">Puff</Link>
              <Link href="/">Armchair</Link>
            </div>
            <div className="column">
              <div className="bold">Table-chair</div>
              <Link href="/">Table</Link>
              <Link href="/">Chair</Link>
              <Link href="/">Bar chair</Link>
            </div>
          </div>
        </div>
        <div className="part">
          <h6>Social links:</h6>
          <Link href="/" className="sm flex">
            <div className="icon flex centered">
              <img src="/assets/images/icons/sm/fb.svg" alt="" />
            </div>
            <p>Facebook</p>
          </Link>
          <Link href="/" className="sm flex">
            <div className="icon flex centered">
              <img src="/assets/images/icons/sm/ig.svg" alt="" />
            </div>
            <p>Instagram</p>
          </Link>
        </div>
        <div className="part map">
          <Map />
        </div>
      </div>
    </div>
  );
};

export default Footer;

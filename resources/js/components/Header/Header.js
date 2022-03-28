import React from "react";
//import { Link, useLocation } from "react-router-dom";
import { Link } from "@inertiajs/inertia-react";
//import Logo from "../../assets/images/logo/1.svg";
import Navbar from "../Navbar/Navbar";
import "./Header.css";

import { usePage } from '@inertiajs/inertia-react'
import {Languages} from "../Languages/Languages";



const Header = () => {
    const { url, component } = usePage();
    const { pathname, currentLocale } = usePage().props;
    //console.log(usePage().props);
    let url_ = new URL(pathname);
    let pathname_ = url_.pathname;
    console.log(pathname_);
  return (
    <div
      className="header"
      style={{
        position: pathname_ === "/" + currentLocale ? "absolute" : "relative",
        background: pathname_ === "/" + currentLocale ? "transparent" : "#ECF0F7",
      }}
    >
      <div className="wrapper flex">
        <div className="flex">
          <Link href={route('client.home.index')} className="logo">
            <img src="/assets/images/logo/1.svg" alt="" />
          </Link>
          <Navbar />
        </div>

          <Languages></Languages>
      </div>
    </div>
  );
};

export default Header;

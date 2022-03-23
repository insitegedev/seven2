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
    const { pathname } = usePage().props;
  return (
    <div
      className="header"
      style={{
        position: pathname === "/" ? "absolute" : "relative",
        background: pathname === "/" ? "transparent" : "#ECF0F7",
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

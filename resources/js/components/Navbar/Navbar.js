import React from "react";
import { Link } from "@inertiajs/inertia-react";
import "./Navbar.css";

import { usePage } from '@inertiajs/inertia-react'



const Navbar = () => {
    const sharedData = usePage().props.localizations;
    const { url, component } = usePage();
    const { pathname } = usePage().props;
    //console.log(url);
  //const { pathname } = url;
  const navbar = [
    {
      name: __('client.nav_home',sharedData),
      link: route("client.home.index"),
    },
    {
      name: __('client.nav_products',sharedData),
      link: route("client.product.index"),
    },
    {
      name: __('client.nav_about_us',sharedData),
      link: route('client.about.index'),
    },
    {
      name: __('client.nav_contact',sharedData),
      link: route('client.contact.index'),
    },
  ];
  return (
    <div className="navbar">
      {navbar.map((nav, index) => {
        return (
          <Link
            className={pathname === nav.link ? "nav_link active" : "nav_link "}
            href={nav.link}
            key={index}
          >
            {nav.name}
          </Link>
        );
      })}
    </div>
  );
};

export default Navbar;

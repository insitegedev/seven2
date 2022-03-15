import React from "react";
import { Link } from "@inertiajs/inertia-react";
import "./Navbar.css";

import { usePage } from '@inertiajs/inertia-react'



const Navbar = () => {
    const { url, component } = usePage();
    const { pathname } = usePage().props;
    console.log(url);
  //const { pathname } = url;
  const navbar = [
    {
      name: "HOme",
      link: route("client.home.index"),
    },
    {
      name: "products",
      link: route("client.product.index"),
    },
    {
      name: "About us",
      link: route('client.about.index'),
    },
    {
      name: "Contact",
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

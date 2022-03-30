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
    const { pathname, categories, info } = usePage().props;
    const sharedData = usePage().props.localizations;
    //console.log(categories);

    let subcategory = function (children){
        let rows = [];
        if(children.length > 0){
            children.map(child => {
                //console.log(child)
                   rows.push(<Link href={route('client.category.show',child.slug)}>{child.title}</Link>)
            })
        }
        return rows
    }

  return (
    <div
      className="footer"
      style={{ background: pathname === "/" ? "#fff" : "#ECF0F7" }}
    >
      <div className="wrapper flex">
        <div className="part">
          <div className="flex" style={{ justifyContent: "flex-start" }}>
            <Link href={route('client.home.index')} className="logo">
              <img src="/assets/images/logo/1.svg" alt="" />
            </Link>
            <Navbar />
          </div>
          <div className="category_grid">
              {categories.map(function (category){
                  return (
                      <div className="column">
                          <div className="bold">{category.title}</div>
                          {subcategory(category.children)}
                      </div>
                  )
              })}

          </div>
        </div>
          {
              info.instagram.active == 1 || info.facebook.active ? <div className="part">
                  <h6>{__('client.footer_social_links',sharedData)}:</h6>
                  {
                      info.facebook.active == 1 ?  <a href={info.facebook.translation ? info.facebook.translation.value : null} className="sm flex">
                          <div className="icon flex centered">
                              <img src="/assets/images/icons/sm/fb.svg" alt="" />
                          </div>
                          <p>Facebook</p>
                      </a>  : ''
                  }

                  {
                      info.instagram.active == 1 ? <a href={info.instagram.translation ? info.instagram.translation.value : null} className="sm flex">
                          <div className="icon flex centered">
                              <img src="/assets/images/icons/sm/ig.svg" alt="" />
                          </div>
                          <p>Instagram</p>
                      </a> : ''
                  }

              </div> : ''
          }

        <div className="part map">
          <Map />
        </div>
      </div>
    </div>
  );
};

export default Footer;

import React, { useState, useEffect } from "react";
import { MainButton } from "../../components/MainButton/MainButton";
import HeroSlider from "./HeroSlider/HeroSlider";
import Aos from "aos";
import "aos/dist/aos.css";
import {
  ProductBox,
  ProductImage,
} from "../../components/ProductObjects/ProductObjects";
import { Link } from "@inertiajs/inertia-react";
import { shopCategories, onSaleCategories, popularProducts } from "./HomeData";
import "./Home.css";
import { usePage, Head } from "@inertiajs/inertia-react";
import Layout from "../../Layouts/Layout";

const Home = ({ page, seo }) => {

    const sharedData = usePage().props.localizations;
  return (
      <Layout seo={seo}>
    <div className="homePage">
      <HeroSlider />
      <div className="categories_home wrapper flex">
        <div>
          <h4>
            Shop <br /> by categories
          </h4>
          <MainButton link="/" white transparent text="View all categories" />
        </div>
        <div className="grid4" data-aos="zoom-in">
          {shopCategories.map((cat, i) => {
            return (
              <Link href="/" key={i}>
                <ProductImage src={cat.img} category={cat.cat} />
              </Link>
            );
          })}
        </div>
      </div>
      <div className="exhibition" data-aos="fade-up"></div>
      <div className="onsale_cats flex wrapper">
        {onSaleCategories.map((cat, i) => {
          return (
            <div className="box flex centered" key={i} data-aos="zoom-out">
              <img className="bg" src={cat.bg} alt="" />
              <div
                className="container flex centered"
                style={{ color: cat.color, border: `2px solid ${cat.color}` }}
              >
                <div className="bold">{cat.off}</div>
                <h5>{cat.cat}</h5>
                <MainButton link="/" text="Shop now" white={cat.whiteButton} />
              </div>
            </div>
          );
        })}
      </div>
      <div className="popular_products wrapper">
        <div className="head flex">
          <div className="title">{__('client.popular_products',sharedData)}</div>
          <MainButton text="View all" link="/" />
        </div>
        <div className="grid4" data-aos="fade-up">
          {popularProducts.map((item, i) => {
              let link = route("client.product.index");
            return (
              <ProductBox
                key={i}
                src={item.img}
                discount={item.off}
                category={item.cat}
                link={link}
              />
            );
          })}
        </div>
      </div>
    </div>
  </Layout>
  );
};

export default Home;

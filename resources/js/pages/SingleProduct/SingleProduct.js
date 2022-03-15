import React, { useState } from "react";
//import Arr1 from "../../assets/images/icons/arrows/2.svg";
import { MainButton } from "../../components/MainButton/MainButton";
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import "./SingleProduct.css";
import {
  ProductBox,
  ProductImage,
} from "../../components/ProductObjects/ProductObjects";
//import Img1 from "../../assets/images/products/1.png";
//import Img2 from "../../assets/images/products/2.png";
//import Img3 from "../../assets/images/products/3.png";
//import Img4 from "../../assets/images/products/4.png";

import Layout from "../../Layouts/Layout";

const SingleProduct = (seo) => {
  const [nav1, setNav1] = useState();
  const [nav2, setNav2] = useState();
  const settings = {
    dots: false,
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: nav1,
    responsive: [
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 400,
        settings: {
          slidesToShow: 2,
        },
      },
    ],
  };
  const productSlides = [
    {
      img: "/assets/images/products/1.png",
      off: "20",
    },
    {
      img: "/assets/images/products/2.png",
    },
    {
      img: "/assets/images/products/3.png",
      off: "15",
    },
    {
      img: "/assets/images/products/4.png",
    },
    {
      img: "/assets/images/products/3.png",
      off: "15",
    },
    {
      img: "/assets/images/products/4.png",
    },
  ];
  const similarProducts = [
    {
      img: "/assets/images/products/1.png",
      cat: "Chair Padded Seat",
      off: "20",
    },
    {
      img: "/assets/images/products/2.png",
      cat: "Chair Padded Seat",
    },
    {
      img: "/assets/images/products/3.png",
      cat: "Chair Padded Seat",
      off: "70",
    },
    {
      img: "/assets/images/products/4.png",
      cat: "Chair Padded Seat",
    },
    {
      img: "/assets/images/products/1.png",
      cat: "Chair Padded Seat",
      off: "20",
    },
    {
      img: "/assets/images/products/2.png",
      cat: "Chair Padded Seat",
    },
    {
      img: "/assets/images/products/3.png",
      cat: "Chair Padded Seat",
      off: "70",
    },
    {
      img: "/assets/images/products/4.png",
      cat: "Chair Padded Seat",
    },
  ];

  return (
      <Layout seo={seo}>
    <div className="SingleProduct">
      <div className="container">
        <div className="path">
          <span>Home</span> <img src="/assets/images/icons/arrows/2.svg" alt="" />
          <span>Living room furniture</span> <img src="/assets/images/icons/arrows/2.svg" alt="" />
          <span className="active">Gray Chair</span>
        </div>
        <div className="flex main">
          <div className="view">
            <Slider
              className="slider_1"
              asNavFor={nav2}
              slidesToShow={1}
              ref={(slider1) => setNav1(slider1)}
              arrows={false}
            >
              {productSlides.map((item, i) => {
                return <ProductImage src={item.img} discount={item.off} />;
              })}
            </Slider>
            <Slider
              className="slider_2"
              ref={(slider2) => setNav2(slider2)}
              {...settings}
            >
              {productSlides.map((item, i) => {
                return (
                  <ProductImage key={i} src={item.img} discount={item.off} />
                );
              })}
            </Slider>
          </div>
          <div className="details">
            <div className="bold">Gray chair</div>
            <div className="in_stock">in stock</div>
            <p className="op5">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
              eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
              enim ad minim veniam, quis nostrud exercitation ullamco laboris
              nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
              reprehenderit in voluptate velit esse cillum dolore eu fugiat
              nulla pariatur.
            </p>
            <div className="margin">
              <div style={{ marginBottom: "10px" }}>
                Categories: <span className="op5">Living room furniture</span>
              </div>
              <div>
                Product code: <span>ZS 23221 - 321</span>
              </div>
            </div>

            <MainButton link="/" text="Contact for order" />
          </div>
        </div>
      </div>
      <div className="wrapper">
        <div className="similar_products bold">similar products</div>
        <div className="grid4">
          {similarProducts.map((item, i) => {
              let product = ['product'];
              let link = route('client.product.show',product);
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

export default SingleProduct;

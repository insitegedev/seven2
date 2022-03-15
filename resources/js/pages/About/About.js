import React from "react";
import Layout from "../../Layouts/Layout";
//import Image1 from "../../assets/images/about/1.png";
//import Image2 from "../../assets/images/about/2.png";
//import Image3 from "../../assets/images/about/3.png";
//import Gl1 from "../../assets/images/gallery/1.png";
//import Gl2 from "../../assets/images/gallery/2.png";
//import Gl3 from "../../assets/images/gallery/3.png";
//import Gl4 from "../../assets/images/gallery/4.png";
//import Gl5 from "../../assets/images/gallery/5.png";
//import Gl6 from "../../assets/images/gallery/6.png";
import "./About.css";

const About = (page,seo) => {
  const gallery = [
    "/assets/images/gallery/1.png",
    "/assets/images/gallery/2.png",
    "/assets/images/gallery/3.png",
    "/assets/images/gallery/2.png",
    "/assets/images/gallery/3.png",
    "/assets/images/gallery/4.png",
    "/assets/images/gallery/5.png",
    "/assets/images/gallery/2.png",
    "/assets/images/gallery/3.png",
    "/assets/images/gallery/4.png",
    "/assets/images/gallery/6.png",
    "/assets/images/gallery/3.png",
    "/assets/images/gallery/4.png",
    "/assets/images/gallery/5.png",
  ];
  return (
      <Layout seo={seo}>
    <div className="aboutPage wrapper">
      <div className="head bold">About us</div>
      <div className="showcase img">
        <img src="/assets/images/about/1.png" alt="" />
      </div>
      <div className="flex one">
        <img src="/assets/images/about/2.png" alt="" />
        <div className="content">
          <div className="bold">Our history</div>
          <div className="title underline">
            Consectetur adipiscing elit, sed do
          </div>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur.
          </p>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur.
          </p>
        </div>
      </div>
      <div className="flex two">
        <div className="content">
          <div className="bold">our mission</div>
          <div className="title underline">
            Consectetur adipiscing elit, sed do
          </div>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur.
          </p>
        </div>
        <img src="/assets/images/about/3.png" alt="" />
      </div>
      <div className="gallery">
        <div className="bold underline">gallery</div>
        <div className="grid">
          {gallery.map((img, i) => {
            return (
              <div key={i} className="img">
                <img src={img} alt="" />
              </div>
            );
          })}
        </div>
      </div>
    </div>
      </Layout>
  );
};

export default About;

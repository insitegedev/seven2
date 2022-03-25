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
import {usePage} from "@inertiajs/inertia-react";

const About = ({page, seo}) => {
    const sharedData = usePage().props.localizations;
    const {gallery_img, images} = usePage().props;
    console.log(images)
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
      <div className="head bold">{__('client.about_us_header',sharedData)}</div>
      <div className="showcase img">
        <img src={images[0]} alt="" />
      </div>
      <div className="flex one">
        <img src={images[1]} alt="" />
        <div className="content">
          <div className="bold">{__('client.about_us_section1_header',sharedData)}</div>
          <div className="title underline">
              {__('client.about_us_section1_header2',sharedData)}
          </div>
          <p>
              {__('client.about_us_section1_p1',sharedData)}
          </p>
          <p>
              {__('client.about_us_section1_p2',sharedData)}
          </p>
        </div>
      </div>
      <div className="flex two">
        <div className="content">
          <div className="bold">{__('client.about_us_section2_header1',sharedData)}</div>
          <div className="title underline">
              {__('client.about_us_section2_header2',sharedData)}
          </div>
          <p>
              {__('client.about_us_section2_p1',sharedData)}
          </p>
        </div>
        <img src={images[2]} alt="" />
      </div>
      <div className="gallery">
        <div className="bold underline">{__('client.about_us_gallery',sharedData)}</div>
        <div className="grid">
          {gallery_img.files.map((img, i) => {
            return (
              <div key={i} className="img">
                <img src={ '/' + img.path + '/' + img.title } alt="" />
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

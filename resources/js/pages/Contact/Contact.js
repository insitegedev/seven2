import React from "react";
import { Link } from "@inertiajs/inertia-react";
import { Map } from "../../components/Map";
import "./Contact.css";
//import Tel from "../../assets/images/icons/conatct/tel.svg";
//import Pin from "../../assets/images/icons/conatct/pin.svg";
//import Mail from "../../assets/images/icons/conatct/mail.svg";
import { MainButton } from "../../components/MainButton/MainButton";
//import Bg from "../../assets/images/products/bg.png";
import Layout from "../../Layouts/Layout";

const Contact = ({page,seo}) => {
  const contactInfo = [
    {
      icon: "/assets/images/icons/conatct/mail.svg",
      text: "example@mail.com",
      link: "/",
    },
    {
      icon: "/assets/images/icons/conatct/tel.svg",
      text: "+995 555 26 46 23",
      link: "/",
    },
    {
      icon: "/assets/images/icons/conatct/pin.svg",
      text: "Bagrationi  str 6. Batumi, Georgia.",
      link: "/",
    },
  ];
  const inputs = [
    {
      type: "text",
      placeholder: "Enter your name and surname here",
    },
    {
      type: "tel",
      placeholder: "Your phone number is",
    },
    {
      type: "text",
      placeholder: "Tell us your email address",
    },
  ];
  return (
      <Layout seo={seo}>
    <div className="contactPage">
      <img className="bg_img" src="/assets/images/products/bg.png" alt="" />
      <div className="showcase">
        <div className="bold">Contact</div>
      </div>
      <div className="wrapper">
        <div className="map">
          <Map />
        </div>
        <div className="info_box flex centered">
          {contactInfo.map((info, i) => {
            return (
              <Link className="flex centered" href={info.link} key={i}>
                <img src={info.icon} alt="" />
                <div className="bold">{info.text}</div>
              </Link>
            );
          })}
        </div>
        <div className="form">
          {inputs.map((input, i) => {
            return (
              <input
                type={input.type}
                placeholder={input.placeholder}
                key={i}
              />
            );
          })}
          <textarea placeholder="You can leave your message here"></textarea>
          <MainButton link="/" text="Send now" />
        </div>
      </div>
    </div>
      </Layout>
  );
};

export default Contact;

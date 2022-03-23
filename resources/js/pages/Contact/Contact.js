import React, {useState} from "react";
import {Link, usePage} from "@inertiajs/inertia-react";
import { Inertia } from '@inertiajs/inertia'
import { Map } from "../../components/Map";
import "./Contact.css";
//import Tel from "../../assets/images/icons/conatct/tel.svg";
//import Pin from "../../assets/images/icons/conatct/pin.svg";
//import Mail from "../../assets/images/icons/conatct/mail.svg";
import { MainButton } from "../../components/MainButton/MainButton";
//import Bg from "../../assets/images/products/bg.png";
import Layout from "../../Layouts/Layout";


const Contact = ({page,seo}) => {
    const sharedData = usePage().props.localizations;
    const {info,errors, images} = usePage().props;
    console.log(errors);

    const [values, setValues] = useState({
        name: null,
        phone: null,
        email: null,
        message: null
    })

    function handleChange(e) {
        setValues(values => ({
            ...values,
            [e.target.name]: e.target.value,
        }))
    }

    function handleSubmit(e) {
        e.preventDefault()

    }

    function handleClick(e){
        e.preventDefault()
        Inertia.post(route('client.contact.mail'), values)
    }

  const contactInfo = [
    {
      icon: "/assets/images/icons/conatct/mail.svg",
      text: info.email.translation ? info.email.translation.value : null,
      link: "/",
    },
    {
      icon: "/assets/images/icons/conatct/tel.svg",
      text: info.phone.translation ? info.phone.translation.value : null,
      link: "/",
    },
    {
      icon: "/assets/images/icons/conatct/pin.svg",
      text: info.address.translation ? info.address.translation.value : null,
      link: "/",
    },
  ];
  const inputs = [
    {
      type: "text",
      placeholder: __('client.contact_form_name_surname',sharedData),
        name: "name",
        id: "inp_name"
    },
    {
      type: "tel",
      placeholder: __('client.contact_form_telephone',sharedData),
        name: "phone",
        id: "inp_phone"
    },
    {
      type: "email",
      placeholder: __('client.contact_form_email',sharedData),
        name: "email",
        id: "inp_email"
    },
  ];
  return (
      <Layout seo={seo}>
    <div className="contactPage">
      <img className="bg_img" src={images[0]} alt="" />
      <div className="showcase">
        <div className="bold">{__('client.contact_header',sharedData)}</div>
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
            <form method="post" id="contact_f" onSubmit={handleSubmit}>
                {inputs.map((input, i) => {
                    return (
                        <input
                            id={input.id}
                            type={input.type}
                            placeholder={input.placeholder}
                            key={i}
                            name={input.name}
                            onChange={handleChange}
                        />
                    );
                })}
                <textarea onChange={handleChange} id="inp_message" name="message" placeholder={__('client.contact_form_message',sharedData)}></textarea>
                {errors.name && <div>{errors.name}</div>}
                <MainButton onclick={handleClick} id="send_eml" text={__('client.contact_form_send_btn',sharedData)} />

            </form>

        </div>
      </div>
    </div>
      </Layout>
  );
};



export default Contact;

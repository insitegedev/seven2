import React, { useState, useEffect } from "react";
import { MainButton } from "../../../components/MainButton/MainButton";
//import Arrow from "../../../assets/images/icons/arrows/1.svg";
//import FB from "../../../assets/images/icons/sm/fb.svg";
//import IG from "../../../assets/images/icons/sm/ig.svg";
//import Img1 from "../../../assets/images/hero/1.png";
import "./HeroSlider.css";
import { Link, usePage } from "@inertiajs/inertia-react";

const HeroSlider = () => {
    const renderHTML = (rawHTML) =>
        React.createElement("div", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });
    const { sliders, info } = usePage().props;
    //console.log(sliders);
    const sharedData = usePage().props.localizations;
    const sliderData = [
        {
            text1: "Living room furniture",
            text2: "New Collection",
            img: "/assets/images/hero/1.png",
        },
        {
            text1: "Kitchen cabinets",
            text2: "50% discount",
            img: "/assets/images/hero/1.png",
        },
        {
            text1: "Kitchen cabinets",
            text2: "50% discount",
            img: "/assets/images/hero/1.png",
        },
    ];
    const [index, setIndex] = useState(0);

    useEffect(() => {
        const lastIndex = sliders.length - 1;
        if (index < 0) {
            setIndex(lastIndex);
        }
        if (index > lastIndex) {
            setIndex(0);
        }
    }, [index]);

    useEffect(() => {
        let slider = setInterval(() => {
            setIndex(index + 1);
        }, 5000);
        return () => {
            clearInterval(slider);
        };
    }, [index]);

    const moveDot = (i) => {
        setIndex(i);
    };

    return (
        <div className="mainSlider">
            {sliders.map((data, indexData) => {
                let position = "nextSlide";
                if (indexData === index) {
                    position = "activeSlide";
                }
                if (
                    indexData === index - 1 ||
                    (index === 0 && indexData === data.length - 1)
                ) {
                    position = "lastSlide";
                }
                return (
                    <article className={position} key={indexData}>
                        <div className="content wrapper">
                            <div className="bold">{data.title}</div>
                            <h3>{renderHTML(data.description)}</h3>
                            <MainButton
                                link={data.youtube_url}
                                text={__(
                                    "client.home_slider_button",
                                    sharedData
                                )}
                            />
                        </div>
                        <img
                            className="slide_img"
                            src={"/" + data.file.path + "/" + data.file.title}
                            alt=""
                        />
                    </article>
                );
            })}
            <div className="flex controllers wrapper">
                <div className="sm">
                    {info.facebook.active == 1 ? (
                        <Link
                            href={
                                info.facebook.translation
                                    ? info.facebook.translation.value
                                    : null
                            }
                        >
                            <img src="/assets/images/icons/sm/fb.svg" alt="" />
                        </Link>
                    ) : (
                        ""
                    )}

                    {info.instagram.active == 1 ? (
                        <Link
                            href={
                                info.instagram.translation
                                    ? info.instagram.translation.value
                                    : null
                            }
                        >
                            <img src="/assets/images/icons/sm/ig.svg" alt="" />
                        </Link>
                    ) : (
                        ""
                    )}
                </div>
                <div>
                    <button
                        onClick={() => setIndex(index - 1)}
                        className="arrow prev"
                        style={{ transform: "rotate(180deg) translateY(22%)" }}
                    >
                        <img src="/assets/images/icons/arrows/1.svg" alt="" />
                    </button>
                    <button className="pagination">0{index + 1}</button>
                    <button
                        onClick={() => setIndex(index + 1)}
                        className="arrow next"
                    >
                        <img src="/assets/images/icons/arrows/1.svg" alt="" />
                    </button>
                </div>

                <div className="dots flex centered">
                    {sliders.map((item, i) => {
                        return (
                            <div
                                className={index === i ? "dot active" : "dot"}
                                onClick={() => moveDot(i)}
                            ></div>
                        );
                    })}
                </div>
            </div>
        </div>
    );
};

export default HeroSlider;

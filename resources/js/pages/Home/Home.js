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
import { shopCategories, popularProducts } from "./HomeData";
import "./Home.css";
import { usePage, Head } from "@inertiajs/inertia-react";
import Layout from "../../Layouts/Layout";
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

const Home = ({ page, seo }) => {
    const sharedData = usePage().props.localizations;
    const { popular_products, categories, images } = usePage().props;

    const onSaleCategories = [
        {
            off: __("client.home_sale1_off", sharedData),
            cat: __("client.home_sale1_title", sharedData),
            whiteButton: true,
            color: "#fff",
            bg: images[1],
        },
        {
            off: __("client.home_sale2_off", sharedData),
            cat: __("client.home_sale2_title", sharedData),
            whiteButton: false,
            color: "#05185A",
            bg: images[2],
        },
    ];

    const popularSlider = {
        slidesToShow: 4,
        autoplay: true,
        speed: 6000,
        cssEase: "linear",
        autoplaySpeed: 0,
        responsive: [
            {
                breakpoint: 1300,
                settings: {
                    slidesToShow: 3,
                },
                breakpoint: 900,
                settings: {
                    slidesToShow: 2,
                },
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                },
            },
        ],
    };

    //console.log(popular_products);
    return (
        <Layout seo={seo}>
            <div className="homePage">
                <HeroSlider />
                <div className="categories_home wrapper flex">
                    <div>
                        <h4>
                            {__("client.home_section1_text", sharedData)} <br />{" "}
                            {__("client.home_section1_text2", sharedData)}
                        </h4>
                        <MainButton
                            link={route("client.product.index")}
                            white
                            transparent
                            text={__(
                                "client.home_view_all_categories",
                                sharedData
                            )}
                        />
                    </div>
                    <div className="grid4" data-aos="zoom-in">
                        {categories.map((cat, i) => {
                            return (
                                <Link
                                    href={route(
                                        "client.category.show",
                                        cat.slug
                                    )}
                                    key={i}
                                >
                                    <ProductImage
                                        src={
                                            cat.files.length > 0
                                                ? "/" +
                                                  cat.files[0].path +
                                                  "/" +
                                                  cat.files[0].title
                                                : null
                                        }
                                        category={cat.title}
                                    />
                                </Link>
                            );
                        })}
                    </div>
                </div>
                <div
                    style={{ background: "url(" + images[0] + ") no-repeat" }}
                    className="exhibition"
                    data-aos="fade-up"
                ></div>
                <div className="onsale_cats flex wrapper">
                    {onSaleCategories.map((cat, i) => {
                        return (
                            <div
                                className="box flex centered"
                                key={i}
                                data-aos="zoom-out"
                            >
                                <img className="bg" src={cat.bg} alt="" />
                                <div
                                    className="container flex centered"
                                    style={{
                                        color: cat.color,
                                        border: `2px solid ${cat.color}`,
                                    }}
                                >
                                    <div className="bold">{cat.off}</div>
                                    <h5>{cat.cat}</h5>
                                    <MainButton
                                        link={route("client.product.index")}
                                        text={__(
                                            "client.home_shop_now",
                                            sharedData
                                        )}
                                        white={cat.whiteButton}
                                    />
                                </div>
                            </div>
                        );
                    })}
                </div>
                <div className="popular_products wrapper">
                    <div className="head flex">
                        <div className="title">
                            {__("client.popular_products", sharedData)}
                        </div>
                        <MainButton
                            text={__("client.home_view_all", sharedData)}
                            link={route("client.category.popular")}
                        />
                    </div>
                    <Slider className="slider" {...popularSlider}>
                        {popular_products.map((item, i) => {
                            //console.log(item)
                            let slug = item.slug;
                            let link = route("client.product.show", slug);
                            return (
                                <ProductBox
                                    key={i}
                                    src={
                                        item.files.length > 0 ?
                                        "/" +
                                        item.files[0].path +
                                        "/" +
                                        item.files[0].title : null
                                    }
                                    discount={item.sale}
                                    category={item.title}
                                    link={link}
                                />
                            );
                        })}
                    </Slider>
                </div>
            </div>
        </Layout>
    );
};

export default Home;

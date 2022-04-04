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
import { usePage } from "@inertiajs/inertia-react";
import { Link } from "@inertiajs/inertia-react";

const ProductSlider = () => {
    const sharedData = usePage().props.localizations;
    const [nav1, setNav1] = useState();
    const [nav2, setNav2] = useState();
    const { product, category_path, similar_products, product_images } =
        usePage().props;
    //console.log(product);
    //console.log(category);
    //console.log(similar_products);
    const settings = {
        dots: false,
        infinite: product_images.length > 4 ? true : false,
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: nav1,
        arrows: false,
        unslick: product_images.length < 4 ? true : false,
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
    const renderHTML = (rawHTML) =>
        React.createElement("div", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

    const breadcrumb = function (path) {
        let rows = [];
        path.map(function (el, i) {
            rows.push(<span>{el.title}</span>);
            rows.push(<img src="/assets/images/icons/arrows/2.svg" alt="" />);
        });
        return rows;
    };

    const breadcrumb2 = function (path) {
        let rows = [];

        path.map(function (el, i) {
            if (i < path.length - 1) {
                rows.push(<span className="op5">{el.title}</span>);
                rows.push(<span className="op5">,</span>);
            } else {
                rows.push(<span className="op5">{el.title}</span>);
            }
        });
        return rows;
    };

    return (
        <div className="product_slider">
            <Slider
                className="slider_1"
                asNavFor={nav2}
                slidesToShow={1}
                ref={(slider1) => setNav1(slider1)}
                arrows={true}
            >
                {product_images.map((item, i) => {
                    return (
                        <ProductImage
                            key={i}
                            src={"/" + item.path + "/" + item.title}
                            discount={item.off}
                        />
                    );
                })}
            </Slider>
            <Slider
                className="slider_2"
                ref={(slider2) => setNav2(slider2)}
                {...settings}
            >
                {product_images.map((item, i) => {
                    return (
                        <ProductImage
                            key={i}
                            src={"/" + item.path + "/" + item.title}
                            discount={item.off}
                        />
                    );
                })}
            </Slider>
        </div>
    );
};

export default ProductSlider;

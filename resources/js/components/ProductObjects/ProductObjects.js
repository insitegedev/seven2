import React from "react";
import { MainButton } from "../MainButton/MainButton";
import "./ProductObjects.css";
import { usePage } from "@inertiajs/inertia-react";
//import Link from "react-scroll/modules/components/Link";
import { Link } from "@inertiajs/inertia-react";

export const ProductImage = ({ src, category, discount, onClick }) => {
    return (
        <div className="product_image flex centered" onClick={onClick}>
            <img src={src} alt="" />
            <div className="bold">{category}</div>
            <div
                style={{ display: discount ? "block" : "none" }}
                className="discount"
            >
                -{discount}%
            </div>
        </div>
    );
};

export const ProductBox = (props) => {
    const sharedData = usePage().props.localizations;
    return (
        <Link href={props.link}>
            <div className="product_box">
                <ProductImage src={props.src} discount={props.discount} />
                <div className="bold">{props.category}</div>
                <MainButton
                    transparent
                    white
                    text={__("client.product_learn_more", sharedData)}
                    link={props.link}
                />
            </div>
        </Link>
    );
};

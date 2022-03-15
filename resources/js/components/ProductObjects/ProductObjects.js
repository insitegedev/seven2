import React from "react";
import { MainButton } from "../MainButton/MainButton";
import "./ProductObjects.css";

export const ProductImage = ({ src, category, discount }) => {
  return (
    <div className="product_image flex centered">
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
  return (
    <div className="product_box">
      <ProductImage src={props.src} discount={props.discount} />
      <div className="bold">{props.category}</div>
      <MainButton transparent white text="Learn more" link={props.link} />
    </div>
  );
};

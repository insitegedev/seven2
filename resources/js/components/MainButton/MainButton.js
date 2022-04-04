import React from "react";
import { Link } from "@inertiajs/inertia-react";
import "./MainButton.css";

export const MainButton = (props) => {
  return (
    <Link onClick={props.onclick} id={props.id} href={props.link}>
      <button
        className={
          props.transparent
            ? "main_button flex centered transparent"
            : "main_button flex centered"
        }
        style={{
          color: props.white ? "#05185A" : "#fff",
          background: props.white ? "#fff" : "#05185A",
        }}
      >
        <div>{props.text}</div>
        <svg width="14.845" height="14.469" viewBox="0 0 14.845 14.469">
          <path
            id="Icon_awesome-arrow-right"
            data-name="Icon awesome-arrow-right"
            d="M6.312,3.616l.736-.736a.792.792,0,0,1,1.123,0l6.441,6.437a.792.792,0,0,1,0,1.123L8.17,16.882a.792.792,0,0,1-1.123,0l-.736-.736a.8.8,0,0,1,.013-1.136l3.992-3.8H.8a.793.793,0,0,1-.8-.8V9.351a.793.793,0,0,1,.8-.8h9.522l-3.992-3.8A.79.79,0,0,1,6.312,3.616Z"
            transform="translate(0 -2.647)"
            fill={props.white ? "#05185A" : "#fff"}
          />
        </svg>
      </button>
    </Link>
  );
};

import React, { useState } from "react";
import { Link } from "@inertiajs/inertia-react";
import { ProductBox } from "../../components/ProductObjects/ProductObjects";
import "./Products.css";
import Layout from "../../Layouts/Layout";
import { usePage, Head } from "@inertiajs/inertia-react";
//import Img1 from "../../assets/images/products/1.png";
//import Img2 from "../../assets/images/products/2.png";
//import Img3 from "../../assets/images/products/3.png";
//import Img4 from "../../assets/images/products/4.png";

const Products = (page,seo) => {
  const [showTab, setShowTab] = useState(0);
  const catColumn = [
    {
      cat: "Living room furniture",
      links: [
        "TV unit",
        "Console",
        "Coffee table",
        "Accessories",
        "Full complectation",
      ],
    },
    {
      cat: "Upholstered furniture",
      links: [
        "Corner sofa",
        "Sofa",
        "Puff",
        "Armchair",
        "Full complectation",
        "",
      ],
    },
    {
      cat: "Table-chair",
      links: ["Table", "Chair", "Bar chair", "Full complectation"],
    },
    {
      cat: "Bedroom furniture",
      links: [
        "Bed",
        "Wardrobes",
        "Pump",
        "Commode",
        "Mattress",
        "Full complectation",
      ],
    },
  ];
  const productTabs = [
    {
      tab: "all",
      data: [
        {
          img: "/assets/images/products/1.png",
          cat: "Chair Padded Seat",
        },
        {
          img: "/assets/images/products/1.png",
          cat: "Chair Padded Seat",
          off: "20",
        },
        {
          img: "/assets/images/products/3.png",
          cat: "Chair Padded Seat",
        },
        {
          img: "/assets/images/products/4.png",
          cat: "Chair Padded Seat",
          off: "50",
        },
        {
          img: "/assets/images/products/1.png",
          cat: "Chair Padded Seat",
        },
        {
          img: "/assets/images/products/2.png",
          cat: "Chair Padded Seat",
        },
        {
          img: "/assets/images/products/3.png",
          cat: "Chair Padded Seat",
        },
        {
          img: "/assets/images/products/4.png",
          cat: "Chair Padded Seat",
          off: "15",
        },
      ],
    },
    {
      tab: "Living room furniture",
      data: [
        {
          img: "/assets/images/products/2.png",
          cat: "Chair Padded Seat",
        },
        {
          img: "/assets/images/products/3.png",
          cat: "Chair Padded Seat",
        },

        {
          img: "/assets/images/products/4.png",
          cat: "Chair Padded Seat",
        },
      ],
    },
    {
      tab: "Upholstered furniture",
      data: [
        {
          img: "/assets/images/products/3.png",
          cat: "Chair Padded Seat",
        },
        {
          img: "/assets/images/products/3.png",
          cat: "Chair Padded Seat",
        },
      ],
    },
    {
      tab: "Table-chair",
      data: [
        {
          img: "/assets/images/products/4.png",
          cat: "Chair Padded Seat",
        },
      ],
    },
    {
      tab: "Bedroom furniture",
      data: [
        {
          img: "/assets/images/products/3.png",
          cat: "Chair Padded Seat",
        },
      ],
    },
  ];

  return (
      <Layout seo={seo}>
    <div className="productsPage">
      <div className="showcase fixed_bg"></div>
      <div className="wrapper flex main">
        <div className="cat_column">
          {catColumn.map((item, i) => {
            return (
              <div className="item" key={i}>
                <div className="bold">{item.cat}</div>
                {item.links.map((link, i) => {
                  return (
                    <Link href="/" key={i}>
                      {link}
                    </Link>
                  );
                })}
              </div>
            );
          })}
        </div>
        <div className="product_tabs">
          {productTabs.map((tab, i) => {
            return (
              <>
                <button
                  key={i}
                  className={
                    showTab === i ? "active tab_btn bold" : "tab_btn bold"
                  }
                  onClick={() => setShowTab(i)}
                >
                  {tab.tab}
                </button>
              </>
            );
          })}
          {productTabs.map((tab, i) => {
            return (
              <div
                key={i}
                className="grid4"
                style={{ display: showTab === i ? "grid " : "none" }}
              >
                {tab.data.map((item, i) => {
                    let product = ['product'];
                    let link = route('client.product.show',product);
                  return (
                    <ProductBox
                      src={item.img}
                      discount={item.off}
                      category={item.cat}
                      link={link}
                    />
                  );
                })}
              </div>
            );
          })}
          <div className="pagination flex centered">
            <button className="bold active">1</button>
            <button className="bold">2</button>
            <button className="bold">3</button>
            <button className="bold">4</button>
          </div>
        </div>
      </div>
      <div className="fixed_bg last">
        best furniture <br /> for your apartment
      </div>
    </div>
      </Layout>
  );
};

export default Products;

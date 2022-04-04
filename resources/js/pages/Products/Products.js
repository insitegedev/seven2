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

const Products = ({page, seo}) => {
  const [showTab, setShowTab] = useState(0);
    const { categories, products, category, images } = usePage().props;
    const sharedData = usePage().props.localizations;
    console.log(category);
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

    let subcategory = function (children){
        let rows = [];
        if(children.length > 0){
            children.map(child => {
                rows.push(<Link href={route('client.category.show',child.slug)}>{child.title}</Link>)
            })
        }
        return rows
    }

    let links = function (links){
        let rows = [];
        //links.shift();
        //links.splice(-1);
        {links.map(function (item,index){


            if (index > 0 && index < links.length - 1){
                rows.push(<Link href={item.url} className={(item.active) ? 'bold active': 'bold'}>{item.label}</Link>)
            }

        })}
        return rows.length > 1 ? rows : null
    }

  return (
      <Layout seo={seo}>
    <div className="productsPage">
      <div style={{background: 'url(' + images[0] +') no-repeat'}} className="showcase fixed_bg"></div>
      <div className="wrapper flex main">
        <div className="cat_column">
          {categories.map((item, i) => {
            return (
              <div className="item" key={i}>
                <div className="bold">{item.title}</div>
                  {subcategory(item.children)}
              </div>
            );
          })}
        </div>
        <div className="product_tabs">
            <Link className={
                !category ? "active tab_btn bold" : "tab_btn bold"
            } href={route('client.product.index')}>{__('client.category_all',sharedData)}</Link>
          {categories.map((tab, i) => {
              let link = route('client.category.show',tab.slug);
            return (
              <>
                <Link
                  key={i}
                  className={
                    (category && tab.id === category.id) ? "active tab_btn bold" : "tab_btn bold"
                  }
                  href={link}
                >
                  {tab.title}
                </Link>
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
                {products.data.map((item, i) => {
                    let slug = item.slug;
                    let link = route('client.product.show',slug);
                  return (
                    <ProductBox
                      src={( item.files.length > 0) ? '/' + item.files[item.files.length - 1].path + '/' + item.files[item.files.length - 1].title : null}
                      discount={item.sale}
                      category={item.title}
                      link={link}
                    />
                  );
                })}
              </div>
            );
          })}
          <div className="pagination flex centered">
              {links(products.links)}
          </div>
        </div>
      </div>
      <div style={{background: 'url(' + images[0] +') no-repeat'}} className="fixed_bg last">
          {__('client.products_section_text1',sharedData)} <br /> {__('client.products_section_text2',sharedData)}
      </div>
    </div>
      </Layout>
  );
};

export default Products;

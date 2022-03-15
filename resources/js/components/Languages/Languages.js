import React from "react";
import {Link, usePage} from "@inertiajs/inertia-react";


export const Languages = () => {
    const {locales, currentLocale, locale_urls} = usePage().props;


    return (
        <div className="languages">
            <div className="lang_on">
                {Object.keys(locales).map((name, index) => {
                    if (locales[name] === currentLocale) {
                        return (
                            <a href={locale_urls[name]} key={name + "locale"}>{name}</a>
                        );
                    }
                })}
            </div>
            <div className="lang_drop">
                {Object.keys(locales).map((name, index) => {
                    if (locales[name] !== currentLocale) {
                        return (
                            <a href={locale_urls[name]} key={name + "locale"}>{name}</a>
                        );
                    }
                })}
            </div>
        </div>

    );
};

/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/server-side-render":
/*!******************************************!*\
  !*** external ["wp","serverSideRender"] ***!
  \******************************************/
/***/ ((module) => {

module.exports = window["wp"]["serverSideRender"];

/***/ }),

/***/ "react/jsx-runtime":
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["ReactJSXRuntime"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/server-side-render */ "@wordpress/server-side-render");
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__);





// Set defaults

const an_ebay_site = typeof an_block_js.an_ebay_site !== "undefined" ? an_block_js.an_ebay_site : "0";
const an_ebay_user = typeof an_block_js.an_ebay_user !== "undefined" ? an_block_js.an_ebay_user : "";
const helpLabel = (label, helpText, helpURL) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("span", {
  className: "an-field-label",
  children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
    className: "an-field-text",
    children: label
  }), helpText && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Tooltip, {
    text: helpText,
    position: "right",
    delay: 0,
    children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
      className: "an-help",
      tabIndex: "0",
      "aria-label": `${label} help`,
      role: "note",
      children: "?"
    })
  }), helpURL && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("a", {
    href: helpURL,
    target: "_blank",
    rel: "noopener noreferrer",
    children: "HELP"
  })]
});

// Inject minimal styles once (kept very lightweight)
if (typeof document !== "undefined" && !document.getElementById("an-block-help-styles")) {
  const style = document.createElement("style");
  style.id = "an-block-help-styles";
  style.textContent = `
    .components-flex-item { 
      max-width: 100% !important; 
    }
    .an-field-label .an-help { 
      cursor: help;
      display: inline-block;
      float: right;
      text-align: center;
      width: 16px;
      height: 16px;
      line-height: 16px;
      font-size: 11px;
      font-weight: 600;
      border-radius: 50%;
      background: #f0f0f0;
      color: #555;
      border: 1px solid #d0d0d0;
    }
    .an-field-label a {
      float: right;
      margin-right: 5px;
      font-size: 11px;
    } 
  `;
  document.head.appendChild(style);
}
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)("your-ebay-listings/block", {
  title: "Your eBay Listings",
  icon: "cart",
  category: "widgets",
  attributes: {
    SellerID: {
      type: "string",
      default: an_ebay_user
    },
    siteid: {
      type: "string",
      default: an_ebay_site
    },
    theme: {
      type: "string",
      default: "responsive"
    },
    lang: {
      type: "string",
      default: "english"
    },
    cats_output: {
      type: "string",
      default: "dropdown"
    },
    MaxEntries: {
      type: "number",
      default: 6
    },
    page: {
      type: "string",
      default: "init"
    },
    search_box: {
      type: "string",
      default: "1"
    },
    grid_cols: {
      type: "number",
      default: 2
    },
    grid_width: {
      type: "string",
      default: "100%"
    },
    show_logo: {
      type: "string",
      default: "1"
    },
    img_size: {
      type: "number",
      default: 120
    },
    user_profile: {
      type: "string",
      default: "0"
    },
    add_details: {
      type: "string",
      default: "0"
    },
    sortOrder: {
      type: "string",
      default: ""
    },
    listing_type: {
      type: "string",
      default: ""
    },
    keyword: {
      type: "string",
      default: ""
    },
    categoryId: {
      type: "string",
      default: ""
    },
    carousel_scroll: {
      type: "number",
      default: 2
    },
    carousel_width: {
      type: "number",
      default: 240
    },
    carousel_auto: {
      type: "number",
      default: 0
    }
  },
  edit({
    attributes,
    setAttributes
  }) {
    const {
      SellerID,
      siteid,
      theme,
      lang,
      cats_output,
      MaxEntries,
      page,
      search_box,
      grid_cols,
      grid_width,
      show_logo,
      img_size,
      user_profile,
      add_details,
      sortOrder,
      listing_type,
      keyword,
      categoryId,
      carousel_scroll,
      carousel_width,
      carousel_auto
    } = attributes;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.Fragment, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InspectorControls, {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
          title: "Feed Options",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
            label: helpLabel("eBay Username", "This is your eBay ID – the username you are known by on eBay and appears on your listings. This is not your store name."),
            value: SellerID,
            onChange: value => setAttributes({
              SellerID: value
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.SelectControl, {
            label: helpLabel("eBay Site", "This is where your items are usually listed. The site you choose will determine where you link to and what currency is displayed."),
            value: siteid,
            options: [{
              label: "eBay US",
              value: "0"
            }, {
              label: "eBay UK",
              value: "3"
            }, {
              label: "eBay Canada",
              value: "2"
            }, {
              label: "eBay Australia",
              value: "15"
            }, {
              label: "eBay Belgium",
              value: "23"
            }, {
              label: "eBay Germany",
              value: "77"
            }, {
              label: "eBay France",
              value: "71"
            }, {
              label: "eBay Spain",
              value: "186"
            }, {
              label: "eBay Austria",
              value: "16"
            }, {
              label: "eBay Italy",
              value: "101"
            }, {
              label: "eBay Netherlands",
              value: "146"
            }, {
              label: "eBay Ireland",
              value: "205"
            }, {
              label: "eBay Switzerland",
              value: "193"
            }, {
              label: "eBay Poland",
              value: "212"
            }],
            onChange: value => setAttributes({
              siteid: value
            })
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
          title: "Display Options",
          initialOpen: false,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ToggleControl, {
            label: helpLabel("View Details", "When View Details is enabled, instead of linking directly to the item on eBay, additional item details will be displayed. Details include extra images, item description, item specifics, your user profile and a 'View on eBay' button. The Advertising Disclosure is displayed above the details.", "https://www.auctionnudge.com/help/options#details"),
            checked: add_details === "1",
            onChange: isChecked => setAttributes({
              add_details: isChecked ? "1" : "0"
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ToggleControl, {
            label: helpLabel("User Profile", "If enabled, your eBay Username, positive feedback percentage, feedback score and feedback star (if applicable) will be displayed above your listings."),
            checked: user_profile === "1",
            onChange: isChecked => setAttributes({
              user_profile: isChecked ? "1" : "0"
            })
          }), theme !== "carousel" && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ToggleControl, {
            label: helpLabel("Pagination", "If you enable this option and have more items listed than the value for the 'Items per Page' option above, users can paginate between multiple pages of items."),
            checked: page === "init",
            onChange: isChecked => setAttributes({
              page: isChecked ? "init" : ""
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ToggleControl, {
            label: helpLabel("Search", "If enabled, a search box will appear above the items which will allow users to search all of your active eBay items. Note: Only item titles are searched, not descriptions.", "https://www.auctionnudge.com/help/options#search-box"),
            checked: search_box === "1",
            onChange: isChecked => setAttributes({
              search_box: isChecked ? "1" : "0"
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.SelectControl, {
            label: helpLabel("Category List", "Once enabled, a list of categories for your items (if you have items for sale in more than one category) will be displayed above your items. This allows users to filter your items by category. The categories shown are eBay categories and not custom/store categories which can not be displayed. Use the Category ID option (Advanced Options) to specify a starting category.", "https://www.auctionnudge.com/help/options#category-list"),
            value: cats_output,
            options: [{
              label: "Dropdown",
              value: "dropdown"
            }, {
              label: "Unstyled (advanced)",
              value: "unstyled"
            }, {
              label: "None",
              value: ""
            }],
            onChange: value => setAttributes({
              cats_output: value
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.SelectControl, {
            label: helpLabel("Theme", "Your items will display differently on your site depending on which theme you choose. You can change how these themes displaying your listings using CSS rules.", "https://www.auctionnudge.com/customize/appearance"),
            value: theme,
            options: [{
              label: "Responsive",
              value: "responsive"
            }, {
              label: "Grid View",
              value: "grid"
            }, {
              label: "Column View",
              value: "columns"
            }, {
              label: "Carousel",
              value: "carousel"
            }, {
              label: "Simple List",
              value: "simple_list"
            }, {
              label: "Image and Details",
              value: "details"
            }, {
              label: "Images Only",
              value: "images_only"
            }, {
              label: "Unstyled (advanced)",
              value: "unstyled"
            }],
            onChange: value => setAttributes({
              theme: value
            })
          }), theme === "carousel" && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
            label: helpLabel("Carousel Scroll", "This option specifies how many items will be visible in the carousel at one time. Use in conjunction with 'Item Width' to set the overall carousel width, i.e. 140px * 4 = 560px."),
            value: carousel_scroll,
            onChange: value => setAttributes({
              carousel_scroll: value
            })
          }), theme === "carousel" && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
            label: helpLabel("Item Width", "Specify in pixels how wide each item in the carousel will be. Use in conjunction with 'Number of items to scroll' to set the overall carousel width, i.e. 140 * 4 = 560px."),
            value: carousel_width,
            onChange: value => setAttributes({
              carousel_width: value
            })
          }), theme === "carousel" && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
            label: helpLabel("Auto Scroll", "This option specifies how often, in seconds the carousel should auto scroll. If set to 0 auto scroll is disabled."),
            value: carousel_auto,
            onChange: value => setAttributes({
              carousel_auto: value
            })
          }), theme === "grid" && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
            label: helpLabel("Grid Columns", "Use this option to specify how many columns to display in grid view."),
            value: grid_cols,
            onChange: value => setAttributes({
              grid_cols: value
            })
          }), theme === "grid" && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
            label: helpLabel("Grid Width", "Use this option to specify how wide the grid should be. This can be specified in either pixels (px) or as a percentage (%)"),
            value: grid_width,
            onChange: value => setAttributes({
              grid_width: value
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
            label: helpLabel("Items per Page", "This is the number of items you want display per page, the maximum value is 100. You can display multiple pages of items using the 'Pagination' option."),
            value: MaxEntries,
            onChange: value => setAttributes({
              MaxEntries: value
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
            label: helpLabel("Image Size", "Specify in pixels the maximum image size. Depending on the image ratio, the image width or height will not exceed this size. At larger sizes, higher quality images (and therefore a larger file size) are used.", "https://www.auctionnudge.com/customize/appearance#image-size"),
            value: img_size,
            onChange: value => setAttributes({
              img_size: value
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ToggleControl, {
            label: helpLabel("Show eBay Logo?", "This option specifies if you want to display the eBay logo alongside your listings."),
            checked: show_logo === "1",
            onChange: isChecked => setAttributes({
              show_logo: isChecked ? "1" : "0"
            })
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
          title: "Advanced Options",
          initialOpen: false,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.SelectControl, {
            label: helpLabel("Language", "The language option allows you to specify which language Auction Nudge tools display on your site. This option will not modify eBay item titles, which will remain unchanged.", "https://www.auctionnudge.com/help/options#language"),
            value: lang,
            options: [{
              label: "English",
              value: "english"
            }, {
              label: "French",
              value: "french"
            }, {
              label: "German",
              value: "german"
            }, {
              label: "Italian",
              value: "italian"
            }, {
              label: "Spanish",
              value: "spanish"
            }, {
              label: "Dutch",
              value: "dutch"
            }, {
              label: "Polish",
              value: "polish"
            }],
            onChange: value => setAttributes({
              lang: value
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.SelectControl, {
            label: helpLabel("Sort Order", "This option adjusts the order in which items are shown."),
            value: sortOrder,
            options: [{
              label: "Items Ending First",
              value: ""
            }, {
              label: "Newly-Listed First",
              value: "StartTimeNewest"
            }, {
              label: "Price + Shipping: Lowest First",
              value: "PricePlusShippingLowest"
            }, {
              label: "Price + Shipping: Highest First",
              value: "PricePlusShippingHighest"
            }, {
              label: "Best Match",
              value: "BestMatch"
            }],
            onChange: value => setAttributes({
              sortOrder: value
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.SelectControl, {
            label: helpLabel("Listing Type", "Filtering by listing type allows you to choose to only display items listed as either Auction or Buy It Now. Auction listings that have the Buy It Now option available will be displayed both when filtering by Auction and Buy It Now."),
            value: listing_type,
            options: [{
              label: "All Listings",
              value: ""
            }, {
              label: "Buy It Now Only",
              value: "bin_only"
            }, {
              label: "Auction Only",
              value: "auction_only"
            }],
            onChange: value => setAttributes({
              listing_type: value
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
            label: helpLabel("Filter by Keyword", "By specifying a keyword, only items which contain that keyword in their title will be displayed. The keyword query can contain search operators, allowing for powerful searches to include/exclude certain keywords. Note: it is not possible to just use the minus sign (NOT) operator alone, another operator must be used to include items.", "https://www.auctionnudge.com/help/options#keyword-filter"),
            value: keyword,
            onChange: value => setAttributes({
              keyword: value
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
            label: helpLabel("Filter by Category ID", "By specifying an eBay category ID, only items which are listed in this category will be displayed.", "https://www.auctionnudge.com/help/options#category-filter"),
            value: categoryId,
            onChange: value => setAttributes({
              categoryId: value
            })
          })]
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)((_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_3___default()), {
        block: "your-ebay-listings/block",
        attributes: attributes
      })]
    });
  },
  save() {
    return null; // Rendered server-side
  }
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map
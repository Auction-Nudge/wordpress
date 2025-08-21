import { registerBlockType } from "@wordpress/blocks";
import { InspectorControls } from "@wordpress/block-editor";
import { PanelBody, TextControl, SelectControl, Tooltip, ToggleControl } from "@wordpress/components";
import ServerSideRender from "@wordpress/server-side-render";

// Set defaults
const an_ebay_site =
  typeof an_block_js.an_ebay_site !== "undefined"
    ? an_block_js.an_ebay_site
    : "0";
const an_ebay_user =
  typeof an_block_js.an_ebay_user !== "undefined"
    ? an_block_js.an_ebay_user
    : "";

// Lightweight helper to build a label with a help tooltip (hover/focus on ?)
const helpLabel = (label, helpText) => (
  <span className="an-field-label">
    <span className="an-field-text">{label}</span>
    {helpText && (
      <Tooltip text={helpText} position="right">
        <span
          className="an-help"
          tabIndex="0"
          aria-label={`${label} help`}
          role="note"
        >
          ?
        </span>
      </Tooltip>
    )}
  </span>
);

// Inject minimal styles once (kept very lightweight)
if (
  typeof document !== "undefined" &&
  !document.getElementById("an-block-help-styles")
) {
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
  `;
  document.head.appendChild(style);
}

registerBlockType("your-ebay-listings/block", {
  title: "Your eBay Listings",
  icon: "cart",
  category: "widgets",
  attributes: {
    SellerID: { type: "string", default: an_ebay_user },
    siteid: { type: "string", default: an_ebay_site },
    theme: { type: "string", default: "responsive" },
    lang: { type: "string", default: "english" },
    cats_output: { type: "string", default: "dropdown" },
    MaxEntries: { type: "number", default: 6 },
    page: { type: "string", default: "init" },
    search_box: { type: "string", default: "1" },
    grid_cols: { type: "number", default: 2 },
    grid_width: { type: "string", default: "100%" },
    show_logo: { type: "string", default: "1" },
    blank: { type: "string", default: "0" },
    img_size: { type: "number", default: 120 },
    user_profile: { type: "string", default: "0" },
    add_details: { type: "string", default: "0" },
    sortOrder: { type: "string", default: "" },
    listing_type: { type: "string", default: "" },
    keyword: { type: "string", default: "" },
    categoryId: { type: "string", default: "" },
  },
  edit({ attributes, setAttributes }) {
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
      blank,
      img_size,
      user_profile,
      add_details,
      sortOrder,
      listing_type,
      keyword,
      categoryId,
    } = attributes;

    return (
      <>
        <InspectorControls>
          {/* Step One */}
          <PanelBody title="Feed Options">
            {/* SellerID */}
            <TextControl
              label={helpLabel(
                "eBay Username",
                "This is your eBay ID – the username you are known by on eBay and appears on your listings. This is not your store name.",
              )}
              value={SellerID}
              onChange={(value) => setAttributes({ SellerID: value })}
            />

            {/* siteid */}
            <SelectControl
              label={helpLabel(
                "eBay Site",
                "This is where your items are usually listed. The site you choose will determine where you link to and what currency is displayed.",
              )}
              value={siteid}
              options={[
                { label: "eBay US", value: "0" },
                { label: "eBay UK", value: "3" },
                { label: "eBay Canada", value: "2" },
                { label: "eBay Australia", value: "15" },
                { label: "eBay Belgium", value: "23" },
                { label: "eBay Germany", value: "77" },
                { label: "eBay France", value: "71" },
                { label: "eBay Spain", value: "186" },
                { label: "eBay Austria", value: "16" },
                { label: "eBay Italy", value: "101" },
                { label: "eBay Netherlands", value: "146" },
                { label: "eBay Ireland", value: "205" },
                { label: "eBay Switzerland", value: "193" },
              ]}
              onChange={(value) => setAttributes({ siteid: value })}
            />
          </PanelBody>

          {/* Step Two */}
          <PanelBody title="Display Options" initialOpen={false}>
            {/* page toggle */}
            <ToggleControl
              label={helpLabel(
                "Pagination",
                "If you enable this option and have more items listed than the value for the 'Items per Page' option above, users can paginate between multiple pages of items.",
              )}
              checked={page === "init"}
              onChange={(isChecked) =>
                setAttributes({ page: isChecked ? "init" : "" })
              }
            />
            {/* search_box toggle */}
            <ToggleControl
              label={helpLabel(
                "Search",
                "If enabled, a search box will appear above the items which will allow users to search all of your active eBay items. Note: Only item titles are searched, not descriptions.",
              )}
              checked={search_box === "1"}
              onChange={(isChecked) =>
                setAttributes({ search_box: isChecked ? "1" : "0" })
              }
            />
            {/* user_profile toggle */}
            <ToggleControl
              label={helpLabel(
                "User Profile",
                "If enabled, your eBay Username, positive feedback percentage, feedback score and feedback star (if applicable) will be displayed above your listings.",
              )}
              checked={user_profile === "1"}
              onChange={(isChecked) =>
                setAttributes({ user_profile: isChecked ? "1" : "0" })
              }
            />
            {/* add_details toggle */}
            <ToggleControl
              label={helpLabel(
                "View Details",
                "When View Details is enabled, instead of linking directly to the item on eBay, additional item details will be displayed. Details include extra images, item description, item specifics, your user profile and a 'View on eBay' button. The Advertising Disclosure is displayed above the details.",
              )}
              checked={add_details === "1"}
              onChange={(isChecked) =>
                setAttributes({ add_details: isChecked ? "1" : "0" })
              }
            />

            <hr />

            {/* theme */}
            <SelectControl
              label={helpLabel(
                "Theme",
                "Your items will display differently on your site depending on which theme you choose. You can change how these themes displaying your listings using CSS rules.",
              )}
              value={theme}
              options={[
                { label: "Responsive", value: "responsive" },
                { label: "Column View", value: "columns" },
                { label: "Simple List", value: "simple_list" },
                { label: "Image and Details", value: "details" },
                { label: "Images Only", value: "images_only" },
                { label: "Grid View", value: "grid" },
                { label: "Unstyled (advanced)", value: "unstyled" },
              ]}
              onChange={(value) => setAttributes({ theme: value })}
            />
            {/* lang */}
            <SelectControl
              label={helpLabel(
                "Language",
                "The language option allows you to specify which language Auction Nudge tools display on your site. This option will not modify eBay item titles, which will remain unchanged.",
              )}
              value={lang}
              options={[
                { label: "English", value: "english" },
                { label: "French", value: "french" },
                { label: "German", value: "german" },
                { label: "Italian", value: "italian" },
                { label: "Spanish", value: "spanish" },
              ]}
              onChange={(value) => setAttributes({ lang: value })}
            />
            {/* cats_output */}
            <SelectControl
              label={helpLabel(
                "Category List",
                "Once enabled, a list of categories for your items (if you have items for sale in more than one category) will be displayed above your items. This allows users to filter your items by category. The categories shown are eBay categories and not custom/store categories which can not be displayed. Use the Category ID option (Advanced Options) to specify a starting category.",
              )}
              value={cats_output}
              options={[
                { label: "Dropdown", value: "dropdown" },
                { label: "Unstyled (advanced)", value: "unstyled" },
                { label: "None", value: "" },
              ]}
              onChange={(value) => setAttributes({ cats_output: value })}
            />
            {/* MaxEntries */}
            <TextControl
              label={helpLabel(
                "Items per Page",
                "This is the number of items you want display per page, the maximum value is 100. You can display multiple pages of items using the 'show multiple pages' option below. Note: The 'Carousel' theme can load a maximum of 100 items in total, as it does not support the 'show multiple pages' option.",
              )}
              value={MaxEntries}
              onChange={(value) => setAttributes({ MaxEntries: value })}
            />

            {/* grid_cols */}
            {theme === "grid" && (
              <TextControl
                label={helpLabel(
                  "Grid Columns",
                  "Use this option to specify how many columns to display in grid view.",
                )}
                value={grid_cols}
                onChange={(value) => setAttributes({ grid_cols: value })}
              />
            )}
            {/* grid_width */}
            {theme === "grid" && (
              <TextControl
                label={helpLabel(
                  "Grid Width",
                  "Use this option to specify how wide the grid should be. This can be specified in either pixels (px) or as a percentage (%)",
                )}
                value={grid_width}
                onChange={(value) => setAttributes({ grid_width: value })}
              />
            )}
          </PanelBody>
          <PanelBody title="Advanced Options" initialOpen={false}>
            {/* sortOrder */}
            <SelectControl
              label={helpLabel(
                "Sort Order",
                "This option adjusts the order in which items are shown.",
              )}
              value={sortOrder}
              options={[
                { label: "Items Ending First", value: "" },
                { label: "Newly-Listed First", value: "StartTimeNewest" },
                {
                  label: "Price + Shipping: Lowest First",
                  value: "PricePlusShippingLowest",
                },
                {
                  label: "Price + Shipping: Highest First",
                  value: "PricePlusShippingHighest",
                },
                { label: "Best Match", value: "BestMatch" },
              ]}
              onChange={(value) => setAttributes({ sortOrder: value })}
            />

            {/* show_logo toggle */}
            <ToggleControl
              label={helpLabel(
                "Show eBay Logo?",
                "This option specifies if you want to display the eBay logo alongside your listings.",
              )}
              checked={show_logo === "1"}
              onChange={(isChecked) =>
                setAttributes({ show_logo: isChecked ? "1" : "0" })
              }
            />

            {/* blank toggle */}
            <ToggleControl
              label={helpLabel(
                "Open Links in New Tab?",
                "Enabling this option will open item links in a new browser tab.",
              )}
              checked={blank === "1"}
              onChange={(isChecked) =>
                setAttributes({ blank: isChecked ? "1" : "0" })
              }
            />

            {/* img_size */}
            <TextControl
              label={helpLabel(
                "Image Size",
                "Specify in pixels the maximum image size. Depending on the image ratio, the image width or height will not exceed this size. At larger sizes, higher quality images (and therefore a larger file size) are used.",
              )}
              value={img_size}
              onChange={(value) => setAttributes({ img_size: value })}
            />

            {/* listing_type */}
            <SelectControl
              label={helpLabel(
                "Listing Type",
                "Filtering by listing type allows you to choose to only display items listed as either Auction or Buy It Now. Auction listings that have the Buy It Now option available will be displayed both when filtering by Auction and Buy It Now.",
              )}
              value={listing_type}
              options={[
                { label: "All Listings", value: "" },
                { label: "Buy It Now Only", value: "bin_only" },
                { label: "Auction Only", value: "auction_only" },
              ]}
              onChange={(value) => setAttributes({ listing_type: value })}
            />

            {/* keyword */}
            <TextControl
              label={helpLabel(
                "Filter by Keyword",
                "By specifying a keyword, only items which contain that keyword in their title will be displayed. The keyword query can contain search operators, allowing for powerful searches to include/exclude certain keywords. Note: it is not possible to just use the minus sign (NOT) operator alone, another operator must be used to include items.",
              )}
              value={keyword}
              onChange={(value) => setAttributes({ keyword: value })}
            />

            {/* categoryId */}
            <TextControl
              label={helpLabel(
                "Filter by Category ID",
                "By specifying an eBay category ID, only items which are listed in this category will be displayed. You can specify up to 3 different category IDs by separating with a colon (:) for example 123:456:789.",
              )}
              value={categoryId}
              onChange={(value) => setAttributes({ categoryId: value })}
            />
          </PanelBody>
        </InspectorControls>

        <ServerSideRender
          block="your-ebay-listings/block"
          attributes={attributes}
        />
      </>
    );
  },
  save() {
    return null; // Rendered server-side
  },
});

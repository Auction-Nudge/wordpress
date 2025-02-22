/*
$parameters = [
  //Step one
  'SellerID' => [
    'name' => 'SellerID',
    'id' => 'SellerID',
    'tip' => 'This is your eBay ID &ndash; the username you are known by on eBay and appears on your listings. This is not your store name.',
    'group' => 'feed',
    'title' => 'eBay Username',
  ],
  'siteid' => [
    'name' => 'siteid',
    'id' => 'siteid',
    'tip' => 'This is where your items are usually listed. The site you choose will determine where you link to and what currency is displayed.',
    'type' => 'select',
    'options' => [
      '0' => 'eBay US',
      '3' => 'eBay UK',
      '2' => 'eBay Canada',
      '15' => 'eBay Australia',
      '23' => 'eBay Belgium',
      '77' => 'eBay Germany',
      '71' => 'eBay France',
      '186' => 'eBay Spain',
      '16' => 'eBay Austria',
      '101' => 'eBay Italy',
      '146' => 'eBay Netherlands',
      '205' => 'eBay Ireland',
      '193' => 'eBay Switzerland',
    ],
    'default' => '0',
    'group' => 'feed',
    'title' => 'eBay Site',
  ],
  //Step two
  'theme' => [
    'name' => 'theme',
    'id' => 'theme',
    'tip' => 'Your items will display differently on your site depending on which theme you choose. You can change how these themes displaying your listings using CSS rules.',
    'tip_link' => 'https://www.auctionnudge.com/customize/appearance',
    'type' => 'select',
    'options' => [
      'responsive' => 'Responsive',
      'columns' => 'Column View',
      'simple_list' => 'Simple List',
      'details' => 'Image and Details',
      'images_only' => 'Images Only',
      'grid' => 'Grid View',
      'unstyled' => 'Unstyled (advanced)',
    ],
    'default' => 'responsive',
    'group' => 'display',
    'title' => 'Theme',
  ],
  'lang' => [
    'name' => 'lang',
    'id' => 'lang',
    'tip' => 'The language option allows you to specify which language Auction Nudge tools display on your site. This option will not modify eBay item titles, which will remain unchanged.',
    'tip_link' => 'https://www.auctionnudge.com/help/options#language',
    'type' => 'select',
    'options' => [
      'english' => 'English',
      'french' => 'French',
      'german' => 'German',
      'italian' => 'Italian',
      'spanish' => 'Spanish',
    ],
    'default' => 'english',
    'group' => 'display',
    'title' => 'Language',
  ],
  'cats_output' => [
    'name' => 'cats_output',
    'id' => 'cats_output',
    'tip' => 'Once enabled, a list of categories for your items (if you have items for sale in more than one category) will be displayed above your items. This allows users to filter your items by category. The categories shown are eBay categories and not custom/store categories which can not be displayed. Use the Category ID option (Advanced Options) to specify a starting category.',
    'tip_link' => 'https://www.auctionnudge.com/help/options#category-list',
    'type' => 'select',
    'options' => [
      'dropdown' => 'Dropdown',
      'unstyled' => 'Unstyled (advanced)',
      '' => 'None',
    ],
    'default' => 'dropdown',
    'group' => 'display',
    'title' => 'Category List',
  ],
  'MaxEntries' => [
    'name' => 'MaxEntries',
    'id' => 'MaxEntries',
    'tip' => 'This is the number of items you want display per page, the maximum value is 100. You can display multiple pages of items using the \'show multiple pages\' option below. Note: The \'Carousel\' theme can load a maximum of 100 items in total, as it does not support the \'show multiple pages\' option.',
    'group' => 'display',
    'title' => 'Items per Page',
    'default' => '6',
  ],
  'page' => [
    'name' => 'page',
    'id' => 'page',
    'tip' => 'If you enable this option and have more items listed than the value for the \'Items per Page\' option above, users can paginate between multiple pages of items.',
    'type' => 'radio',
    'group' => 'display',
    'title' => 'Show Multiple Pages?',
    'default' => 'init',
    'options' => [
      'init' => 'Yes',
      '' => 'No',
    ],
  ],
  'search_box' => [
    'name' => 'search_box',
    'id' => 'search_box',
    'tip' => 'If enabled, a search box will appear above the items which will allow users to search all of your active eBay items. Note: Only item titles are searched, not descriptions.',
    'tip_link' => 'https://www.auctionnudge.com/help/options#search-box',
    'type' => 'radio',
    'group' => 'display',
    'title' => 'Show Search Box?',
    'default' => '1',
    'options' => [
      '1' => 'Yes',
      '0' => 'No',
    ],
  ],
  'grid_cols' => [
    'name' => 'grid_cols',
    'id' => 'grid_cols',
    'tip' => 'Use this option to specify how many columns to display in grid view.',
    'group' => 'display',
    'title' => 'Grid Columns',
    'default' => '2',
  ],
  'grid_width' => [
    'name' => 'grid_width',
    'id' => 'grid_width',
    'tip' => 'Use this option to specify how wide the grid should be. This can be specified in either pixels (px) or as a percentage (%)',
    'group' => 'display',
    'title' => 'Grid Width',
    'default' => '100%',
  ],
  'show_logo' => [
    'name' => 'show_logo',
    'id' => 'show_logo',
    'tip' => 'This option specifies if you want to display the eBay logo alongside your listings.',
    'type' => 'radio',
    'group' => 'display',
    'title' => 'Show eBay Logo?',
    'default' => '1',
    'options' => [
      '1' => 'Yes',
      '0' => 'No',
    ],
  ],
  'blank' => [
    'name' => 'blank',
    'id' => 'blank',
    'tip' => 'Enabling this option will open item links in a new browser tab.',
    'type' => 'radio',
    'group' => 'display',
    'title' => 'Open Links in New Tab?',
    'default' => '0',
    'options' => [
      '1' => 'Yes',
      '0' => 'No',
    ],
  ],
  'img_size' => [
    'name' => 'img_size',
    'id' => 'img_size',
    'tip' => 'Specify in pixels the maximum image size. Depending on the image ratio, the image width or height will not exceed this size. At larger sizes, higher quality images (and therefore a larger file size) are used.',
    'tip_link' => 'https://www.auctionnudge.com/customize/appearance#image-size',
    'group' => 'display',
    'title' => 'Image Size',
    'default' => '120',
  ],
  'user_profile' => [
    'name' => 'user_profile',
    'id' => 'user_profile',
    'tip' => 'If enabled, your eBay Username, positive feedback percentage, feedback score and feedback star (if applicable) will be displayed above your listings.',

    'type' => 'radio',
    'group' => 'display',
    'title' => 'Show User Profile?',
    'default' => '0',
    'options' => [
      '1' => 'Yes',
      '0' => 'No',
    ],
  ],
  //Advanced
  'sortOrder' => [
    'name' => 'sortOrder',
    'id' => 'sortOrder',
    'tip' => 'This option adjusts the order in which items are shown.',
    'type' => 'select',
    'options' => [
      '' => 'Items Ending First',
      'StartTimeNewest' => 'Newly-Listed First',
      'PricePlusShippingLowest' => 'Price + Shipping: Lowest First',
      'PricePlusShippingHighest' => 'Price + Shipping: Highest First',
      'BestMatch' => 'Best Match',
    ],
    'group' => 'advanced',
    'title' => 'Sort Order',
  ],
  'listing_type' => [
    'name' => 'listing_type',
    'id' => 'listing_type',
    'tip' => 'Filtering by listing type allows you to choose to only display items listed as either Auction or Buy It Now. Auction listings that have the Buy It Now option available will be displayed both when filtering by Auction and Buy It Now.',
    'group' => 'advanced',
    'title' => 'Listing Type',
    'type' => 'select',
    'options' => [
      '' => 'All Listings',
      'bin_only' => 'Buy It Now Only',
      'auction_only' => 'Auction Only',
    ],
  ],
  'keyword' => [
    'name' => 'keyword',
    'id' => 'keyword',
    'tip' => 'By specifying a keyword, only items which contain that keyword in their title will be displayed. The keyword query can contain search operators, allowing for powerful searches to include/exclude certain keywords. Note: it is not possible to just use the minus sign (NOT) operator alone, another operator must be used to include items.',
    'tip_link' => 'https://www.auctionnudge.com/help/options#keyword-filter',
    'group' => 'advanced',
    'title' => 'Filter by Keyword',
  ],
  'categoryId' => [
    'name' => 'categoryId',
    'id' => 'categoryId',
    'tip' => 'By specifying an eBay category ID, only items which are listed in this category will be displayed. You can specify up to 3 different category IDs by separating with a colon (:) for example 123:456:789.',
    'tip_link' => 'https://www.auctionnudge.com/help/options#category-filter',
    'group' => 'advanced',
    'title' => 'Filter by Category ID',
  ],
];
*/
import { registerBlockType } from "@wordpress/blocks";
import { InspectorControls } from "@wordpress/block-editor";
import {
  PanelBody,
  TextControl,
  SelectControl,
  Tooltip,
} from "@wordpress/components";

// Set defaults
const default_siteid =
  typeof an_block_js.default_siteid !== "undefined"
    ? an_block_js.default_siteid
    : "0";
const default_SellerID =
  typeof an_block_js.default_SellerID !== "undefined"
    ? an_block_js.default_SellerID
    : "";

registerBlockType("your-ebay-listings/block", {
  title: "Your eBay Listings",
  icon: "cart",
  category: "widgets",
  attributes: {
    SellerID: { type: "string", default: default_SellerID },
    siteid: { type: "string", default: default_siteid },
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
            <Tooltip text="This is your eBay ID – the username you are known by on eBay and appears on your listings. This is not your store name.">
              <TextControl
                label="eBay Username"
                value={SellerID}
                onChange={(value) => setAttributes({ SellerID: value })}
              />
            </Tooltip>

            {/* siteid */}
            <Tooltip text="This is where your items are usually listed. The site you choose will determine where you link to and what currency is displayed.">
              <SelectControl
                label="eBay Site"
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
            </Tooltip>
          </PanelBody>

          {/* Step Two */}
          <PanelBody title="Display Options" initialOpen={false}>
            {/* theme */}
            <Tooltip text="Your items will display differently on your site depending on which theme you choose. You can change how these themes displaying your listings using CSS rules.">
              <SelectControl
                label="Theme"
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
            </Tooltip>

            {/* lang */}
            <Tooltip text="The language option allows you to specify which language Auction Nudge tools display on your site. This option will not modify eBay item titles, which will remain unchanged.">
              <SelectControl
                label="Language"
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
            </Tooltip>

            {/* cats_output */}
            <Tooltip text="Once enabled, a list of categories for your items (if you have items for sale in more than one category) will be displayed above your items. This allows users to filter your items by category. The categories shown are eBay categories and not custom/store categories which can not be displayed. Use the Category ID option (Advanced Options) to specify a starting category.">
              <SelectControl
                label="Category List"
                value={cats_output}
                options={[
                  { label: "Dropdown", value: "dropdown" },
                  { label: "Unstyled (advanced)", value: "unstyled" },
                  { label: "None", value: "" },
                ]}
                onChange={(value) => setAttributes({ cats_output: value })}
              />
            </Tooltip>

            {/* MaxEntries */}
            <Tooltip text="This is the number of items you want display per page, the maximum value is 100. You can display multiple pages of items using the 'show multiple pages' option below. Note: The 'Carousel' theme can load a maximum of 100 items in total, as it does not support the 'show multiple pages' option.">
              <TextControl
                label="Items per Page"
                value={MaxEntries}
                onChange={(value) => setAttributes({ MaxEntries: value })}
              />
            </Tooltip>

            {/* page */}
            <Tooltip text="If you enable this option and have more items listed than the value for the 'Items per Page' option above, users can paginate between multiple pages of items.">
              <SelectControl
                label="Show Multiple Pages?"
                value={page}
                options={[
                  { label: "Yes", value: "init" },
                  { label: "No", value: "" },
                ]}
                onChange={(value) => setAttributes({ page: value })}
              />
            </Tooltip>

            {/* search_box */}
            <Tooltip text="If enabled, a search box will appear above the items which will allow users to search all of your active eBay items. Note: Only item titles are searched, not descriptions.">
              <SelectControl
                label="Show Search Box?"
                value={search_box}
                options={[
                  { label: "Yes", value: "1" },
                  { label: "No", value: "0" },
                ]}
                onChange={(value) => setAttributes({ search_box: value })}
              />
            </Tooltip>

            {/* grid_cols */}
            <Tooltip text="Use this option to specify how many columns to display in grid view.">
              <TextControl
                label="Grid Columns"
                value={grid_cols}
                onChange={(value) => setAttributes({ grid_cols: value })}
              />
            </Tooltip>

            {/* grid_width */}
            <Tooltip text="Use this option to specify how wide the grid should be. This can be specified in either pixels (px) or as a percentage (%)">
              <TextControl
                label="Grid Width"
                value={grid_width}
                onChange={(value) => setAttributes({ grid_width: value })}
              />
            </Tooltip>

            {/* show_logo */}
            <Tooltip text="This option specifies if you want to display the eBay logo alongside your listings.">
              <SelectControl
                label="Show eBay Logo?"
                value={show_logo}
                options={[
                  { label: "Yes", value: "1" },
                  { label: "No", value: "0" },
                ]}
                onChange={(value) => setAttributes({ show_logo: value })}
              />
            </Tooltip>

            {/* blank */}
            <Tooltip text="Enabling this option will open item links in a new browser tab.">
              <SelectControl
                label="Open Links in New Tab?"
                value={blank}
                options={[
                  { label: "Yes", value: "1" },
                  { label: "No", value: "0" },
                ]}
                onChange={(value) => setAttributes({ blank: value })}
              />
            </Tooltip>

            {/* img_size */}
            <Tooltip text="Specify in pixels the maximum image size. Depending on the image ratio, the image width or height will not exceed this size. At larger sizes, higher quality images (and therefore a larger file size) are used.">
              <TextControl
                label="Image Size"
                value={img_size}
                onChange={(value) => setAttributes({ img_size: value })}
              />
            </Tooltip>

            {/* user_profile */}
            <Tooltip text="If enabled, your eBay Username, positive feedback percentage, feedback score and feedback star (if applicable) will be displayed above your listings.">
              <SelectControl
                label="Show User Profile?"
                value={user_profile}
                options={[
                  { label: "Yes", value: "1" },
                  { label: "No", value: "0" },
                ]}
                onChange={(value) => setAttributes({ user_profile: value })}
              />
            </Tooltip>
          </PanelBody>
          <PanelBody title="Advanced Options" initialOpen={false}>
            {/* sortOrder */}
            <Tooltip text="This option adjusts the order in which items are shown.">
              <SelectControl
                label="Sort Order"
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
            </Tooltip>

            {/* listing_type */}
            <Tooltip text="Filtering by listing type allows you to choose to only display items listed as either Auction or Buy It Now. Auction listings that have the Buy It Now option available will be displayed both when filtering by Auction and Buy It Now.">
              <SelectControl
                label="Listing Type"
                value={listing_type}
                options={[
                  { label: "All Listings", value: "" },
                  { label: "Buy It Now Only", value: "bin_only" },
                  { label: "Auction Only", value: "auction_only" },
                ]}
                onChange={(value) => setAttributes({ listing_type: value })}
              />
            </Tooltip>

            {/* keyword */}
            <Tooltip text="By specifying a keyword, only items which contain that keyword in their title will be displayed. The keyword query can contain search operators, allowing for powerful searches to include/exclude certain keywords. Note: it is not possible to just use the minus sign (NOT) operator alone, another operator must be used to include items.">
              <TextControl
                label="Filter by Keyword"
                value={keyword}
                onChange={(value) => setAttributes({ keyword: value })}
              />
            </Tooltip>

            {/* categoryId */}
            <Tooltip text="By specifying an eBay category ID, only items which are listed in this category will be displayed. You can specify up to 3 different category IDs by separating with a colon (:) for example 123:456:789.">
              <TextControl
                label="Filter by Category ID"
                value={categoryId}
                onChange={(value) => setAttributes({ categoryId: value })}
              />
            </Tooltip>
          </PanelBody>
        </InspectorControls>
        <div className="auction-nudge-placeholder">
          <p>
            Your eBay Listings will display here. {JSON.stringify(attributes)}
          </p>
        </div>
      </>
    );
  },
  save() {
    return null; // Rendered server-side
  },
});

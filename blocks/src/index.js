import { registerBlockType } from "@wordpress/blocks";
import { InspectorControls } from "@wordpress/block-editor";
import { PanelBody, TextControl, SelectControl } from "@wordpress/components";

registerBlockType("your-ebay-listings/block", {
    title: "Your eBay Listings",
    icon: "cart",
    category: "widgets",
    attributes: {
        sellerID: { type: "string", default: "" },
        siteID: { type: "string", default: "0" },
        theme: { type: "string", default: "responsive" },
        language: { type: "string", default: "english" },
        sortOrder: { type: "string", default: "" },
    },
    edit({ attributes, setAttributes }) {
        const { sellerID, siteID, theme, language, sortOrder } = attributes;

        return (
            <>
                <InspectorControls>
                    <PanelBody title="Feed Options">
                        <TextControl
                            label="eBay Username"
                            value={sellerID}
                            onChange={(value) =>
                                setAttributes({ sellerID: value })
                            }
                        />
                        <SelectControl
                            label="eBay Site"
                            value={siteID}
                            options={[
                                { label: "eBay US", value: "0" },
                                { label: "eBay UK", value: "3" },
                                // Add more sites as needed
                            ]}
                            onChange={(value) =>
                                setAttributes({ siteID: value })
                            }
                        />
                    </PanelBody>
                    <PanelBody title="Display Options">
                        <SelectControl
                            label="Theme"
                            value={theme}
                            options={[
                                { label: "Responsive", value: "responsive" },
                                { label: "Grid View", value: "grid" },
                                // Add more themes as needed
                            ]}
                            onChange={(value) =>
                                setAttributes({ theme: value })
                            }
                        />
                        <SelectControl
                            label="Language"
                            value={language}
                            options={[
                                { label: "English", value: "english" },
                                { label: "French", value: "french" },
                                // Add more languages as needed
                            ]}
                            onChange={(value) =>
                                setAttributes({ language: value })
                            }
                        />
                    </PanelBody>
                    <PanelBody title="Advanced Options">
                        <SelectControl
                            label="Sort Order"
                            value={sortOrder}
                            options={[
                                { label: "Items Ending First", value: "" },
                                {
                                    label: "Newly-Listed First",
                                    value: "StartTimeNewest",
                                },
                                // Add more sort orders as needed
                            ]}
                            onChange={(value) =>
                                setAttributes({ sortOrder: value })
                            }
                        />
                    </PanelBody>
                </InspectorControls>
                <div className="auction-nudge-placeholder">
                    <p>
                        Your eBay Listings will display here.{" "}
                        {JSON.stringify(attributes)}
                    </p>
                </div>
            </>
        );
    },
    save() {
        return null; // Rendered server-side
    },
});

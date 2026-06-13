/**
 * Asset Module Setup Configuration
 *
 * This file contains all configuration for the Asset module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "Asset";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "asset",
    store_prefix: "asset",
    route_prefix: "Asset",
    route_path: "asset",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "asset-view",
        details: "asset-details",
        create: "asset-create",
        edit: "asset-edit",
        delete: "asset-delete",
        import: "asset-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "assets",

    // Field Selection for API requests
    select_fields: [
        "id",
        "title",
            "asset_category_id",
            "description",
            "price",
            "memo_no",
            "memo_date",
            "code",
            "asset_location",
            "asset_owner",
            "owner_phone_number",
            "depreciation_amount",
            "depreciation_type",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "title",
            "asset_category_id",
            "description",
            "price",
            "memo_no",
            "memo_date",
            "code",
            "asset_location",
            "asset_owner",
            "owner_phone_number",
            "depreciation_amount",
            "depreciation_type",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "title",
            "asset_category_id",
            "description",
            "price",
            "memo_no",
            "memo_date",
            "code",
            "asset_location",
            "asset_owner",
            "owner_phone_number",
            "depreciation_amount",
            "depreciation_type",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "title",
            "asset_category_id",
            "description",
            "price",
            "memo_no",
            "memo_date",
            "code",
            "asset_location",
            "asset_owner",
            "owner_phone_number",
            "depreciation_amount",
            "depreciation_type",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "title",
            "asset_category_id",
            "description",
            "price",
            "memo_no",
            "memo_date",
            "code",
            "asset_location",
            "asset_owner",
            "owner_phone_number",
            "depreciation_amount",
            "depreciation_type",
        "status",
        "created_at",
    ],

    // UI Labels and Titles
    layout_title: prefix + " Management",
    page_title: `${prefix} Management`,
    all_page_title: "All " + prefix,
    details_page_title: "Details " + prefix,
    create_page_title: "Create " + prefix,
    edit_page_title: "Edit " + prefix,
};

export default setup;

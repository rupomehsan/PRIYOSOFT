/**
 * AssetRequestToCp Module Setup Configuration
 *
 * This file contains all configuration for the AssetRequestToCp module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "AssetRequestToCp";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "asset-request-to-cp",
    store_prefix: "asset-request-to-cp",
    route_prefix: "AssetRequestToCp",
    route_path: "asset-request-to-cp",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "asset-request-to-cp-view",
        details: "asset-request-to-cp-details",
        create: "asset-request-to-cp-create",
        edit: "asset-request-to-cp-edit",
        delete: "asset-request-to-cp-delete",
        import: "asset-request-to-cp-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "asset-request-to-cps",

    // Field Selection for API requests
    select_fields: [
        "id",
        "central_branch_id",
            "asset_quotation_id",
            "title",
            "description",
            "is_approved",
            "request_type",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "central_branch_id",
            "asset_quotation_id",
            "title",
            "description",
            "is_approved",
            "request_type",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "central_branch_id",
            "asset_quotation_id",
            "title",
            "description",
            "is_approved",
            "request_type",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "central_branch_id",
            "asset_quotation_id",
            "title",
            "description",
            "is_approved",
            "request_type",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "central_branch_id",
            "asset_quotation_id",
            "title",
            "description",
            "is_approved",
            "request_type",
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

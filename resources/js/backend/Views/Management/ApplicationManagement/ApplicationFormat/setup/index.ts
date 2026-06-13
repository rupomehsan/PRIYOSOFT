/**
 * ApplicationFormat Module Setup Configuration
 *
 * This file contains all configuration for the ApplicationFormat module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "ApplicationFormat";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "application-format",
    store_prefix: "application-format",
    route_prefix: "ApplicationFormat",
    route_path: "application-format",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "application-format-view",
        details: "application-format-details",
        create: "application-format-create",
        edit: "application-format-edit",
        delete: "application-format-delete",
        import: "application-format-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "application-formats",

    // Field Selection for API requests
    select_fields: [
        "id",
        "application_category_id",
            "field_name",
            "field_type",
            "pdf_format",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "application_category_id",
            "field_name",
            "field_type",
            "pdf_format",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "application_category_id",
            "field_name",
            "field_type",
            "pdf_format",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "application_category_id",
            "field_name",
            "field_type",
            "pdf_format",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "application_category_id",
            "field_name",
            "field_type",
            "pdf_format",
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

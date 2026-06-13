/**
 * ExpenseCategory Module Setup Configuration
 *
 * This file contains all configuration for the ExpenseCategory module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "ExpenseCategory";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "expense-category",
    store_prefix: "expense-category",
    route_prefix: "ExpenseCategory",
    route_path: "expense-category",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "expense-category-view",
        details: "expense-category-details",
        create: "expense-category-create",
        edit: "expense-category-edit",
        delete: "expense-category-delete",
        import: "expense-category-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "expense-categories",

    // Field Selection for API requests
    select_fields: [
        "id",
        "name",
            "description",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "name",
            "description",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "name",
            "description",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "name",
            "description",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "name",
            "description",
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

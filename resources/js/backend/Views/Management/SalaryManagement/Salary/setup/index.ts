/**
 * Salary Module Setup Configuration
 *
 * This file contains all configuration for the Salary module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "Salary";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "salary",
    store_prefix: "salary",
    route_prefix: "Salary",
    route_path: "salary",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "salary-view",
        details: "salary-details",
        create: "salary-create",
        edit: "salary-edit",
        delete: "salary-delete",
        import: "salary-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "salaries",

    // Field Selection for API requests
    select_fields: [
        "id",
        "salary_sheet_id",
            "staff_id",
            "transaction_log_id",
            "amount",
            "amount_in_text",
            "given_by",
            "date",
            "attachment",
            "description",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "salary_sheet_id",
            "staff_id",
            "transaction_log_id",
            "amount",
            "amount_in_text",
            "given_by",
            "date",
            "attachment",
            "description",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "salary_sheet_id",
            "staff_id",
            "transaction_log_id",
            "amount",
            "amount_in_text",
            "given_by",
            "date",
            "attachment",
            "description",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "salary_sheet_id",
            "staff_id",
            "transaction_log_id",
            "amount",
            "amount_in_text",
            "given_by",
            "date",
            "attachment",
            "description",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "salary_sheet_id",
            "staff_id",
            "transaction_log_id",
            "amount",
            "amount_in_text",
            "given_by",
            "date",
            "attachment",
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

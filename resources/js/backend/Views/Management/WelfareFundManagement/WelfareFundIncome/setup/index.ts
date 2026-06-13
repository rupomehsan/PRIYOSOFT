/**
 * WelfareFundIncome Module Setup Configuration
 *
 * This file contains all configuration for the WelfareFundIncome module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "WelfareFundIncome";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "welfare-fund-income",
    store_prefix: "welfare-fund-income",
    route_prefix: "WelfareFundIncome",
    route_path: "welfare-fund-income",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "welfare-fund-income-view",
        details: "welfare-fund-income-details",
        create: "welfare-fund-income-create",
        edit: "welfare-fund-income-edit",
        delete: "welfare-fund-income-delete",
        import: "welfare-fund-income-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "welfare-fund-incomes",

    // Field Selection for API requests
    select_fields: [
        "id",
        "transaction_log_id",
            "welfare_fund_income_type_id",
            "income_source_type",
            "branch_id",
            "user_id",
            "well_wisher_id",
            "others",
            "date",
            "amount",
            "amount_in_text",
            "account_group_id",
            "account_id",
            "description",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "transaction_log_id",
            "welfare_fund_income_type_id",
            "income_source_type",
            "branch_id",
            "user_id",
            "well_wisher_id",
            "others",
            "date",
            "amount",
            "amount_in_text",
            "account_group_id",
            "account_id",
            "description",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "transaction_log_id",
            "welfare_fund_income_type_id",
            "income_source_type",
            "branch_id",
            "user_id",
            "well_wisher_id",
            "others",
            "date",
            "amount",
            "amount_in_text",
            "account_group_id",
            "account_id",
            "description",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "transaction_log_id",
            "welfare_fund_income_type_id",
            "income_source_type",
            "branch_id",
            "user_id",
            "well_wisher_id",
            "others",
            "date",
            "amount",
            "amount_in_text",
            "account_group_id",
            "account_id",
            "description",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "transaction_log_id",
            "welfare_fund_income_type_id",
            "income_source_type",
            "branch_id",
            "user_id",
            "well_wisher_id",
            "others",
            "date",
            "amount",
            "amount_in_text",
            "account_group_id",
            "account_id",
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

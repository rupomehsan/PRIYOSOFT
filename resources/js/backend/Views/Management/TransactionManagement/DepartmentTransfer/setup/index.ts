/**
 * DepartmentTransfer Module Setup Configuration
 *
 * This file contains all configuration for the DepartmentTransfer module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "DepartmentTransfer";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "department-transfer",
    store_prefix: "department-transfer",
    route_prefix: "DepartmentTransfer",
    route_path: "department-transfer",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "department-transfer-view",
        details: "department-transfer-details",
        create: "department-transfer-create",
        edit: "department-transfer-edit",
        delete: "department-transfer-delete",
        import: "department-transfer-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "department-transfers",

    // Field Selection for API requests
    select_fields: [
        "id",
        "transfer_type",
            "department_id",
            "amount",
            "date",
            "description",
            "approval_status",
            "approved_by",
            "approved_at",
            "rejection_reason",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "transfer_type",
            "department_id",
            "amount",
            "date",
            "description",
            "approval_status",
            "approved_by",
            "approved_at",
            "rejection_reason",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "transfer_type",
            "department_id",
            "amount",
            "date",
            "description",
            "approval_status",
            "approved_by",
            "approved_at",
            "rejection_reason",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "transfer_type",
            "department_id",
            "amount",
            "date",
            "description",
            "approval_status",
            "approved_by",
            "approved_at",
            "rejection_reason",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "transfer_type",
            "department_id",
            "amount",
            "date",
            "description",
            "approval_status",
            "approved_by",
            "approved_at",
            "rejection_reason",
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

/**
 * VoucherAudit Module Setup Configuration
 *
 * This file contains all configuration for the VoucherAudit module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "VoucherAudit";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "voucher-audit",
    store_prefix: "voucher-audit",
    route_prefix: "VoucherAudit",
    route_path: "voucher-audit",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "voucher-audit-view",
        details: "voucher-audit-details",
        create: "voucher-audit-create",
        edit: "voucher-audit-edit",
        delete: "voucher-audit-delete",
        import: "voucher-audit-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "voucher-audits",

    // Field Selection for API requests
    select_fields: [
        "id",
        "title",
            "description",
            "auditor_id",
            "audit_period_start",
            "audit_period_end",
            "audit_status",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "title",
            "description",
            "auditor_id",
            "audit_period_start",
            "audit_period_end",
            "audit_status",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "title",
            "description",
            "auditor_id",
            "audit_period_start",
            "audit_period_end",
            "audit_status",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "title",
            "description",
            "auditor_id",
            "audit_period_start",
            "audit_period_end",
            "audit_status",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "title",
            "description",
            "auditor_id",
            "audit_period_start",
            "audit_period_end",
            "audit_status",
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

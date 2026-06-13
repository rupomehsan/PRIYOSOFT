/**
 * VoucherAuditItem Module Setup Configuration
 *
 * This file contains all configuration for the VoucherAuditItem module including:
 * - API endpoints and versioning
 * - Field configurations for tables and forms
 * - Route and permission settings
 * - UI labels and titles
 *
 * Generated automatically - Modifications will be preserved if regenerated
 */

import app_config from "@config/app_config";
import setup_type from "@/shared/setup/setup_type";

const prefix: string = "VoucherAuditItem";

const setup: setup_type = {
    // Module Identity
    prefix,
    module_name: "voucher-audit-item",
    store_prefix: "voucher-audit-item",
    route_prefix: "VoucherAuditItem",
    route_path: "voucher-audit-item",

    // Permission Configuration
    permission: ["admin", "super_admin"],
    permission_slugs: {
        view: "voucher-audit-item-view",
        details: "voucher-audit-item-details",
        create: "voucher-audit-item-create",
        edit: "voucher-audit-item-edit",
        delete: "voucher-audit-item-delete",
        import: "voucher-audit-item-import",
    },

    // API Configuration
    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "voucher-audit-items",

    // Field Selection for API requests
    select_fields: [
        "id",
        "voucher_audit_id",
            "voucher_type",
            "voucher_id",
            "income_verified",
            "expense_verified",
            "document_verified",
            "approval_history_verified",
            "related_record_verified",
            "is_ok",
            "comment",
            "audited_by",
            "audited_at",
        "status",
        "slug",
        "created_at",
        "deleted_at"
    ],

    // Available columns for sorting
    sort_by_cols: [
        "id",
        "voucher_audit_id",
            "voucher_type",
            "voucher_id",
            "income_verified",
            "expense_verified",
            "document_verified",
            "approval_history_verified",
            "related_record_verified",
            "is_ok",
            "comment",
            "audited_by",
            "audited_at",
        "status",
        "created_at",
    ],

    // Table header columns (shown in list view)
    table_header_data: [
        "id",
        "voucher_audit_id",
            "voucher_type",
            "voucher_id",
            "income_verified",
            "expense_verified",
            "document_verified",
            "approval_history_verified",
            "related_record_verified",
            "is_ok",
            "comment",
            "audited_by",
            "audited_at",
        "status",
        "created_at",
    ],

    // Table row data fields (rendered in list view)
    table_row_data: [
        "id",
        "voucher_audit_id",
            "voucher_type",
            "voucher_id",
            "income_verified",
            "expense_verified",
            "document_verified",
            "approval_history_verified",
            "related_record_verified",
            "is_ok",
            "comment",
            "audited_by",
            "audited_at",
        "status",
        "created_at",
    ],

    // Quick view modal data fields
    quick_view_data: [
        "id",
        "voucher_audit_id",
            "voucher_type",
            "voucher_id",
            "income_verified",
            "expense_verified",
            "document_verified",
            "approval_history_verified",
            "related_record_verified",
            "is_ok",
            "comment",
            "audited_by",
            "audited_at",
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

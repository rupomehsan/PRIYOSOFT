/**
 * Form Fields Configuration
 * Auto-generated — edit data_list / class / is_visible as needed.
 */

export default [
	{
		name: "product_group_id",
		label: "Select Product Group",
		type: "select",
		multiple: false,
		data_list: [],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "name",
		label: "Enter Name",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},

	
	{
		name: "project_status",
		label: "Project Status",
		type: "select",
		multiple: false,
		data_list: [
			{ label: "Planning",    value: "planning"    },
			{ label: "Development", value: "development" },
			{ label: "Active",      value: "active"      },
			{ label: "Paused",      value: "paused"      },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	
	{
		name: "launch_date",
		label: "Enter Launch Date",
		type: "date",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "monthly_target_revenue",
		label: "Enter Monthly Target Revenue",
		type: "number",
		step: "0.01",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "regular_price",
		label: "Regular Price",
		type: "number",
		step: "0.01",
		placeholder: "0.00",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "sales_price",
		label: "Sales Price",
		type: "number",
		step: "0.01",
		placeholder: "0.00",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	
	
	{
		name: "promo_link",
		label: "Demo / Website Link",
		type: "text",
		placeholder: "https://demo.example.com/...",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "video_url",
		label: "YouTube Video URL",
		type: "text",
		placeholder: "https://www.youtube.com/watch?v=...",
		value: "",
		is_visible: true,
		class: "col-md-12",
	},
	{
		name: "screenshots",
		label: "Upload Screenshots",
		type: "file",
		multiple: true,
		accept: "image/*",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "thumbnail",
		label: "Upload Thumbnail",
		type: "file",
		multiple: false,
		accept: "image/*",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	// features is handled via a custom add/remove UI in Form.vue (not via common-input)
	{
		name: "description",
		label: "Enter Description",
		type: "textarea",
		rows: 4,
		value: "",
		is_visible: true,
		class: "col-md-12",
	},
];

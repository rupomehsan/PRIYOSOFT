/**
 * Form Fields Configuration
 * features and stats handled via custom JSON UI in All.vue
 */

export default [
  {
    name: "badge_label",
    label: "Enter Badge Label",
    type: "text",
    value: "",
    is_visible: true,
    class: "col-md-6",
  },
  {
    name: "title",
    label: "Enter Title",
    type: "text",
    value: "",
    is_visible: true,
    class: "col-md-6",
  },
  {
    name: "description",
    label: "Enter Description",
    type: "textarea",
    rows: 4,
    value: "",
    is_visible: true,
    class: "col-md-12",
  },
  {
    name: "image",
    label: "Upload Image",
    type: "file",
    multiple: false,
    accept: "image/*",
    value: "",
    is_visible: true,
    class: "col-md-6",
  },
  {
    name: "sort_order",
    label: "Sort Order",
    type: "number",
    step: "1",
    value: "",
    is_visible: true,
    class: "col-md-3",
  },
  {
    name: "is_visible",
    label: "Is Visible",
    type: "select",
    multiple: false,
    data_list: [
      { label: "Yes", value: "1" },
      { label: "No",  value: "0" },
    ],
    value: "",
    is_visible: true,
    class: "col-md-3",
  },
];

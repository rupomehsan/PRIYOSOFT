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
    name: "description",
    label: "Enter Description",
    type: "textarea",
    rows: 4,
    value: "",
    is_visible: true,
    class: "col-md-12",
  },
];

import { defineStore } from 'pinia';

export const theme_store = defineStore('theme_store', {
  state: () => ({ dark: true }),
  actions: {
    toggle() {
      this.dark = !this.dark;
      this._apply();
    },
    init() {
      const saved = localStorage.getItem('ps_theme');
      this.dark = saved !== 'light';
      this._apply();
    },
    _apply() {
      const t = this.dark ? 'dark' : 'light';
      localStorage.setItem('ps_theme', t);
      document.documentElement.setAttribute('data-theme', t);
    },
  },
});

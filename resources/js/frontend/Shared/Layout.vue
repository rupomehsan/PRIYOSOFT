<template>
  <div id="app">
    <Header />
    <main class="main-wrapper">
      <slot />
    </main>
    <Footer />
  </div>
</template>

<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import { theme_store } from '../GlobalStore/theme_store';
export default {
  name: "Layout",
  components: { Header, Footer },
  mounted() { theme_store().init(); },
};
</script>

<style>
html {
  scroll-behavior: smooth;
  scroll-padding-top: 72px;
}
</style>

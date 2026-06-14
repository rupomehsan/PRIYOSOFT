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
export default {
  name: "Layout",
  components: { Header, Footer },
};
</script>

<style>
html {
  scroll-behavior: smooth;
  scroll-padding-top: 72px;
}
</style>

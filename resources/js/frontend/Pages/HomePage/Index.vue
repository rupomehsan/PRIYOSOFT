<template>
  <div class="portfolio-page">
    <!-- Ambient floating orbs — purely decorative -->
    <div class="ps-global-orbs" aria-hidden="true">
      <div class="ps-orb ps-orb--1 ps-pulse-orb"></div>
      <div class="ps-orb ps-orb--2 ps-float-b"></div>
      <div class="ps-orb ps-orb--3 ps-float-a"></div>
      <div class="ps-orb ps-orb--4 ps-float-c"></div>
    </div>

    <HeroSection :slides="heroSlides" />
    <StatsSection :data="aboutSections" :loading="loadingAbout" />
    <ProductsSection :data="products" :loading="loadingProducts" />
    <WhoWeAreSection :data="whoWeAre" :loading="loadingWhoWeAre" />
    <CoreValuesSection :data="aboutSections" :whoWeAre="whoWeAre" :loading="loadingAbout || loadingWhoWeAre" />
    <TestimonialsSection :data="testimonials" :loading="loadingTestimonials" />
    <BlogSection :data="blogPosts" :loading="loadingBlog" />
    <FaqSection :data="faqs" :loading="loadingFaq" />
    <NewsletterSection :loading="newsletterLoading" :success="newsletterSuccess" :error="newsletterError" @subscribe="onSubscribe" />
  </div>
</template>

<script>
import { store as useHomeStore } from "./Store";
import { mapState, mapActions } from "pinia";

import HeroSection from "./Components/HeroSection.vue";
import StatsSection from "./Components/StatsSection.vue";
import ProductsSection from "./Components/ProductsSection.vue";
import WhoWeAreSection from "./Components/WhoWeAreSection.vue";
import CoreValuesSection from "./Components/CoreValuesSection.vue";
import AboutSection from "./Components/AboutSection.vue";
import TeamSection from "./Components/TeamSection.vue";
import TestimonialsSection from "./Components/TestimonialsSection.vue";
import BlogSection from "./Components/BlogSection.vue";
import FaqSection from "./Components/FaqSection.vue";
import NewsletterSection from "./Components/NewsletterSection.vue";

import "./Css/Style.css";
import "./Css/Animations.css";

export default {
  name: "HomePage",
  components: {
    HeroSection,
    StatsSection,
    ProductsSection,
    WhoWeAreSection,
    CoreValuesSection,
    AboutSection,
    TeamSection,
    TestimonialsSection,
    BlogSection,
    FaqSection,
    NewsletterSection,
  },
  computed: {
    ...mapState(useHomeStore, [
      "heroSlides",
      "products",
      "teamMembers",
      "testimonials",
      "blogPosts",
      "faqs",
      "aboutSections",
      "whoWeAre",
      "newsletterLoading",
      "newsletterSuccess",
      "newsletterError",
      "loadingProducts",
      "loadingAbout",
      "loadingWhoWeAre",
      "loadingTestimonials",
      "loadingBlog",
      "loadingFaq",
    ]),
  },
  watch: {
    // When any section's data arrives, immediately resolve visibility
    // for its newly-rendered .animate elements on the next DOM tick.
    loadingProducts(v) {
      if (!v) this.$nextTick(this._resolveVisible);
    },
    loadingAbout(v) {
      if (!v) this.$nextTick(this._resolveVisible);
    },
    loadingWhoWeAre(v) {
      if (!v) this.$nextTick(this._resolveVisible);
    },
    loadingTestimonials(v) {
      if (!v) this.$nextTick(this._resolveVisible);
    },
    loadingBlog(v) {
      if (!v) this.$nextTick(this._resolveVisible);
    },
    loadingFaq(v) {
      if (!v) this.$nextTick(this._resolveVisible);
    },
  },
  methods: {
    ...mapActions(useHomeStore, ["fetchAllPortfolioData", "subscribeNewsletter"]),
    onSubscribe(payload) { this.subscribeNewsletter(payload); },

    // Mark all .animate elements that are ALREADY in the viewport right now
    // without waiting for the async IntersectionObserver callback.
    // Elements below the fold are registered with the observer instead.
    _resolveVisible() {
      const vh = window.innerHeight;
      document.querySelectorAll('.animate:not([data-anim="in"])').forEach((el) => {
        const r = el.getBoundingClientRect();
        if (r.top < vh + 80 && r.bottom > -80) {
          // In viewport — mark synchronously so there is zero blank flash
          el.setAttribute("data-anim", "in");
          const bar = el.querySelector(".anim-underline");
          if (bar) bar.setAttribute("data-anim", "in");
        } else if (this._io) {
          this._io.observe(el);
        }
      });
      document.querySelectorAll('.anim-underline:not([data-anim="in"])').forEach((el) => {
        const r = el.getBoundingClientRect();
        if (r.top < vh && r.bottom > 0) {
          el.setAttribute("data-anim", "in");
        } else if (this._ioLine) {
          this._ioLine.observe(el);
        }
      });
    },

    _initScrollAnimations() {
      this._io = new IntersectionObserver(
        (entries) => {
          entries.forEach(({ target, isIntersecting }) => {
            if (!isIntersecting) return;
            target.setAttribute("data-anim", "in");
            const bar = target.querySelector(".anim-underline");
            if (bar) bar.setAttribute("data-anim", "in");
            this._io.unobserve(target);
          });
        },
        { threshold: 0.06, rootMargin: "0px 0px -40px 0px" },
      );

      this._ioLine = new IntersectionObserver(
        (entries) => {
          entries.forEach(({ target, isIntersecting }) => {
            if (isIntersecting) {
              target.setAttribute("data-anim", "in");
              this._ioLine.unobserve(target);
            }
          });
        },
        { threshold: 0.15 },
      );

      // Initial pass: resolve anything already in view, queue the rest
      this._resolveVisible();
      // Re-run a few times to catch async-rendered elements
      [400, 1000, 2200].forEach((t) => setTimeout(this._resolveVisible, t));
    },
  },
  mounted() {
    this.fetchAllPortfolioData();
    this.$nextTick(this._initScrollAnimations);
  },
  beforeUnmount() {
    if (this._io) this._io.disconnect();
    if (this._ioLine) this._ioLine.disconnect();
  },
};
</script>

<style scoped>
.portfolio-page {
  position: relative;
  overflow-x: hidden;
}

/* Global ambient orbs */
.ps-global-orbs {
  position: fixed;
  inset: 0;
  pointer-events: none;
  z-index: 0;
  overflow: hidden;
}
.ps-orb {
  position: absolute;
  border-radius: 50%;
  filter: blur(90px);
}
.ps-orb--1 {
  width: 600px;
  height: 600px;
  background: rgba(99, 102, 241, 0.07);
  top: -10%;
  left: -8%;
}
.ps-orb--2 {
  width: 500px;
  height: 500px;
  background: rgba(168, 85, 247, 0.06);
  top: 40%;
  right: -6%;
}
.ps-orb--3 {
  width: 400px;
  height: 400px;
  background: rgba(6, 182, 212, 0.05);
  bottom: 20%;
  left: 15%;
}
.ps-orb--4 {
  width: 300px;
  height: 300px;
  background: rgba(245, 158, 11, 0.05);
  top: 70%;
  right: 25%;
}
</style>

<template>
  <div class="portfolio-page">
    <HeroSection :slides="heroSlides" />
    <StatsSection :data="aboutSections" />
    <ProductsSection :data="products" />
    <WhoWeAreSection :data="whoWeAre" />
    <CoreValuesSection :data="aboutSections" :whoWeAre="whoWeAre" />
    <TestimonialsSection :data="testimonials" />
    <BlogSection :data="blogPosts" />
    <FaqSection :data="faqs" />
    <NewsletterSection
      :loading="newsletterLoading"
      :success="newsletterSuccess"
      :error="newsletterError"
      @subscribe="onSubscribe"
    />
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
    ]),
  },
  methods: {
    ...mapActions(useHomeStore, [
      "fetchAllPortfolioData",
      "subscribeNewsletter",
    ]),
    onSubscribe(payload) {
      this.subscribeNewsletter(payload);
    },
  },
  mounted() {
    this.fetchAllPortfolioData();
  },
};
</script>

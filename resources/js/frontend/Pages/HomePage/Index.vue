<template>
  <div class="portfolio-page">
    <HeroSection       :data="heroSection" />
    <StatsSection      :data="aboutSections" />
    <ProductsSection   :data="products" />
    <AboutSection      :data="aboutSections" />
    <TeamSection       :data="teamMembers" />
    <TestimonialsSection :data="testimonials" />
    <BlogSection       :data="blogPosts" />
    <FaqSection        :data="faqs" />
    <NewsletterSection
      :loading="newsletterLoading"
      :success="newsletterSuccess"
      :error="newsletterError"
      @subscribe="onSubscribe"
    />
  </div>
</template>

<script>
import { store as useHomeStore } from './Store';
import { mapState, mapActions }  from 'pinia';

import HeroSection         from './Components/HeroSection.vue';
import StatsSection        from './Components/StatsSection.vue';
import ProductsSection     from './Components/ProductsSection.vue';
import AboutSection        from './Components/AboutSection.vue';
import TeamSection         from './Components/TeamSection.vue';
import TestimonialsSection from './Components/TestimonialsSection.vue';
import BlogSection         from './Components/BlogSection.vue';
import FaqSection          from './Components/FaqSection.vue';
import NewsletterSection   from './Components/NewsletterSection.vue';

import './Css/Style.css';

export default {
  name: 'HomePage',
  components: {
    HeroSection, StatsSection, ProductsSection, AboutSection,
    TeamSection, TestimonialsSection, BlogSection, FaqSection, NewsletterSection,
  },
  computed: {
    ...mapState(useHomeStore, [
      'heroSection', 'products', 'teamMembers', 'testimonials',
      'blogPosts', 'faqs', 'aboutSections',
      'newsletterLoading', 'newsletterSuccess', 'newsletterError',
    ]),
  },
  methods: {
    ...mapActions(useHomeStore, ['fetchAllPortfolioData', 'subscribeNewsletter']),
    onSubscribe(payload) { this.subscribeNewsletter(payload); },
  },
  mounted() { this.fetchAllPortfolioData(); },
};
</script>

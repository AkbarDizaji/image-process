<template>
  <div id="app">
    <image-search-form @images-processed="handleImagesProcessed"></image-search-form>
    <image-list v-if="processedImages.length" :images="processedImages" :is-loading="isLoadingImages"></image-list>

  </div>
</template>

<script>
import ImageSearchForm from './components/ImageSearchForm.vue';
import ImageList from './components/ImageList.vue';
import axios from 'axios';

export default {
  components: {
    ImageSearchForm,
    ImageList
  },
  methods: {
    async handleImagesProcessed() {
      try {
        this.isLoadingImages = true; // Set loading state to true
        const response = await axios.get('http://localhost:8000/api/getimages');
        this.processedImages = response.data;
      } catch (error) {
        console.error('Error fetching processed images:', error);
      }
      finally {
        this.isLoadingImages = false; // Set loading state to false
      }
    }
  },
  data() {
    return {
      processedImages: [],
      isLoading: false,
      toast: null
    }
  },
  created() {
    this.handleImagesProcessed();
  }
}
</script>

<style scoped>
#app {
  display: flex;
  flex-direction: column;
  align-items: center;
  max-width: 800px;
  margin: 0 auto;
}
</style>
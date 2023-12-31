<template>
  <div>
    <div v-if="images && images.length">
      <h2>Processed Images</h2>
      <div class="image-grid">
        <div v-for="image in images" :key="image.id" class="image-container">
          <img :src="getImageUrl(image.image_data)" alt="Processed Image">
        </div>
      </div>
    </div>

    <div v-if="isLoading">
      <p>Loading images...</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
  images: {
    type: Array,
    default: () => []
  },
  isLoading: {
    type: Boolean,
    default: false
  }
},
  // data() {
  //   return {
  //     images: []
  //   };
  // },
  created() {
    console.log('Component created!');
    this.fetchImages();

  },

  methods: {
    async fetchImages() {
      console.log("zzz");

      try {
        console.log("s");
        const response = await axios.get('http://localhost:8000/api/getimages');
        this.$emit('update:images', response.data);

        // this.images = response.data;
      } catch (error) {
        console.error('Error fetching images:', error);
      }
    },
    getImageUrl(imageData) {
      return `data:image/png;base64,${imageData}`;
    }
  }
};
</script>

<style scoped>
h2 {
  font-size: 20px;
  margin-top: 20px;
}

.image-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 10px;
  margin-top: 10px;
}

.image-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 200px;
  border-radius: 4px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: opacity 0.3s, transform 0.3s;
}

.image-container:hover {
  opacity: 0.8;
  transform: scale(1.1);
}

.image-container img {
  max-width: 100%;
  max-height: 100%;
  object-fit: cover;
}
</style>
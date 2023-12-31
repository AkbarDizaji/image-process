<template>
  <div class="image-search-container">
    <h1 class="image-search-title">Image Search</h1>
    <form @submit.prevent="submitForm" class="image-search-form">
      <div class="form-group">
        <label for="query" class="form-label">Search Query:</label>
        <input
          type="text"
          id="query"
          v-model="formData.query"
          required
          class="form-input"
        />
      </div>
      <div class="form-group">
        <label for="maxImages" class="form-label">Max Images:</label>
        <input
          type="number"
          id="maxImages"
          v-model.number="formData.max_images"
          required
          class="form-input"
        />
      </div>
      <div class="form-group">
        <button type="submit" :disabled="isLoading" class="submit-button">
          <div v-if="isLoading" class="loader-container">
            <pulse-loader :loading="isLoading" :size="size"></pulse-loader>
          </div>
          <div v-else>Search</div>
        </button>
      </div>
    </form>
    <div class="toast-container">
      <div
        v-for="message in toast.messages"
        :key="message.id"
        class="toast"
        :class="message.type"
      >
        {{ message.content }}
      </div>
    </div>
  </div>
</template>
<script>
import PulseLoader from "vue-spinner/src/PulseLoader.vue";
import { useToast } from "vue-toastification";
import "vue-toastification/dist/index.css";
import axios from "axios";
export default {
  components: { PulseLoader },
  data() {
    return {
      formData: { query: "aa", max_images: 10 },
      isLoading: false,
      toast: null,
    };
  },
  created() {
    this.toast = useToast();
  },
  methods: {
    async submitForm() {
      this.isLoading = true;
      try {
        const response = await axios.post(
          "http://localhost:8000/api/process-images",
          this.formData
        );
        console.log(response);
        this.$emit("images-processed", response.data);
        this.toast.success("Images processed successfully!");
      } catch (error) {
        console.error("There was an error processing your request:", error);
        this.toast.error("Error processing images.");
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>
<style scoped>
.image-search-container {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f4f4f4;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.image-search-title {
  font-size: 24px;
  margin-bottom: 20px;
  text-align: center;
}
.image-search-form {
  margin-bottom: 30px;
}
.form-group {
  margin-bottom: 15px;
}
.form-label {
  font-weight: bold;
  margin-bottom: 5px;
}
.form-input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
}
.submit-button {
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width: 100%;
  transition: background-color 0.3s ease;
}
.submit-button:hover {
  background-color: #0056b3;
}
.loader-container {
  display: flex;
  justify-content: center;
  align-items: center;
}
.toast-container {
  margin-top: 20px;
}
.toast {
  margin-bottom: 10px;
  padding: 10px;
  border-radius: 4px;
  color: #fff;
}
.toast.success {
  background-color: green;
}
.toast.error {
  background-color: red;
}
</style>

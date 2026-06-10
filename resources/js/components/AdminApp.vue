<template>
  <section class="admin-vue-widget" aria-live="polite">
    <div class="admin-vue-card">
      <h2>Admin Vue App aktif!</h2>
      <p>Ini adalah root Vue component untuk halaman admin.</p>
      <button type="button" @click="increment">Klik saya: {{ count }}</button>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';
const count = ref(0);
function increment() {
  count.value += 1;
}
</script>

<style scoped>
.admin-vue-card {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  padding: 1.5rem;
  box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
  margin-bottom: 1.5rem;
}

.admin-vue-card h2 {
  margin-bottom: 0.5rem;
  font-size: 1.125rem;
}

.admin-vue-card p {
  margin-bottom: 1rem;
  color: #475569;
}

.admin-vue-card button {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1rem;
  border: 1px solid #cbd5e1;
  border-radius: 9999px;
  background: #f8fafc;
  color: #0f172a;
  cursor: pointer;
  transition: background 0.2s ease;
}

.admin-vue-card button:hover {
  background: #e2e8f0;
}
</style>

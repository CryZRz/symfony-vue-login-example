<template>
  <ListNotes/>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import ListNotes from '@/components/ListNotes.vue';

export default defineComponent({
  name: 'HomeView',
  components: {
    ListNotes
},
});
</script>

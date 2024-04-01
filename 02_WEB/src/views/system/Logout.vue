<script setup lang="ts">
import { useRouter } from 'vue-router'

const router = useRouter()
localStorage.removeItem('token')
localStorage.removeItem('tokenTimeout')
router.push({
  name: 'Login'
})
</script>

<template>
  <div></div>
</template>

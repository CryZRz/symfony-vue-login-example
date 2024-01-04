<template lang="">
    <div>
        <button 
            class="bg-red-600 text-white font-bold p-1 rounded-md"
            @click="sendLogut"
        >
            Cerrar sesion
        </button>
    </div>
</template>

<script lang="ts" setup>
    import { useAuth } from '@/store/authContext';
    
    const auth = useAuth()

    function sendLogut(){
        auth.logout()
    }
</script>
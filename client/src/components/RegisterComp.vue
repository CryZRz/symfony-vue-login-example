<template lang="">
    <div>
        <form action="">
            <input type="text" placeholder="Ingresa tu correo" v-model="dataUser.email">
            <input type="text" placeholder="Ingresa tu contraseña" v-model="dataUser.password">
            <select v-model="dataUser.roles[0]">
                <option value="ROLE_USER">usuario</option>
                <option value="ROLE_ADMIN">administrador</option>
            </select>
            <button @click="sendDataUser">Registrarte</button>
        </form>
    </div>
</template>

<script lang="ts">
    import { defineComponent, ref } from 'vue';
    import { clientAuthFetch } from '@/utils/clientFetch';
    
    export default defineComponent({
        name: 'RegisterComp',
        setup() {
            let dataUser = ref(
                    {
                    email: "",
                    password: "",
                    roles: ["ROLE_USER"]
                }
            )

            async function sendDataUser(e: SubmitEvent){
                e.preventDefault();
                try {
                    await clientAuthFetch.post("/register", dataUser.value)
                    alert("Registrado correctamente")
                } catch (e) {
                    console.log(e)
                }
            }
            
            return {dataUser, sendDataUser}
        }    

    })
</script>

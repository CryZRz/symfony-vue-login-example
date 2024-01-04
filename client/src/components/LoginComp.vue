<template lang="">
    <form action="">
        <input type="emaik" placeholder="email" v-model="dataLogin.email">
        <input type="password" placeholder="password" v-model="dataLogin.password">
        <button @click="sendDataLogin">Ingresar</button>
    </form>
</template>

<script lang="ts">
    import { defineComponent, ref } from 'vue';
    import { useAuth} from '@/store/authContext';
    import { clientAuthFetch } from '@/utils/clientFetch';

    export default defineComponent({
        name: "LoginComp",
        setup() {
            const auth = useAuth()

            let dataLogin = ref({
                email: "",
                password: ""
            })

            async function sendDataLogin(e: SubmitEvent){
                e.preventDefault()
                try {
                    const response = await clientAuthFetch.post("/login", dataLogin.value)
                    auth.setToken(response.data.token)
                    auth.authStatus(true)
                    alert("logeado correctamente")
                } catch (e) {
                    console.log(e)
                }
            }

            return {dataLogin, sendDataLogin}
        }
    })
</script>
